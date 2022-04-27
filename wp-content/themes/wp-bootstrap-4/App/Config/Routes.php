<?php
declare(strict_types=1);

namespace App\Config;

use App\Utils\affiliateLinks;

/**
 * Class Routes
 * @package App\Config
 */
class Routes
{
    /**
     * Routes constructor.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerOffersRoute']);
    }

    /**
     * Offers route
     */
    public function registerOffersRoute()
    {
        register_rest_route(
            'custom/v1',
            'offers',
            [
                'methods'  => 'GET',
                'callback' => [$this, 'getOffers'],
            ]
        );

        register_rest_route(
            'custom/v1',
            'favourites',
            [
                'methods'  => 'POST',
                'callback' => [$this, 'setFavourite'],
            ]
        );

        register_rest_route(
            'custom/v1',
            'sort',
            [
                'methods'  => 'POST',
                'callback' => [$this, 'getOffers'],
            ]
        );
    }

    /**
     * @return bool
     */
    public function setFavourite(): bool
    {
        $payload = file_get_contents('php://input');
        $body = json_decode($payload);

        if (!isset($body->offer_id) || !isset($body->user_id)) {
            return false;
        }

        $user_id = $body->user_id;
        $offer_id = $body->offer_id;

        $user = get_userdata($body->user_id);

        if (!$user instanceof \WP_User) {
            return false;
        }

        $favourites = get_field('favourites', 'user_' . $body->user_id) ?: [];

        // # Toggle favourite key
        if (($key = array_search($offer_id, $favourites)) !== false) {
            unset($favourites[$key]);
        } else {
            $favourites[] = $offer_id;
        }

        return update_field('favourites', $favourites, 'user_' . $user_id);
    }

    /**
     * @return array|false
     */
    public function getOffers()
    {
        if (!isset($_GET['post_id']) || is_page($_GET['post_id'])) {
            return false;
        }

        $offers = get_field('offers', $_GET['post_id']) ?: [];
        $affliate_code = get_field('affliate_code', $_GET['post_id']);

        if (isset($_GET['favourites']) && isset($_GET['user_id']) && get_userdata($_GET['user_id'])) {
            $favourites = get_field('favourites', 'user_' . $_GET['user_id']) ?: [];
            $offers = array_intersect($offers, $favourites);
            if (empty($favourites)) {
                $offers = ['N/A'];
            }
        }

        $direction = (array_key_exists('direction',$_GET)) ? $_GET['direction'] : '';
        $order = (array_key_exists('sort',$_GET)) ? $_GET['sort'] : '';
        $query = [
            'post_type'   => 'offer',
            'fields'      => 'ids',
            'post__in'    => $offers,
            'orderby'     => $order,
            'order'       => $direction,
            'numberposts' => $_GET['per_page'] ?: -1,
            'offset'      => $_GET['offset'] ?: 0,
            's'           => $_GET['search'],
        ];

        if ($_GET['category']) {
            $query['cat'] = $_GET['category'];
        }

        $wp_query = new \WP_Query($query);

        $data = array_reduce(
            $wp_query->posts,
            function ($carry, $id) use ($affliate_code) {
                $categories = get_the_category($id);

                foreach ($categories as $category) {
                    switch ($category->slug) {
                        case 'fashion':
                            $category_id = $category->term_id;
                            $category_name = $category->name;
                            $category_color = '#A78BFA';
                            $category_icon = 'tshirt';
                            break;
                        case 'travel':
                            $category_id = $category->term_id;
                            $category_name = $category->name;
                            $category_color = '#F87171';
                            $category_icon = 'suitcase';
                            break;
                        case 'health-wellbeing':
                            $category_id = $category->term_id;
                            $category_name = $category->name;
                            $category_color = '#60A5FA';
                            $category_icon = 'stethoscope';
                            break;
                        case 'computers':
                            $category_id = $category->term_id;
                            $category_name = $category->name;
                            $category_color = '#9CA3AF';
                            $category_icon = 'desktop';
                            break;
                        case 'home-and-garden':
                            $category_id = $category->term_id;
                            $category_name = $category->name;
                            $category_color = '#34D399';
                            $category_icon = 'home';
                            break;
                    }
                }
                $affiliate_links = new affiliateLinks();
                $link_suffix =  $affiliate_links->get_link_suffix(get_field('affiliate_manager', $id),$affliate_code);

                $data = [
                    'id'          => $id,
                    'category'    => false,
                    'categories'  => array_map(function ($x) {
                        return $x->term_id;
                    }, $categories),
                    'image'       => [
                        'url' => get_the_post_thumbnail_url($id, 'x240'),
                        'alt' => get_post_meta(get_post_thumbnail_id($id), '_wp_attachment_image_alt', true),
                    ],
                    'name'        => html_entity_decode(get_the_title($id) ?: ''),
                    'description' => html_entity_decode(get_field('grid_text_long', $id) ?: ''),
                    'shortText'   => html_entity_decode(get_field('grid_text', $id) ?: ''),
                    'url'         => get_field('code_', $id) . $link_suffix,
                    'isFeatured'  => get_field('featured_offer', $id),
                    'isFavourite' => false,
                ];

                if (isset($category_color) && isset($category_icon) && isset($category_name) && isset($category_id)) {
                    $data['category'] = [
                        'id'    => $category_id,
                        'name'  => html_entity_decode($category_name),
                        'color' => $category_color,
                        'icon'  => $category_icon,
                    ];
                }

                if (isset($_GET['user_id']) && get_userdata($_GET['user_id']) instanceof \WP_User) {
                    $favourites = get_field('favourites', 'user_' . $_GET['user_id']) ?: [];
                    $data['isFavourite'] = in_array($id, $favourites);
                }

                $carry[] = $data;

                return $carry;
            },
            []
        );

        return [
            'results' => $data,
            'total'   => $wp_query->found_posts,
        ];
    }
}
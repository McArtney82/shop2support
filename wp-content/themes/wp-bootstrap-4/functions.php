<?php
/**
 * WP Bootstrap 4 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_4
 */

use App\Utils\affiliateLinks;

require ABSPATH.'vendor/autoload.php';
require get_template_directory().'/inc/acf.php';

if ( ! function_exists( 'wp_bootstrap_4_setup' ) ) :
	function wp_bootstrap_4_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'wp-bootstrap-4', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Enable Post formats
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'status', 'quote', 'link' ) );

		// Enable support for woocommerce.
		add_theme_support( 'woocommerce' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wp-bootstrap-4' ),
		) );

		// Switch default core markup for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_4_custom_background_args', array(
			'default-color' => 'f8f9fa',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_4_setup' );




new \App\Config\Assets();
new \App\Config\Routes();


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_4_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_bootstrap_4_content_width', 800 );
}
add_action( 'after_setup_theme', 'wp_bootstrap_4_content_width', 0 );




/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_4_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wp-bootstrap-4' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget border-bottom %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title h6">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'wp-bootstrap-4' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title h6">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'wp-bootstrap-4' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title h6">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'wp-bootstrap-4' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title h6">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'wp-bootstrap-4' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'wp-bootstrap-4' ),
		'before_widget' => '<section id="%1$s" class="widget wp-bp-footer-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title h6">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'wp_bootstrap_4_widgets_init' );




/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_4_scripts() {
	wp_enqueue_style( 'open-iconic-bootstrap', get_template_directory_uri() . '/assets/css/open-iconic-bootstrap.css', array(), 'v4.0.0', 'all' );
	wp_enqueue_style( 'bootstrap-4', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), 'v4.0.0', 'all' );
	wp_enqueue_style( 'wp-bootstrap-4-style', get_stylesheet_uri(), array(), '1.0.2', 'all' );
	wp_enqueue_style( 'iphoneinstalloverlay',get_template_directory_uri() . '/assets/css/plugin.css' );

	wp_enqueue_script( 'bootstrap-4-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), 'v4.0.0', true );
	wp_enqueue_script( 'iphoneinstalloverlayjs', get_template_directory_uri() . '/assets/js/plugin.js', array(), '1.0.0', true );
	wp_enqueue_script( 'ajax_loading', get_template_directory_uri().'/assets/js/ajax-loading.js', array( 'jquery' ), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_4_scripts' );


/**
 * Registers an editor stylesheet for the theme.
 */
function wp_bootstrap_4_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'wp_bootstrap_4_add_editor_styles' );


// Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';

// Implement the Custom Comment feature.
require get_template_directory() . '/inc/custom-comment.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom Navbar
require get_template_directory() . '/inc/custom-navbar.php';

// Customizer additions.
require get_template_directory() . '/inc/tgmpa/tgmpa-init.php';

// Use Kirki for customizer API
require get_template_directory() . '/inc/theme-options/add-settings.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Load WooCommerce compatibility file.
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}



function create_manifest_for_app( $post_id ) {

	$pageTemplate = get_post_meta($post_id, '_wp_page_template', true);

  if($pageTemplate == 'apptemplate.php' ){

		$manifest_name = (str_replace(' ', '-', strtolower(get_the_title( $post_id ))).'-manifest.json');
		$app_icon = get_field('app_icon');

		$icons = array();

		$icons[] = array('src'=>$app_icon["sizes"]["72x72"],'sizes'=>"72x72",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["96x96"],'sizes'=>"96x96",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["128x128"],'sizes'=>"128x128",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["144x144"],'sizes'=>"144x144",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["152x152"],'sizes'=>"152x152",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["192x192"],'sizes'=>"192x192",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["384x384"],'sizes'=>"384x384",'type'=>"image/png");
		$icons[] = array('src'=>$app_icon["sizes"]["512x512"],'sizes'=>"512x512",'type'=>"image/png");

		$manifest = array();
		$manifest['name'] = get_the_title( $post_id );
		$manifest['short_name'] = get_field('short_name');
		$manifest['theme_color'] = get_field('theme_colour');
		$manifest['background_color'] = get_field('theme_colour');
		$manifest['display'] = 'standalone' ;
		$manifest['scope'] = str_replace(home_url(), '', get_permalink($post_id)).'?utm_source=homescreen';
		$manifest['start_url'] = str_replace(home_url(), '', get_permalink($post_id)).'?utm_source=homescreen';
		$manifest['orientation'] = "portrait";
		$manifest['icons'] = $icons;
		$manifest['splash_pages'] = '';

    //create or overwrite the manifest
		//$fp = fopen(get_template_directory_uri().'/manifests/'.$manifest_name , 'w');

		$fp = fopen($_SERVER['DOCUMENT_ROOT'].parse_url( get_stylesheet_directory_uri(), PHP_URL_PATH ).'/manifests/'.$manifest_name , 'w');

		fwrite($fp, json_encode($manifest,JSON_UNESCAPED_SLASHES));
		fclose($fp);

		//duplicate the serviceworker and imap_rename
		$sw_name = (str_replace(' ', '-', strtolower(get_the_title( $post_id ))).'-sw.js'); //for the service worker
		$file = get_site_url().'service-worker.js';
		$new_file = get_site_url() . '/'.$sw_name;
		copy($file, $newfile);


  }
}
add_action( 'save_post', 'create_manifest_for_app' );

add_theme_support( 'post-thumbnails' );
add_image_size( '512x512', 512, 512 );
add_image_size( '384x384', 384, 384 );
add_image_size( '192x192', 192, 192 );
add_image_size( '144x144', 144, 144 );
add_image_size( '152x152', 152, 152 );
add_image_size( '128x128', 128, 128 );
add_image_size( '96x96', 96, 96 );
add_image_size( '72x72', 72, 72 );

add_action('wp_ajax_nopriv_load_offers', 'loadmore_ajax_handler');
add_action('wp_ajax_load_offers', 'loadmore_ajax_handler');

add_action('wp_ajax_nopriv_load_favourites', 'loadfavourites_ajax_handler');
add_action('wp_ajax_load_favourites', 'loadfavourites_ajax_handler');

add_action('wp_ajax_nopriv_add_favourites', 'addfavourites_ajax_handler');
add_action('wp_ajax_add_favourites', 'addfavourites_ajax_handler');

add_action('wp_ajax_nopriv_remove_favourites', 'removefavourites_ajax_handler');
add_action('wp_ajax_remove_favourites', 'removefavourites_ajax_handler');

function loadmore_ajax_handler(){
	$html = ''; //the return variable
	$offset = $_POST['offset'];
	$html .= '<script>console.log("The initial offset value passed was: '.$offset.'")</script>';
	$p_id = $_POST['pid'];

	$affiliate_code = str_replace(' ', '',get_field('affliate_code',$p_id));
	$current_rsp_offers_posts = get_field('offers',$p_id);

	global $post;
	while($count <= $count + 6){



				$count ++;

				$post = $current_rsp_offers_posts[$count + $offset];
				setup_postdata($post);
				if($count == 7){
					$return = array('content' => $html,'end'=>0,'offset'=>$offset + 6);
					wp_send_json($return);
					wp_die();
				}

				if($count + $offset >= count($current_rsp_offers_posts)){
					$return = array('content' => $html,'end'=>1,'offset'=>'999999');
					wp_send_json($return);
					wp_die();
				}

			    $url =  get_post_meta(get_the_ID(), 'code_',true);
			    $affiliate_manager = get_post_meta(get_the_ID(), 'affiliate_manager',true);
			    $link_suffix = affiliateLinks::get_link_suffix($affiliate_manager,$affiliate_code);

			    $featured = get_post_meta(get_the_ID(), 'featured_offer',true);
			    //$grid_text = get_post_meta(get_the_id(),'grid_text',true);
			    //$grid_text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed faucibus sollicitudin tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.";
				$categories = get_the_category(get_the_ID());
				$filterstring = "";
				foreach ($categories as $category){
					$filterstring .= $category->slug." ";
				}
				if($featured){
					$filterstring .= "featured ";
				}
				if(strpos($filterstring, 'fashion') !== false ){
					$cat_color = '#f89d4d';
				    $cat_icon = '<i class="fas fa-tshirt"></i>';
				} elseif(strpos($filterstring, 'travel') !== false ){
					$cat_color = '#adde75';
				    $cat_icon = '<i class="fas fa-suitcase"></i>';
				} elseif(strpos($filterstring, 'health-wellbeing') !== false ){
					$cat_color = '#75dddc';
				    $cat_icon = '<i class="fas fa-stethoscope"></i>';
				} elseif(strpos($filterstring, 'computers') !== false ){
					$cat_color = '#f64444';
				    $cat_icon = '<i class="fas fa-desktop"></i>';
				} elseif(strpos($filterstring, 'home-and-garden') !== false ){
					$cat_color = '#fb81ff';
				    $cat_icon = '<i class="fas fa-home"></i>';
				} else { //catch all general shopping
					$cat_color = '#cb81ff';
					$cat_icon = '<i class="fas fa-shopping-cart"></i>';
				}


				$html .= '<div class="grid-item col-12 col-md-4 px-3 py-0 pt-md-3 mb-1 ' . $filterstring . 'filter-all" data-id="'.get_the_ID().'">';
				$html .= '<div class="row">';
				$html .= '<div class="col-1 col-md-12 order-md-last cat-strip p-0" style="background-color:'.$cat_color.';color:#ffffff"><div class="h-100 p-md-1"><p class="text-center p-1">'.$cat_icon.'</p></div></div>';
				$html .= '<div class="col-3 col-md-6 offset-md-4 mx-md-auto my-auto"><a href="'.$url.$link_suffix.'">'.get_the_post_thumbnail(null,'thumb').'</div></a>';
				$html .= '<div class="col-8 col-md-12 my-4 '.$count.'"><p>'.get_field('grid_text_long',get_the_ID()).'</p>';
				$html .= '<p class="add-favourites"><i class="fa-star far" data-id="'.get_the_ID().'"></i> <strong>Add To Favourites</strong></p>';
				$html .= '<div class="row">';
				$html .= '<div class="col-6 my-auto offer-details">'.get_field('grid_text',get_the_ID()).'</div>';
				$html .= '<div class="col-6 col-md-12 mt-md-1"><a target="_blank" href="'.$url.$link_suffix.'"><button type="button" class="btn btn-success" style="float:left">Shop Now</button></a></div>';
				$html .= '</div>';//row
				$html .= '</div>';//col-8
				$html .= '</div>';//col-12
				$html .= '</div>';//row

	}
	$return = array('content' => $html,'end'=>1,'offset'=>'999999');
	wp_send_json($return);
	wp_die();
}

function loadfavourites_ajax_handler(){
	$html = ''; //the return variable
	$html .= '<script>console.log("The initial offset value passed was: '.$offset.'")</script>';
	$p_id = $_POST['pid'];
	$favourites_shown = $_POST['favourites_shown'];

	$affiliate_code = str_replace(' ', '',get_field('affliate_code',$p_id));
	$favourites = get_field('favourites','user_'.get_current_user_id());

	global $post;
	foreach ($favourites as $post){
				setup_postdata($post);
					if(in_array(get_the_ID(),$favourites_shown)){
						continue;
					}
		    	$url =  get_post_meta(get_the_ID(), 'code_',true);
			    $affiliate_manager = get_post_meta(get_the_ID(), 'affiliate_manager',true);
                $link_suffix = affiliateLinks::get_link_suffix($affiliate_manager,$affiliate_code);

			    $featured = get_post_meta(get_the_ID(), 'featured_offer',true);
			    //$grid_text = get_post_meta(get_the_id(),'grid_text',true);
			    //$grid_text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed faucibus sollicitudin tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.";
				$categories = get_the_category(get_the_ID());
				$filterstring = "";
				foreach ($categories as $category){
					$filterstring .= $category->slug." ";
				}
				if($featured){
					$filterstring .= "featured ";
				}
				$filterstring .= "favourites temp ";


				if(strpos($filterstring, 'fashion') !== false ){
					$cat_color = '#f89d4d';
				    $cat_icon = '<i class="fas fa-tshirt"></i>';
				} elseif(strpos($filterstring, 'travel') !== false ){
					$cat_color = '#adde75';
				    $cat_icon = '<i class="fas fa-suitcase"></i>';
				} elseif(strpos($filterstring, 'health-wellbeing') !== false ){
					$cat_color = '#75dddc';
				    $cat_icon = '<i class="fas fa-stethoscope"></i>';
				} elseif(strpos($filterstring, 'computers') !== false ){
					$cat_color = '#f64444';
				    $cat_icon = '<i class="fas fa-desktop"></i>';
				} elseif(strpos($filterstring, 'home-and-garden') !== false ){
					$cat_color = '#fb81ff';
				    $cat_icon = '<i class="fas fa-home"></i>';
				} else { //catch all general shopping
					$cat_color = '#cb81ff';
					$cat_icon = '<i class="fas fa-shopping-cart"></i>';
				}


				$html .= '<div class="grid-item col-12 col-md-4 px-3 py-0 pt-md-3 mb-1 ' . $filterstring . 'filter-all " data-id="'.get_the_ID().'">';
				$html .= '<div class="row">';
				$html .= '<div class="col-1 col-md-12 order-md-last cat-strip p-0" style="background-color:'.$cat_color.';color:#ffffff"><div class="h-100 p-md-1"><p class="text-center p-1">'.$cat_icon.'</p></div></div>';
				$html .= '<div class="col-3 col-md-6 offset-md-4 mx-md-auto my-auto"><a href="'.$url.$link_suffix.'">'.get_the_post_thumbnail(null,'thumb').'</div></a>';
				$html .= '<div class="col-8 col-md-12 my-4 '.$count.'"><p>'.get_field('grid_text_long',get_the_ID()).'</p>';
				$html .= '<p><i class="fa-star fas add-favourites" data-id="'.get_the_ID().'"></i> <strong>Add To Favourites</strong></p>';
				$html .= '<div class="row">';
				$html .= '<div class="col-6 my-auto offer-details">'.get_field('grid_text',get_the_ID()).'</div>';
				$html .= '<div class="col-6 col-md-12 mt-md-1"><a target="_blank" href="'.$url.$link_suffix.'"><button type="button" class="btn btn-success" style="float:left">Shop Now</button></a></div>';
				$html .= '</div>';//row
				$html .= '</div>';//col-8
				$html .= '</div>';//col-12
				$html .= '</div>';//row

	}
	$return = array('content' => $html);
	wp_send_json($return);
	wp_die();
}

function addfavourites_ajax_handler(){
	$offer_id = $_POST['offer_id'];
	$favourites = get_field('favourites','user_'.get_current_user_id());
	$favourites[] = $offer_id;
	return update_field('favourites',$favourites,'user_'.get_current_user_id());
}

function removefavourites_ajax_handler(){
	$offer_id = $_POST['offer_id'];
	$favourites = get_field('favourites','user_'.get_current_user_id());
	if (($key = array_search($offer_id, $favourites)) !== false) {
    unset($favourites[$key]);
	}
	return update_field('favourites',$favourites,'user_'.get_current_user_id());
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

add_filter( 'login_head', 'custom_login' );

function custom_login(){
    echo '<style type="text/css"> .login #backtoblog, .login #nav {display:none!important}
.login h1 a {display:none!important} .reset-pass a{display:none}</style>';
}

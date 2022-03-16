<?php

declare(strict_types=1);

namespace App\Config;

use App\Utils\Path;

/**
 * Class Assets
 * @package App\Config
 */
class Assets
{
    /**
     * Assets constructor.
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], PHP_INT_MAX);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], PHP_INT_MAX);
        add_filter('script_loader_src', [$this, 'assetsVersioning'], PHP_INT_MAX, 2);

        add_action( 'after_setup_theme', function() {
            add_image_size( 'x240', 0, 240, false );
        } );
    }

    /**
     * Enqueue scripts.
     */
    public function enqueueScripts(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_enqueue_script('qv-script', Path::distURI().'/js/_app.min.js', [], null, true);
        wp_enqueue_script('3rd-select', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [], null, true);
    }

    /**
     * Enqueue styles.
     */
    public function enqueueStyles(): void
    {
        #wp_dequeue_style('reset');
        #wp_dequeue_style('introjsCSS');
        #wp_dequeue_style('jquery-ui');

        wp_enqueue_style('qv-style', Path::distURI().'/css/_app.min.css');
    }

    /**
     * @param string|null $src
     * @param string $handle
     *
     * @return string|null
     */
    public function assetsVersioning(?string $src, string $handle): ?string
    {
        if (empty($src)) {
            return null;
        }

        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }

        if (!in_array($handle, ['autocomplete-js'], true)) {
            $src .= '?ver=664';
        }

        return $src;
    }
}

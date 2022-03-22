<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_4
 */

$image = get_field('client_logo');
$size = 'full';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
    global $post;
    $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
    if ($pageTemplate == 'apptemplate.php') {
        $app_icon = get_field('app_icon');
        $manifest_name = (str_replace(' ', '-', strtolower(get_the_title())) . '-manifest.json');
        ?>
        <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifests/<?php echo $manifest_name ?>">
        <link rel="apple-touch-icon" href="<?php echo $app_icon["sizes"]["144x144"]; ?>">
        <link rel="apple-touch-icon" sizes="192x192" href="<?php echo $app_icon["sizes"]["192x192"]; ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $app_icon["sizes"]["152x152"]; ?>">
        <link rel="apple-touch-icon" sizes="128x128" href="<?php echo $app_icon["sizes"]["128x128"]; ?>">
        <link rel="apple-touch-icon" sizes="96x96" href="<?php echo $app_icon["sizes"]["96x96"]; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $app_icon["sizes"]["72x72"]; ?>">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <meta name="theme-color" content="#2196f3">
        <meta name="background-color" content="#2196f3">

        <meta name="msapplication-TileImage"
              content="<?php echo get_template_directory_uri(); ?>/images/icon-144x144.png">
        <meta name="msapplication-TileColor" content="#2196f3">

        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">-->

        <meta name="apple-mobile-web-app-capable" content="yes">

        <?php
    }
    wp_head();
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XJ3NLVKPW9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-XJ3NLVKPW9');
    </script>
</head>
<?php global $current_user;
wp_get_current_user(); ?>
<body <?php body_class(); ?>>
<div id="page" class="site _font-sans">

    <header>
        <div class="o-container _pt-12 _pb-8">
            <?php if ($image) : ?>
                <div class="_text-center _mb-4">
                    <div class="_inline-block">
                        <img src="<?= $image; ?>"
                             alt="Logo <?= get_the_title()?>"
                             class="_max-w-40 _max-h-40"
                        />
                    </div>
                    <?php if (is_user_logged_in()) : ?>
                        <div>
                            Welcome, <?= $current_user->user_login ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div><!-- /.container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">

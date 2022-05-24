<?php

require_once __DIR__ . '/wp-load.php';

/*$args = [
    'post_type'      => 'offer',
    'posts_per_page' => -1,
    'post_status' => 'publish',
];


// The Query
$the_query = new WP_Query( $args );

// The Loop
while ( $the_query->have_posts() ) {
    $the_query->the_post();
    update_field('link_status','');
    update_field('last_checked','');
}

wp_reset_postdata();*/
$testLinkAdmin = new \s2sLinkHealth\admin();
$testLinkAdmin->cronCheckS2SLinks(true);



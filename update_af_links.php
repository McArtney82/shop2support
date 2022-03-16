<?php

require_once __DIR__ . '/wp-load.php';

/*$args = [
    'post_type'      => 'offer',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => 'code_',
            'value'   => 't.cfjump.com/56388',
            'compare' => 'LIKE'
        ]
    ]
];


// The Query
$the_query = new WP_Query( $args );

// The Loop
while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $current_link = get_field('code_',get_the_ID());
    $new_link = str_replace('/56388/','/77955/',$current_link);
    update_field('code_',$new_link,get_the_ID());
}*/

$args = [
    'post_type'      => 'offer',
    'posts_per_page' => -1,
    'meta_query'     => [
        [
            'key'     => 'code_',
            'value'   => 't.cfjump.com/56388',
            'compare' => 'LIKE'
        ]
    ]
];


// The Query
$the_query = new WP_Query( $args );

// The Loop
while ( $the_query->have_posts() ) {
    $the_query->the_post();
    $current_link = get_field('code_',get_the_ID());
    $new_link = str_replace('/56388/','/77955/',$current_link);
    update_field('code_',$new_link,get_the_ID());
}



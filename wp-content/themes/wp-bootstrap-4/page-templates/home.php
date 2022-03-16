<?php
/*
* Template Name: Home New
*/

get_header(); ?>
<style>
    
    body{
        background-color: #fff!important;
    }

    footer{
        display:none!important;
    }
</style>
    <div class="">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div class="row">
                    <div class="col-4 offset-4 text-center">
                        <?= get_the_post_thumbnail($post,[300,330]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 offset-1 text-center">
                        <?php
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content', 'page-full' );

                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;

                        endwhile; // End of the loop.
                        ?>
                    </div>
                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>

<?php
get_footer();

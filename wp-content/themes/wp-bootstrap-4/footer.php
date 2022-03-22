<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_4
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="_mt-12 _border-t _bg-gray-900 _text-white _pt-8 _pb-4 fixed-bottom">
        <div class="o-container">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <aside class="widget-area footer-1-area mb-2">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </aside>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <aside class="widget-area footer-2-area mb-2">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </aside>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <aside class="widget-area footer-3-area mb-2">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </aside>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <aside class="widget-area footer-4-area mb-2">
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                </aside>
            <?php endif; ?>
        </div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

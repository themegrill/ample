<?php
/**
 * Page Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

get_header();

   do_action( 'ample_before_body_content' ); ?>

   <div class="single-page clearfix">
      <div class="inner-wrap">
         <div id="primary">
            <div id="content">

               <?php while ( have_posts() ) : the_post(); ?>

                  <?php get_template_part( 'content', 'page' ); ?>

                  <?php
                     do_action( 'ample_before_comments_template' );
                     // If comments are open or we have at least one comment, load up the comment template
                     if ( comments_open() || '0' != get_comments_number() )
                        comments_template();
                     do_action ( 'ample_after_comments_template' );
                  ?>
               <?php endwhile; ?>
            </div>
            <?php ample_both_sidebar_select(); ?>
         </div>

         <?php ample_sidebar_select(); ?>
      </div><!-- .inner-wrap -->
   </div><!-- .single-page -->

   <?php do_action( 'ample_after_body_content' );
get_footer(); ?>
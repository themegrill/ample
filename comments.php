<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to ample_comment() which is
 * located in the inc/functions.php file.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
   return;
?>

<div id="comments" class="comments-area">

   <?php // You can start editing here -- including this comment! ?>

   <?php if ( have_comments() ) : ?>
      <h3 class="comments-title">
         <?php
            printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'ample' ),
               number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
         ?>
      </h3>

      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
      <nav id="comment-nav-above" class="comment-navigation clearfix" role="navigation">
         <h3 class="screen-reader-text"><?php _e( 'Comment navigation', 'ample' ); ?></h3>
         <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ample' ) ); ?></div>
         <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ample' ) ); ?></div>
      </nav><!-- #comment-nav-above -->
      <?php endif; // check for comment navigation ?>

      <ul class="comment-list">
         <?php
            wp_list_comments( array(
               'callback'    => 'ample_comment',
               'short_ping'  => true
            ) );
         ?>
      </ul><!-- .comment-list -->

      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
      <nav id="comment-nav-below" class="comment-navigation clearfix" role="navigation">
         <h3 class="screen-reader-text"><?php _e( 'Comment navigation', 'ample' ); ?></h3>
         <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ample' ) ); ?></div>
         <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ample' ) ); ?></div>
      </nav><!-- #comment-nav-below -->
      <?php endif; // check for comment navigation ?>

   <?php endif; // have_comments() ?>

   <?php
      // If comments are closed and there are comments, let's leave a little note, shall we?
      if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
   ?>
      <p class="no-comments"><?php _e( 'Comments are closed.', 'ample' ); ?></p>
   <?php endif; ?>

   <?php comment_form(); ?>
</div><!-- #comments -->
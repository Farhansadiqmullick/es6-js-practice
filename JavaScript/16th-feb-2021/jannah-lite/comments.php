<?php
defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}

if (number_format_i18n(get_comments_number())!=0) {
    ?>
    <div class="comments-section">
        <h3 class="post-module-title"><?php printf(_n('One Comment','%s Comments',get_comments_number(),'jannah-lite'),number_format_i18n( get_comments_number() )); ?></h3>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'jannah-lite' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'jannah-lite' ) ); ?></div>
			</nav>
        <?php endif;?>
        
        <ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size'  => 70
				) );
			?>
		</ol>
    </div>
    <?php
}

?>
<div class="give-your-reply">

    <?php if ( ! comments_open() ) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed','jannah-lite'); ?></p>
    <?php endif; ?>

    <?php 
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? ' required' : '' );
    $required_text = '  ';
    $args = array(
        'id_form'           => 'commentForm',
        'class_form'        =>'comment-form',
        'title_reply'       => __('Leave a Reply', 'jannah-lite'),
        'submit_button'      =>'<button type="submit">'.esc_html__('Post Comment','jannah-lite').'</button>',
        'fields' => apply_filters( 'comment_form_default_fields', 
            array(
                'author' => '<div class="row"><div class="col-lg-6">
									<label>'.esc_html__('Name *', 'jannah-lite').'<br/>
										<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' placeholder="' . esc_html__( 'Enter your name here..','jannah-lite') . '" />
									</label>
								</div>',
					'email' => ' <div class="col-lg-6">
									<label>'.esc_html__('Email *', 'jannah-lite').'<br/>
										<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' placeholder="' . esc_html__( 'Enter your mail here..','jannah-lite') . '" />
									</label>
								</div></div>'
            )
        ),
        'comment_field' =>  '<label>'.esc_html__('Comment *', 'jannah-lite').'<br/>
										<textarea name="comment"'.$aria_req.' rows="8" placeholder="'.esc_html__('Enter your comment here..','jannah-lite').'"></textarea>
                                    </label>',
        'label_submit' => esc_html__('Post Comment','jannah-lite'),
    );

    comment_form($args);
    ?>
</div>
<?php 
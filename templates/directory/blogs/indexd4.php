<?php

/**
 * BuddyPress - Blogs Directory
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
if ( !defined( 'ABSPATH' ) ) exit;

get_header( vibe_get_header() ); 

$id= vibe_get_bp_page_id('blogs'); 

$header = vibe_get_customizer('header_style');
if($header == 'transparent' || $header == 'generic'){
    echo '<section id="title"><div class="container"><div class="pagetitle"><h1>'.get_the_title($id).'</h1></div></div></section>';
}

$flag=1;

$capability=vibe_get_option('blog_create');
if(isset($capability)){
	$flag=0;
	switch($capability){
                case 1: 
			$flag=1;
		break;
		case 2: 
			if(current_user_can('edit_posts'))
			$flag=1;
		break;
		case 3:
			if(current_user_can('manage_options'))
			$flag=1;
		break;
	}

}
?>
<section id="content">
	<div id="buddypress">
	    <div class="<?php echo vibe_get_container(); ?>">
			<?php do_action( 'bp_before_directory_blogs_page' ); ?>
			<div id="padder">
			<?php do_action( 'bp_before_directory_blogs' ); ?>

			<form action="" method="post" id="blogs-directory-form" class="dir-form">
				<div class="row">	
					<div class="col-md-9 col-sm-9 col-md-push-3 col-sm-push-3">	
						<div class="pagetitle">
							<div class="col-md-8">
								<h1><?php echo get_the_title($id); ?></h1>
		                    	<?php the_sub_title($id); ?>
		                	</div>
		                	<div class="col-md-4">
								<div id="blog-dir-search" class="dir-search" role="search">
									<?php bp_directory_blogs_search_form(); ?>
								</div><!-- #blog-dir-search -->
							</div>
		                </div>

			            <?php do_action( 'bp_before_directory_blogs_content' ); ?>
						<?php do_action( 'template_notices' ); ?>

							

							<div class="item-list-tabs" id="subnav" role="navigation">
								<ul>
									<?php do_action( 'bp_blogs_directory_blog_sub_types' ); ?>
									<li class="switch_view">
										<div class="grid_list_wrapper">
											<a id="list_view" class="active"><i class="icon-list-1"></i></a>
											<a id="grid_view"><i class="icon-grid"></i></a>
										</div>
									</li>
									<li id="blogs-order-select" class="last filter">

										<label for="blogs-order-by"><?php _e( 'Order By:', 'vibe' ); ?></label>
										<select id="blogs-order-by">
											<option value="active"><?php _e( 'Last Active', 'vibe' ); ?></option>
											<option value="newest"><?php _e( 'Newest', 'vibe' ); ?></option>
											<option value="alphabetical"><?php _e( 'Alphabetical', 'vibe' ); ?></option>

											<?php do_action( 'bp_blogs_directory_order_options' ); ?>

										</select>
									</li>
								</ul>
							</div>

							<div id="blogs-dir-list" class="blogs dir-list">

								<?php locate_template( array( 'blogs/blogs-loop.php' ), true ); ?>

							</div><!-- #blogs-dir-list -->

							<?php do_action( 'bp_directory_blogs_content' ); ?>

							<?php wp_nonce_field( 'directory_blogs', '_wpnonce-blogs-filter' ); ?>

							<?php do_action( 'bp_after_directory_blogs_content' ); ?>
						</div>
					<div class="col-md-3 col-sm-3  col-md-pull-9 col-sm-pull-9">
						<div class="item-list-tabs" role="navigation">
							<ul>
								<li class="selected" id="blogs-all"><a href="<?php bp_root_domain(); ?>/<?php bp_blogs_root_slug(); ?>"><?php printf( __( 'All Sites <span>%s</span>', 'vibe' ), bp_get_total_blog_count() ); ?></a></li>

								<?php if ( is_user_logged_in() && bp_get_total_blog_count_for_user( bp_loggedin_user_id() ) ) : ?>

									<li id="blogs-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_blogs_slug(); ?>"><?php printf( __( 'My Sites <span>%s</span>', 'vibe' ), bp_get_total_blog_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

								<?php endif; ?>

								<?php do_action( 'bp_blogs_directory_blog_types' ); ?>

							</ul>
						</div><!-- .item-list-tabs -->
						<?php if ( is_user_logged_in() && bp_blog_signup_enabled() && $flag ) : ?> &nbsp;
		            		<a class="button create-group-button full" href="<?php echo bp_get_root_domain() . '/' . bp_get_blogs_root_slug() . '/create/' ?>">
		            		<?php _e( 'Create a Site', 'vibe' ); ?></a>
		            	<?php 
		            	 endif; ?>
						<?php
					 		$sidebar = apply_filters('wplms_sidebar','buddypress',$id);
			                if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : ?>
		               	<?php endif; ?>
					</div>
				</div>
			</form><!-- #blogs-directory-form -->

			<?php do_action( 'bp_after_directory_blogs' ); ?>

			</div><!-- .padder -->
		</div><!-- #content -->

		<?php do_action( 'bp_after_directory_blogs_page' ); ?>
	</div>
</section>	
<?php get_footer( vibe_get_footer() ); 
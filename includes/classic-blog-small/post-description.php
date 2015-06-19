<!-- BEGIN .small-post-content -->
<div class="small-post-content">

<?php
	$id_obj = get_category_by_slug( 'dvd-reviews' );
	$id = $id_obj->term_id;
 	if(has_category($id)) { ?>
        <div class="rating">
<?php       $rating = 0;
            $rating = get_field('rating');

        	foreach (range(0, 4) as $i) { ?>
				<div class="<?php
				if($i < $rating && $i+1 > $rating){
					echo 'rate-half';
				}elseif($i <= $rating){ 
					echo 'rate-full'; 
				}
				?>"></div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="float-right">
		<?php get_template_part ( 'includes/hb' , 'share' ); ?>
	</div>

	<h3 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

	<?php 
	if ( has_excerpt() ) echo get_the_excerpt();
	else
	{
		echo wp_trim_words ( strip_shortcodes ( get_the_content() ) , hb_options('hb_blog_excerpt_length') , '...' );
	}
	?>
</div>
<!-- END .small-post-content -->

<div class="clear"></div>

<div class="meta-info clearfix">
	<div class="float-left">
		<?php if ( hb_options('hb_blog_enable_by_author') ) { ?>
			<span class="vcard"><?php _e('By ', 'hbthemes'); ?><span class="fn"><a href="<?php echo get_author_posts_url ( get_the_author_meta ('ID') ); ?>" title="<?php _e('Posts by ','hbthemes'); the_author_meta('display_name');?>" rel="author"><?php the_author_meta('display_name'); ?></a></span></span>
			<span class="text-sep">|</span>
		<?php } ?>

		<?php if ( hb_options('hb_blog_enable_date') ) { ?>
			<span class="updated" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></span>
			<span class="text-sep">|</span>
		<?php } ?>

		<?php 
		$categories = get_the_category();
		if ( $categories && hb_options('hb_blog_enable_categories') ) {
		?>
			<!-- Category info -->
			<span class="blog-categories minor-meta"> 
				<?php
				$cat_count = count($categories);
				foreach($categories as $category) { 
					$cat_count--;
					?>
					<a href="<?php echo get_category_link( $category->term_id ); ?>" title="<?php echo esc_attr( sprintf( __( "View all posts in %s", "hbthemes" ), $category->name ) ); ?>"><?php echo $category->cat_name; ?></a><?php if ( $cat_count > 0 ) echo ', '; ?>			
				<?php } ?>
				<span class="text-sep">|</span>
		<?php } ?>
			
		<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
			<span class="comment-container minor-meta">
				<a href="<?php the_permalink (); ?>#comments" class="comments-link" title="<?php printf ( __("Comment on %s" , "hbthemes" ) , get_the_title()); ?>">
					<?php comments_number( __( '0 comments' , 'hbthemes' ) , __( '1 comment' , 'hbthemes' ), __( '% comments' , 'hbthemes' ) ); ?> 
				</a>
			</span>
			<span class="text-sep">|</span>
			</span>

		<?php } ?>	
	</div>

	<div class="float-right"><a href="<?php the_permalink(); ?>" class="read-more-button"><?php _e('Read More ' , 'hbthemes'); ?><i class="icon-double-angle-right"></i></a></div>
</div>
<!-- END .meta-info -->

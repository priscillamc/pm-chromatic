<?php
/**
 * Template to display single post content on archive pages
 * Archive Post Style: Medium Thumbnail
 */
?>

<article <?php hoot_attr( 'post', '', 'archive-medium' ); ?>>

	<div class="entry-grid hgrid">

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-grid-side hgrid-span-5">
				<?php
				$img_size = apply_filters( 'hoot_post_image_archive_medium', 'hoot-medium-preview' );
				hoot_post_thumbnail( 'entry-content-featured-img entry-grid-featured-img', $img_size, true, get_permalink() );
				?>
			</div>
		<?php endif; ?>

		<?php $content_grid_span = ( has_post_thumbnail() ) ? 'hgrid-span-7' : 'hgrid-span-12'; ?>
		<div class="entry-grid-content <?php echo $content_grid_span; ?>">

			<header class="entry-header">
				<?php the_title( '<h2 ' . hoot_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php if ( is_sticky() ) : ?>
				<div class="entry-sticky-tag"><?php _e( 'Sticky', 'chromatic-premium' ) ?></div>
			<?php endif; ?>

			<div class="screen-reader-text" itemprop="datePublished" itemtype="https://schema.org/Date"><?php echo get_the_date('Y-m-d'); ?></div>
			<?php hoot_meta_info_blocks( hoot_get_mod('archive_post_meta'), 'archive-medium' ); ?>

			<?php
			$archive_post_content = hoot_get_mod('archive_post_content');
			if ( 'full-content' == $archive_post_content ) {
				?><div <?php hoot_attr( 'entry-summary', 'content' ); ?>><?php
					the_content();
				?></div><?php
				wp_link_pages();
			} elseif ( 'excerpt' == $archive_post_content ) {
				?><div <?php hoot_attr( 'entry-summary', 'excerpt' ); ?>><?php
					the_excerpt();
				?></div><?php
			}
			?>

		</div><!-- .entry-grid-content -->

	</div><!-- .entry-grid -->

</article><!-- .entry -->
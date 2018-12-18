<?php
/**
 * Template to display single post content on archive pages
 * Archive Post Style: Small Thumbnail
 */
?>

<article <?php hoot_attr( 'post', '', 'archive-small' ); ?>>

	<div class="entry-grid hgrid">

		<?php $content_grid_span = 'hgrid-span-12'; ?>
		<div class="entry-grid-content <?php echo $content_grid_span; ?>">

			<header class="entry-header">
				<?php the_title( '<h2 ' . hoot_get_attr( 'entry-title' ) . '><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php if ( is_sticky() ) : ?>
				<div class="entry-sticky-tag"><?php _e( 'Sticky', 'chromatic-premium' ) ?></div>
			<?php endif; ?>

			<?php
			$archive_post_content = hoot_get_mod('archive_post_content');
			if ( 'full-content' == $archive_post_content ) {
				?><div <?php hoot_attr( 'entry-summary', 'content' ); ?>><?php
					the_content( '' );
				?></div><?php
				wp_link_pages();
			} elseif ( 'excerpt' == $archive_post_content ) {
				?><div <?php hoot_attr( 'entry-summary', 'excerpt' ); ?>><?php
					the_excerpt();
				?></div><?php
			}
			?>
			
			<div class="screen-reader-text" itemprop="datePublished" itemtype="https://schema.org/Date"><?php echo get_the_date('Y-m-d'); ?></div>
			<?php hoot_meta_info_blocks( hoot_get_mod('archive_post_meta'), 'archive-small' ); ?>

		</div><!-- .entry-grid-content -->

	</div><!-- .entry-grid -->

</article><!-- .entry -->
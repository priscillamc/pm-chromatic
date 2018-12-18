<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION

/**
 * Change the meta block content
 * 
 * @param  array $blocks
 * @param  string $context 
 * @param  string $display
 * @param  string $editlink
 * @return array
 */
function pm_chromatic_meta_info_blocks( $blocks, $context, $display, $editlink ){
	
	// Display last modified date for posts
	if ( !empty( $display['date'] ) ) :
		if ( is_category() || is_tag() || is_singular('post') ):
			$blocks['date']['label'] = __( 'Updated', 'pm-chromatic' );
			$blocks['date']['content'] = '<time ' . hoot_get_attr( 'entry-published' ) . '>' . get_the_modified_date() . '</time>';
		endif;
	endif;
	
	// Display project types on archive and singular pages
	if ( !empty( $display['cats'] ) && (is_post_type_archive( 'jetpack-portfolio' ) || is_singular( 'jetpack-portfolio' )) ) :
		$term_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ', '' );
		if ( !empty( $term_list ) ) :
			$blocks['cats']['label'] = __( 'In', 'chromatic-premium' );
			$blocks['cats']['content'] = $term_list;
		endif;
	endif;
	
	// Display project tags only on singular pages
	if ( is_singular( 'jetpack-portfolio' ) ) :
		$term_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', ', ', '' );
		if ( !empty( $term_list ) ) :
			$blocks['tags']['label'] = __( 'Tagged', 'chromatic-premium' );
			$blocks['tags']['content'] = $term_list;
		endif;
	endif;

	return $blocks;
}
add_filter( 'hoot_meta_info_blocks', 'pm_chromatic_meta_info_blocks', 10, 4 );


/**
 * Add Jetpack Portfolio post type templates
 * 
 * @param  string $archive_template 
 * @param  string $archive_type
 * @param  string $context
 * @return string
 * @see chromatic-premium/template-parts/content.php
 */
function pm_chromatic_default_archive_location( $archive_template, $archive_type, $context ){
	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ){
		if ( 'big' == $archive_type || 'small' == $archive_type || 'medium' == $archive_type ) {
			$archive_template .= '-jetpack-portfolio';
		}
	}
	return $archive_template;
}
add_filter( 'hoot_default_archive_location', 'pm_chromatic_default_archive_location', 10, 3 );
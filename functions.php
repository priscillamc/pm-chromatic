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
 * @since 1.0
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
 * @since 1.0
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


/**
 * Register Sidebars
 * 
 * @since 1.0
 */
function pm_chromatic_sidebars() {

	$args = array(
		'id'            => 'main_content',
		'class'         => 'pm-chromatic-main-content-sidebar',
		'name'          => __( 'Main Content Sidebar', 'pm-chromatic' ),
		'description'   => __( 'Sidebar appears before the main content', 'pm-chromatic' ),
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
	);
	register_sidebar( $args );

}
add_action( 'widgets_init', 'pm_chromatic_sidebars' );

/**
 * Display the main content sidebar
 * 
 * @since 1.0
 */
function pm_chromatic_after_main_start(){
	if ( !is_front_page() || !is_home() ){
		get_sidebar( 'main_content' );
	}
}
add_action( 'hoot_template_main_start', 'pm_chromatic_after_main_start' );

/**
 * Remove the default portfolio description
 * 
 * @param  string $description
 * @return string
 * @since 1.0
 */
function pm_chromatic_loop_description( $description ){
	if ( is_post_type_archive('jetpack-portfolio') ){
		$description = '';
	}
	return $description;
}
add_filter( 'hoot_loop_description', 'pm_chromatic_loop_description' );

<?php

/**
 * Fixes deprecated notices related to PHP 8.2
 */

 /**
  * From Chromatic Premium 4.10.0
  *
  * File: \themes\chromatic-premium\hoot\hoot.php
  */
      class Hoot {

          public $child_textdomain;
          public $comment_template;
          public $context;
          public $parent_textdomain;
          public $prefix;
          public $textdomain_loaded;

          /**
           * Constructor method to controls the load order of the required files for running
           * the framework.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function __construct() {

              /* Define framework, parent theme, and child theme constants. */
              add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );

              /* Load the core functions/classes required by the rest of the framework. */
              add_action( 'after_setup_theme', array( $this, 'core' ), 2 );

              /* Initialize the framework's default actions and filters. */
              add_action( 'after_setup_theme', array( $this, 'default_filters' ), 3 );

              /* Load the customizer framework. */
              add_action( 'after_setup_theme', array( $this, 'customizer' ), 5 );

              /* Handle theme supported features. */
              add_action( 'after_setup_theme', array( $this, 'theme_support' ), 12 );

              /* Load framework includes. */
              add_action( 'after_setup_theme', array( $this, 'includes' ), 13 );

              /* Load the framework extensions. */
              add_action( 'after_setup_theme', array( $this, 'extensions' ), 14 );

              /* Language functions and translations setup. */
              add_action( 'after_setup_theme', array( $this, 'i18n' ), 25 );

              /* Load admin files. */
              add_action( 'wp_loaded', array( $this, 'admin' ) );

              /* Add Premium Extension if exist */
              if ( file_exists( trailingslashit( get_template_directory() ) . 'premium/functions.php' ) )
                  require_once( trailingslashit( get_template_directory() ) . 'premium/functions.php' );

          }

          /**
           * Defines the constant paths for use within the core framework, parent theme, and child theme.
           * Constants prefixed with 'HOOT' are for use only within the core framework and don't
           * reference other areas of the parent or child theme.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function constants() {

              // Sets the path to the parent theme directory.
              define( 'THEME_DIR', get_template_directory() );

              // Sets the path to the parent theme directory URI.
              define( 'THEME_URI', get_template_directory_uri() );

              // Sets the path to the child theme directory.
              define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

              // Sets the path to the child theme directory URI.
              define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

              // Sets the path to the core framework directory.
              define( 'HOOT_DIR', trailingslashit( THEME_DIR ) . 'hoot' );

              // Sets the path to the core framework directory URI.
              define( 'HOOT_URI', trailingslashit( THEME_URI ) . 'hoot' );

              // Sets the path to the framework theme directory.
              define( 'HOOT_THEMEDIR', trailingslashit( THEME_DIR ) . 'hoot-theme' );

              // Sets the path to the framework theme directory URI.
              define( 'HOOT_THEMEURI', trailingslashit( THEME_URI ) . 'hoot-theme' );

              // Sets the path to the Hoot Customizer framework directory.
              define( 'HOOTCUSTOMIZER_DIR', trailingslashit( HOOT_DIR ) . 'customizer' );

              // Sets the path to the Hoot Customizer framework directory URI.
              define( 'HOOTCUSTOMIZER_URI', trailingslashit( HOOT_URI ) . 'customizer' );

              /** Set Additional Paths **/

              // Sets the path to the core framework admin directory.
              define( 'HOOT_ADMIN', trailingslashit( HOOT_DIR ) . 'admin' );

              // Sets the path to the core framework extensions directory.
              define( 'HOOT_EXTENSIONS', trailingslashit( HOOT_DIR ) . 'extensions' );

              // Sets the path to the core framework functions directory.
              define( 'HOOT_INCLUDES', trailingslashit( HOOT_DIR ) . 'includes' );

              /** Set URI Locations **/

              // Sets the path to the core framework CSS directory URI.
              define( 'HOOT_CSS', trailingslashit( HOOT_URI ) . 'css' );

              // Sets the path to the core framework images directory URI.
              define( 'HOOT_IMAGES', trailingslashit( HOOT_URI ) . 'images' );

              // Sets the path to the core framework JavaScript directory URI.
              define( 'HOOT_JS', trailingslashit( HOOT_URI ) . 'js' );

              /** Set Helper Constants **/

              // Sets the default count of items (pages/posts) to show in a list option (query number).
              define( 'HOOT_ADMIN_LIST_ITEM_COUNT', apply_filters( 'hoot_admin_list_item_count', 999 ) );

              /** Set theme detail Constants **/

              global $hoot_theme;
              $hoot_theme->theme = wp_get_theme();

              // Sets the theme versions
              if ( is_child_theme() ) {
                  define( 'CHILD_THEME_VERSION', $hoot_theme->theme->get( 'Version' ) );
                  define( 'CHILD_THEME_NAME', $hoot_theme->theme->get( 'Name' ) );
                  if ( is_object( $hoot_theme->theme->parent() ) ) {
                      define( 'THEME_VERSION', $hoot_theme->theme->parent()->get( 'Version' ) );
                      define( 'THEME_NAME', $hoot_theme->theme->parent()->get( 'Name' ) );
                      define( 'THEME_AUTHOR_URI', $hoot_theme->theme->parent()->get( 'AuthorURI' ) );
                  } else {
                      define( 'THEME_VERSION', '1.0' );
                      define( 'THEME_NAME', 'Chromatic' );
                      define( 'THEME_AUTHOR_URI', 'https://wphoot.com/' );
                  }
              } else {
                  define( 'THEME_VERSION', $hoot_theme->theme->get( 'Version' ) );
                  define( 'THEME_NAME', $hoot_theme->theme->get( 'Name' ) );
                  define( 'THEME_AUTHOR_URI', $hoot_theme->theme->get( 'AuthorURI' ) );
              }

              // Sets the template name
              define( 'TEMPLATE_NAME', preg_replace( '/ ?premium$/i', '', THEME_NAME ) );

              // Sets the theme slug
              $theme_slug = strtolower( preg_replace( '/[^a-zA-Z0-9]+/', '_', trim( THEME_NAME ) ) );
              // if ( ! defined( 'CHILDTHEME_INDEPENDENT_SLUG' ) || CHILDTHEME_INDEPENDENT_SLUG !== true )
              // 	$theme_slug = preg_replace( '/_?child/', '', $theme_slug ); // instead of '/_?child$/'
              define( 'THEME_SLUG', preg_replace( '/_?premium/', '', $theme_slug ) ); // instead of '/_?premium$/'

          }

          /**
           * Loads the core framework files. These files are needed before loading anything else in the
           * framework because they have required functions for use. Many of the files run filters that
           * may be removed in theme setup functions.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function core() {

              /* Load the core framework functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'core.php' );

              /* Load the context-based functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'context.php' );

              /* Load the core framework internationalization functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'i18n.php' );

              /* Load the framework filters. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'filters.php' );

              /* Load the <head> functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'head.php' );

              /* Load media-related functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'media.php' );

              /* Load the sidebar functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'sidebars.php' );

              /* Load the scripts functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'scripts.php' );

              /* Load the styles functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'styles.php' );

              /* Load the utility functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'utility.php' );

          }

          /**
           * Adds the default framework actions and filters.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function default_filters() {
              global $wp_embed;

              /* Remove bbPress theme compatibility if current theme supports bbPress. */
              if ( current_theme_supports( 'bbpress' ) )
                  remove_action( 'bbp_init', 'bbp_setup_theme_compat', 8 );

              /* Don't strip tags on single post titles. */
              remove_filter( 'single_post_title', 'strip_tags' );

              /* Use same default filters as 'the_content' with a little more flexibility. */
              add_filter( 'hoot_loop_description', array( $wp_embed, 'run_shortcode' ),   5 );
              add_filter( 'hoot_loop_description', array( $wp_embed, 'autoembed'     ),   5 );
              add_filter( 'hoot_loop_description',                   'wptexturize',       10 );
              add_filter( 'hoot_loop_description',                   'convert_smilies',   15 );
              add_filter( 'hoot_loop_description',                   'convert_chars',     20 );
              add_filter( 'hoot_loop_description',                   'wpautop',           25 );
              add_filter( 'hoot_loop_description',                   'do_shortcode',      30 );
              add_filter( 'hoot_loop_description',                   'shortcode_unautop', 35 );

              /* Filters for the audio transcript. */
              add_filter( 'hoot_audio_transcript', 'wptexturize',   10 );
              add_filter( 'hoot_audio_transcript', 'convert_chars', 20 );
              add_filter( 'hoot_audio_transcript', 'wpautop',       25 );
          }

          /**
           * Removes theme supported features from themes in the case that a user has a plugin installed
           * that handles the functionality.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function theme_support() {

              /* Adds core WordPress HTML5 support. */
              add_theme_support( 'html5', array( 'script', 'style', 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

              /* Remove support for the the Cleaner Gallery extension if the plugin is installed. */
              if ( function_exists( 'hoot_cleaner_gallery' ) || class_exists( 'Hoot_Cleaner_Gallery' ) )
                  remove_theme_support( 'cleaner-gallery' );

          }

          /**
           * Loads the framework files supported by themes and template-related functions/classes.
           * Functionality in these files should not be expected within the theme setup function.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function includes() {

              /* Load the data set functions needed for sanitization. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'enum.php' );

              /* Load the HTML attributes functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'attr.php' );

              /* Load the color manipulation functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'color.php' );

              /* Load the font functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'fonts.php' );

              /* Load the icon functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'icons.php' );

              /* Load the template functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'template.php' );

              /* Load the comments functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'template-comments.php' );

              /* Load the general template functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'template-general.php' );

              /* Load the media template functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'template-media.php' );

              /* Load the post template functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'template-post.php' );

              /* Load the media meta class. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'media-meta.php' );

              /* Load the media grabber class. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'media-grabber.php' );

              /* Load the sanitization functions. */
              require_once( trailingslashit( HOOT_INCLUDES ) . 'sanitization.php' );

          }

          /**
           * Load extensions (external projects).
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function extensions() {

              /* Load the Cleaner Gallery extension if supported. */
              require_if_theme_supports( 'cleaner-gallery', trailingslashit( HOOT_EXTENSIONS ) . 'cleaner-gallery.php' );

              /* Load the Cleaner Caption extension if supported. */
              require_if_theme_supports( 'cleaner-caption', trailingslashit( HOOT_EXTENSIONS ) . 'cleaner-caption.php' );

              /* Load the Loop Pagination extension if supported. */
              require_if_theme_supports( 'loop-pagination', trailingslashit( HOOT_EXTENSIONS ) . 'loop-pagination.php' );

              /* Load the Widgets extension if supported. */
              require_if_theme_supports( 'hoot-core-widgets', trailingslashit( HOOT_EXTENSIONS ) . 'widgets.php' );

          }

          /**
           * Load Hoot Customizer framework.
           *
           * @since 2.0.0
           * @access public
           * @return void
           */
          function customizer() {

              /* Load the Hoot Customizer framework */
              require_once( trailingslashit( HOOTCUSTOMIZER_DIR ) . 'hoot-customizer.php' );

          }

          /**
           * Loads both the parent and child theme translation files.  If a locale-based functions file exists
           * in either the parent or child theme (child overrides parent), it will also be loaded.  All translation
           * and locale functions files are expected to be within the theme's '/languages' folder, but the
           * framework will fall back on the theme root folder if necessary.  Translation files are expected
           * to be prefixed with the template or stylesheet path (example: 'templatename-en_US.mo').
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function i18n() {
              global $hoot;

              /* Get parent and child theme textdomains. */
              $parent_textdomain = hoot_get_parent_textdomain();
              $child_textdomain  = hoot_get_child_textdomain();

              /* Load theme textdomain. */
              $hoot->textdomain_loaded[ $parent_textdomain ] = load_theme_textdomain( $parent_textdomain, get_template_directory() . '/languages' );

              /* Load child theme textdomain. */
              $hoot->textdomain_loaded[ $child_textdomain ] = is_child_theme() ? load_child_theme_textdomain( $child_textdomain ) : false;

              /* Load the framework textdomain. */
              // @disabled: WordPress standards allow only 1 text domain (theme slug), so we will stick to that.
              // $hoot->textdomain_loaded['chromatic-premium'] = hoot_load_framework_textdomain( 'chromatic-premium' );
              // $hoot->textdomain_loaded['chromatic-premium'] = hoot_load_framework_textdomain( 'chromatic-premium' );

              /* Get the user's locale. */
              $locale = get_locale();

              /* Locate a locale-specific functions file. */
              $locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );

              /* If the locale file exists and is readable, load it. */
              if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
                  require_once( $locale_functions );
          }

          /**
           * Load admin files for the framework.
           *
           * @since 1.0.0
           * @access public
           * @return void
           */
          function admin() {

              /* Check if in the WordPress admin. */
              if ( is_admin() ) {

                  /* Load the main admin file. */
                  require_once( trailingslashit( HOOT_ADMIN ) . 'admin.php' );

              }
          }

      } // end class
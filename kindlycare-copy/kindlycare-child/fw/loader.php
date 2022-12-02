<?php
/**
 * KindlyCare Framework
 *
 * @package kindlycare
 * @since kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'KINDLYCARE_FW_DIR' ) )		define( 'KINDLYCARE_FW_DIR',		'fw' );
if ( ! defined( 'KINDLYCARE_THEME_PATH' ) )	define( 'KINDLYCARE_THEME_PATH',	trailingslashit( get_template_directory() ) );
if ( ! defined( 'KINDLYCARE_FW_PATH' ) )		define( 'KINDLYCARE_FW_PATH',		KINDLYCARE_THEME_PATH . KINDLYCARE_FW_DIR . '/' );

// Theme timing
if ( ! defined( 'KINDLYCARE_START_TIME' ) )		define( 'KINDLYCARE_START_TIME', microtime(true));		// Framework start time
if ( ! defined( 'KINDLYCARE_START_MEMORY' ) )		define( 'KINDLYCARE_START_MEMORY', memory_get_usage());	// Memory usage before core loading
if ( ! defined( 'KINDLYCARE_START_QUERIES' ) )	define( 'KINDLYCARE_START_QUERIES', get_num_queries());	// DB queries used

// Include theme variables storage
require_once KINDLYCARE_FW_PATH . 'core/core.storage.php';

// Theme variables storage
//$theme_slug = str_replace(' ', '_', trim(strtolower(get_stylesheet())));
//kindlycare_storage_set('options_prefix', 'kindlycare'.'_'.trim($theme_slug));	// Used as prefix to store theme's options in the post meta and wp options
kindlycare_storage_set('options_prefix', 'kindlycare');	// Used as prefix to store theme's options in the post meta and wp options
kindlycare_storage_set('page_template', '');			// Storage for current page template name (used in the inheritance system)
kindlycare_storage_set('widgets_args', array(			// Arguments to register widgets
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget_title">',
		'after_title'   => '</h5>',
	)
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'kindlycare_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'kindlycare_loader_theme_setup', 20 );
	function kindlycare_loader_theme_setup() {

		kindlycare_profiler_add_point(esc_html__('After load theme required files', 'kindlycare'));

		// Before init theme
		do_action('kindlycare_action_before_init_theme');

		// Load current values for main theme options
		kindlycare_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			kindlycare_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// String utilities. core.strings must be first - we use kindlycare_str...() in the kindlycare_get_file_dir()
require_once KINDLYCARE_FW_PATH . 'core/core.strings.php';
// File utilities. core.files must be first - we use kindlycare_get_file_dir() to include all rest parts
require_once KINDLYCARE_FW_PATH . 'core/core.files.php';
// Debug utilities
require_once KINDLYCARE_FW_PATH . 'core/core.debug.php';

// Include custom theme files
require_once KINDLYCARE_THEME_PATH . 'includes/theme.options.php';

// Include core files
require_once KINDLYCARE_FW_PATH . 'core/core.admin.php';
require_once KINDLYCARE_FW_PATH . 'core/core.arrays.php';
require_once KINDLYCARE_FW_PATH . 'core/core.date.php';
require_once KINDLYCARE_FW_PATH . 'core/core.html.php';
require_once KINDLYCARE_FW_PATH . 'core/core.http.php';
require_once KINDLYCARE_FW_PATH . 'core/core.ini.php';
require_once KINDLYCARE_FW_PATH . 'core/core.less.php';
require_once KINDLYCARE_FW_PATH . 'core/core.lists.php';
require_once KINDLYCARE_FW_PATH . 'core/core.media.php';
require_once KINDLYCARE_FW_PATH . 'core/core.messages.php';
require_once KINDLYCARE_FW_PATH . 'core/core.reviews.php';
require_once KINDLYCARE_FW_PATH . 'core/core.storage.php';
require_once KINDLYCARE_FW_PATH . 'core/core.templates.php';
require_once KINDLYCARE_FW_PATH . 'core/core.theme.php';
require_once KINDLYCARE_FW_PATH . 'core/core.users.php';
require_once KINDLYCARE_FW_PATH . 'core/core.wp.php';
require_once KINDLYCARE_FW_PATH . 'core/support.attachment.php';
require_once KINDLYCARE_FW_PATH . 'core/support.post.php';
require_once KINDLYCARE_FW_PATH . 'core/support.post_type.php';
require_once KINDLYCARE_FW_PATH . 'core/support.taxonomy.php';
require_once KINDLYCARE_FW_PATH . 'core/core.customizer/core.customizer.php';
require_once KINDLYCARE_FW_PATH . 'core/core.options/core.options.php';

// Include theme-specific plugins and post types
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.booked.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.booking.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.essgrids.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.instagram-feed.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.instagram-widget.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.mailchimp.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.revslider.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.visual-composer.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.woocommerce.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.wordpress-social-login.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.wpml.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.gutenberg.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.wp-gdpr-compliance.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.instagram-widget-by-wpzoom.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/plugin.contact-form-7.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/support.clients.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/support.services.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/support.team.php';
require_once KINDLYCARE_THEME_PATH . 'plugins/support.testimonials.php';

// Include theme templates.
// Using get_template_part(), because templates can be replaced in the child theme
get_template_part('templates/404');
get_template_part('templates/attachment');
get_template_part('templates/excerpt');
get_template_part('templates/masonry');
get_template_part('templates/no-articles');
get_template_part('templates/no-search');
get_template_part('templates/portfolio');
get_template_part('templates/related');
get_template_part('templates/single-matches');
get_template_part('templates/single-players');
get_template_part('templates/single-portfolio');
get_template_part('templates/single-standard');
get_template_part('templates/single-team');
get_template_part('templates/headers/header_3');
get_template_part('templates/trx_blogger/accordion');
get_template_part('templates/trx_blogger/date');
get_template_part('templates/trx_blogger/list');
get_template_part('templates/trx_blogger/plain');
get_template_part('templates/trx_blogger/polaroid');
get_template_part('templates/trx_clients/clients-1');
get_template_part('templates/trx_clients/clients-2');
get_template_part('templates/trx_events/events-1');
get_template_part('templates/trx_events/events-2');
get_template_part('templates/trx_form/form_1');
get_template_part('templates/trx_form/form_2');
get_template_part('templates/trx_form/form_custom');
get_template_part('templates/trx_matches/matches-1');
get_template_part('templates/trx_matches/matches-2');
get_template_part('templates/trx_menuitems/menuitems-1');
get_template_part('templates/trx_menuitems/menuitems-2');
get_template_part('templates/trx_players/players-1');
get_template_part('templates/trx_recent_news/news-announce');
get_template_part('templates/trx_recent_news/news-excerpt');
get_template_part('templates/trx_recent_news/news-magazine');
get_template_part('templates/trx_recent_news/news-portfolio');
get_template_part('templates/trx_services/services-1');
get_template_part('templates/trx_services/services-2');
get_template_part('templates/trx_services/services-3');
get_template_part('templates/trx_services/services-4');
get_template_part('templates/trx_services/services-5');
get_template_part('templates/trx_team/team-1');
get_template_part('templates/trx_team/team-2');
get_template_part('templates/trx_team/team-3');
get_template_part('templates/trx_team/team-4');
get_template_part('templates/trx_testimonials/testimonials-1');
get_template_part('templates/trx_testimonials/testimonials-2');
get_template_part('templates/trx_testimonials/testimonials-3');
get_template_part('templates/trx_testimonials/testimonials-4');
?>
<?php
/**
 * KindlyCare Framework: messages subsystem
 *
 * @package	kindlycare
 * @since	kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('kindlycare_messages_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_messages_theme_setup' );
	function kindlycare_messages_theme_setup() {
		// Core messages strings
		add_filter('kindlycare_action_add_scripts_inline', 'kindlycare_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('kindlycare_get_error_msg')) {
	function kindlycare_get_error_msg() {
		return kindlycare_storage_get('error_msg');
	}
}

if (!function_exists('kindlycare_set_error_msg')) {
	function kindlycare_set_error_msg($msg) {
		$msg2 = kindlycare_get_error_msg();
		kindlycare_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('kindlycare_get_success_msg')) {
	function kindlycare_get_success_msg() {
		return kindlycare_storage_get('success_msg');
	}
}

if (!function_exists('kindlycare_set_success_msg')) {
	function kindlycare_set_success_msg($msg) {
		$msg2 = kindlycare_get_success_msg();
		kindlycare_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('kindlycare_get_notice_msg')) {
	function kindlycare_get_notice_msg() {
		return kindlycare_storage_get('notice_msg');
	}
}

if (!function_exists('kindlycare_set_notice_msg')) {
	function kindlycare_set_notice_msg($msg) {
		$msg2 = kindlycare_get_notice_msg();
		kindlycare_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('kindlycare_set_system_message')) {
	function kindlycare_set_system_message($msg, $status='info', $hdr='') {
		update_option('kindlycare_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('kindlycare_get_system_message')) {
	function kindlycare_get_system_message($del=false) {
		$msg = get_option('kindlycare_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			kindlycare_del_system_message();
		return $msg;
	}
}

if (!function_exists('kindlycare_del_system_message')) {
	function kindlycare_del_system_message() {
		delete_option('kindlycare_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('kindlycare_messages_add_scripts_inline')) {
    function kindlycare_messages_add_scripts_inline($vars=array()) {
        // Strings for translation
        $vars["strings"] = array(
            'ajax_error' => esc_html__('Invalid server answer', 'kindlycare'),
            'bookmark_add' => esc_html__('Add the bookmark', 'kindlycare'),
            'bookmark_added' => esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'kindlycare'),
            'bookmark_del' => esc_html__('Delete this bookmark', 'kindlycare'),
            'bookmark_title' => esc_html__('Enter bookmark title', 'kindlycare'),
            'bookmark_exists' => esc_html__('Current page already exists in the bookmarks list', 'kindlycare'),
            'search_error' => esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'kindlycare'),
            'email_confirm' => esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'kindlycare'),
            'reviews_vote' => esc_html__('Thanks for your vote! New average rating is:', 'kindlycare'),
            'reviews_error' => esc_html__('Error saving your vote! Please, try again later.', 'kindlycare'),
            'error_like' => esc_html__('Error saving your like! Please, try again later.', 'kindlycare'),
            'error_global' => esc_html__('Global error text', 'kindlycare'),
            'name_empty' => esc_html__('The name can\'t be empty', 'kindlycare'),
            'name_long' => esc_html__('Too long name', 'kindlycare'),
            'email_empty' => esc_html__('Too short (or empty) email address', 'kindlycare'),
            'email_long' => esc_html__('Too long email address', 'kindlycare'),
            'email_not_valid' => esc_html__('Invalid email address', 'kindlycare'),
            'subject_empty' => esc_html__('The subject can\'t be empty', 'kindlycare'),
            'subject_long' => esc_html__('Too long subject', 'kindlycare'),
            'text_empty' => esc_html__('The message text can\'t be empty', 'kindlycare'),
            'text_long' => esc_html__('Too long message text', 'kindlycare'),
            'send_complete' => esc_html__("Send message complete!", 'kindlycare'),
            'send_error' => esc_html__('Transmit failed!', 'kindlycare'),
            'login_empty' => esc_html__('The Login field can\'t be empty', 'kindlycare'),
            'login_long' => esc_html__('Too long login field', 'kindlycare'),
            'login_success' => esc_html__('Login success! The page will be reloaded in 3 sec.', 'kindlycare'),
            'login_failed' => esc_html__('Login failed!', 'kindlycare'),
            'password_empty' => esc_html__('The password can\'t be empty and shorter then 4 characters', 'kindlycare'),
            'password_long' => esc_html__('Too long password', 'kindlycare'),
            'password_not_equal' => esc_html__('The passwords in both fields are not equal', 'kindlycare'),
            'registration_success' => esc_html__('Registration success! Please log in!', 'kindlycare'),
            'registration_failed' => esc_html__('Registration failed!', 'kindlycare'),
            'geocode_error' => esc_html__('Geocode was not successful for the following reason:', 'kindlycare'),
            'googlemap_not_avail' => esc_html__('Google map API not available!', 'kindlycare'),
            'editor_save_success' => esc_html__("Post content saved!", 'kindlycare'),
            'editor_save_error' => esc_html__("Error saving post data!", 'kindlycare'),
            'editor_delete_post' => esc_html__("You really want to delete the current post?", 'kindlycare'),
            'editor_delete_post_header' => esc_html__("Delete post", 'kindlycare'),
            'editor_delete_success' => esc_html__("Post deleted!", 'kindlycare'),
            'editor_delete_error' => esc_html__("Error deleting post!", 'kindlycare'),
            'editor_caption_cancel' => esc_html__('Cancel', 'kindlycare'),
            'editor_caption_close' => esc_html__('Close', 'kindlycare')
        );
        return $vars;
    }
}
?>
<?php
// Get template args
extract(kindlycare_template_get_args('top-panel-top'));

if (in_array('contact_email', $top_panel_top_components) && ($contact_email=trim(kindlycare_get_custom_option('contact_email')))!='') {
	?>
    <div class="top_panel_top_contact_email">
		<?php kindlycare_show_layout('<a href="mailto:'.$contact_email.'">'.$contact_email.'</a>'); ?>
    </div>
	<?php
}

if (in_array('contact_phone', $top_panel_top_components) && ($contact_phone=trim(kindlycare_get_custom_option('contact_phone')))!='') {
	$contact_phone_text=trim(kindlycare_get_custom_option('contact_phone_text'));
	?>
    <div class="top_panel_top_contact_phone">
		<?php echo (!empty($contact_phone_text) ? trim($contact_phone_text) : '') . '<span class="accent1">' . trim('<a href="tel:'.$contact_phone.'">'.$contact_phone.'</a>') . '</span>';
		?>
    </div>
	<?php
}

if (in_array('contact_info', $top_panel_top_components) && ($contact_info=trim(kindlycare_get_custom_option('contact_info')))!='') {
	?>
    <div class="top_panel_top_contact_area">
		<?php kindlycare_show_layout($contact_info); ?>
    </div>
	<?php
}
?>

<?php
if (in_array('open_hours', $top_panel_top_components) && ($open_hours=trim(kindlycare_get_custom_option('contact_open_hours')))!='') {
	?>
    <div class="top_panel_top_open_hours icon-clock"><?php kindlycare_show_layout($open_hours); ?></div>
	<?php
}
?>

<?php
if((in_array('socials', $top_panel_top_components) && kindlycare_get_custom_option('show_socials')=='yes')
   || (in_array('search', $top_panel_top_components) && kindlycare_get_custom_option('show_search')=='yes')
   || (in_array('currency', $top_panel_top_components) && function_exists('kindlycare_is_woocommerce_page') && kindlycare_is_woocommerce_page() && kindlycare_get_custom_option('show_currency')=='yes')
   || (in_array('language', $top_panel_top_components) && kindlycare_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages'))
   || (in_array('bookmarks', $top_panel_top_components) && kindlycare_get_custom_option('show_bookmarks')=='yes')
   || (in_array('login', $top_panel_top_components) && kindlycare_get_custom_option('show_login')=='yes')
   || (in_array('cart', $top_panel_top_components) && function_exists('kindlycare_exists_woocommerce') && kindlycare_exists_woocommerce() && (kindlycare_is_woocommerce_page() && kindlycare_get_custom_option('show_cart')=='shop' || kindlycare_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART')))
) { ?>
    <div class="top_panel_top_user_area">
		<?php
		if (in_array('socials', $top_panel_top_components) && kindlycare_get_custom_option('show_socials')=='yes') {
			?>
            <div class="top_panel_top_socials">
				<?php kindlycare_show_layout(kindlycare_sc_socials(array('size'=>'tiny'))); ?>
            </div>
			<?php
		}

		if (in_array('search', $top_panel_top_components) && kindlycare_get_custom_option('show_search')=='yes') {
			?>
            <div class="top_panel_top_search"><?php kindlycare_show_layout(kindlycare_sc_search(array('state'=>'fixed'))); ?></div>
			<?php
		}

		$menu_user = kindlycare_get_nav_menu('menu_user');
		if (empty($menu_user)) {
		?>
        <ul id="menu_user" class="menu_user_nav">
			<?php
			} else {
				$menu = kindlycare_substr($menu_user, 0, kindlycare_strlen($menu_user)-5);
				$pos = kindlycare_strpos($menu, '<ul');
				if ($pos!==false) $menu = kindlycare_substr($menu, 0, $pos+3) . ' class="menu_user_nav"' . kindlycare_substr($menu, $pos+3);
				echo str_replace('class=""', '', $menu);
			}


			if (in_array('currency', $top_panel_top_components) && function_exists('kindlycare_is_woocommerce_page') && kindlycare_is_woocommerce_page() && kindlycare_get_custom_option('show_currency')=='yes') {
				?>
                <li class="menu_user_currency">
                    <a href="#">$</a>
                    <ul>
                        <li><a href="#"><b>&#36;</b> <?php esc_html_e('Dollar', 'kindlycare'); ?></a></li>
                        <li><a href="#"><b>&euro;</b> <?php esc_html_e('Euro', 'kindlycare'); ?></a></li>
                        <li><a href="#"><b>&pound;</b> <?php esc_html_e('Pounds', 'kindlycare'); ?></a></li>
                    </ul>
                </li>
				<?php
			}

			if (in_array('language', $top_panel_top_components) && kindlycare_get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
				$languages = icl_get_languages('skip_missing=1');
				if (!empty($languages) && is_array($languages)) {
					$lang_list = '';
					$lang_active = '';
					foreach ($languages as $lang) {
						$lang_title = esc_attr($lang['translated_name']);	//esc_attr($lang['native_name']);
						if ($lang['active']) {
							$lang_active = $lang_title;
						}
						$lang_list .= "\n"
						              .'<li><a rel="alternate" hreflang="' . esc_attr($lang['language_code']) . '" href="' . esc_url(apply_filters('WPML_filter_link', $lang['url'], $lang)) . '">'
						              .'<img src="' . esc_url($lang['country_flag_url']) . '" alt="' . esc_attr($lang_title) . '" title="' . esc_attr($lang_title) . '" />'
						              . ($lang_title)
						              .'</a></li>';
					}
					?>
                    <li class="menu_user_language">
                        <a href="#"><span><?php kindlycare_show_layout($lang_active); ?></span></a>
                        <ul><?php kindlycare_show_layout($lang_list); ?></ul>
                    </li>
					<?php
				}
			}

			if (in_array('bookmarks', $top_panel_top_components) && kindlycare_get_custom_option('show_bookmarks')=='yes') {
				// Load core messages
				kindlycare_enqueue_messages();
				?>
                <li class="menu_user_bookmarks"><a href="#" class="bookmarks_show icon-star" title="<?php esc_attr_e('Show bookmarks', 'kindlycare'); ?>"><?php esc_html_e('Bookmarks', 'kindlycare'); ?></a>
					<?php
					$list = kindlycare_get_value_gpc('kindlycare_bookmarks', '');
					if (!empty($list)) $list = json_decode($list, true);
					?>
                    <ul class="bookmarks_list">
                        <li><a href="#" class="bookmarks_add icon-star-empty" title="<?php esc_attr_e('Add the current page into bookmarks', 'kindlycare'); ?>"><?php esc_html_e('Add bookmark', 'kindlycare'); ?></a></li>
						<?php
						if (!empty($list) && is_array($list)) {
							foreach ($list as $bm) {
								echo '<li><a href="'.esc_url($bm['url']).'" class="bookmarks_item">'.($bm['title']).'<span class="bookmarks_delete icon-cancel" title="'.esc_attr__('Delete this bookmark', 'kindlycare').'"></span></a></li>';
							}
						}
						?>
                    </ul>
                </li>
				<?php
			}

			if (in_array('login', $top_panel_top_components) && kindlycare_get_custom_option('show_login')=='yes') {
				if ( !is_user_logged_in() ) {
					// Load core messages
					kindlycare_enqueue_messages();
					// Load Popup engine
					kindlycare_enqueue_popup();
					// Anyone can register ?
					if ( (int) get_option('users_can_register') > 0) {
						?><li class="menu_user_register"><?php do_action('trx_utils_action_register'); ?></li><?php
					}
					?><li class="menu_user_login"><?php do_action('trx_utils_action_login'); ?></li><?php
				} else {
					$current_user = wp_get_current_user();
					?>
                    <li class="menu_user_controls">
                        <a href="#"><?php
							$user_avatar = '';
							$mult = kindlycare_get_retina_multiplier();
							if ($current_user->user_email) $user_avatar = get_avatar($current_user->user_email, 16*$mult);
							if ($user_avatar) {
								?><span class="user_avatar"><?php kindlycare_show_layout($user_avatar); ?></span><?php
							}?><span class="user_name"><?php kindlycare_show_layout($current_user->display_name); ?></span></a>
                        <ul>
							<?php if (current_user_can('publish_posts')) { ?>
                                <li><a href="<?php echo esc_url(home_url('/')); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-doc"><?php esc_html_e('New post', 'kindlycare'); ?></a></li>
							<?php } ?>
                            <li><a href="<?php echo get_edit_user_link(); ?>" class="icon icon-cog"><?php esc_html_e('Settings', 'kindlycare'); ?></a></li>
                        </ul>
                    </li>
                    <li class="menu_user_logout"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="icon icon-logout"><?php esc_html_e('Logout', 'kindlycare'); ?></a></li>
					<?php
				}
			}

			if (in_array('cart', $top_panel_top_components) && function_exists('kindlycare_exists_woocommerce') && kindlycare_exists_woocommerce() && (kindlycare_is_woocommerce_page() && kindlycare_get_custom_option('show_cart')=='shop' || kindlycare_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
				?>
                <li class="menu_user_cart">
					<?php get_template_part(kindlycare_get_file_slug('templates/headers/_parts/contact-info-cart.php')); ?>
                </li>
				<?php
			}
			?>

        </ul>

    </div>
<?php } ?>
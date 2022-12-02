<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'kindlycare_template_form_2_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_template_form_2_theme_setup', 1 );
	function kindlycare_template_form_2_theme_setup() {
		kindlycare_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'kindlycare')
			));
	}
}

// Template output
if ( !function_exists( 'kindlycare_template_form_2_output' ) ) {
	function kindlycare_template_form_2_output($post_options, $post_data) {
        $title = trim(kindlycare_storage_get('title_form_2'));
        $subtitle = trim(kindlycare_storage_get('subtitle_form_2'));
        $description = trim(kindlycare_storage_get('description_form_2'));

        $address_1 = kindlycare_get_theme_option('contact_address_1');
		$address_2 = kindlycare_get_theme_option('contact_address_2');
		$phone = kindlycare_get_theme_option('contact_phone');
		$fax = kindlycare_get_theme_option('contact_fax');
		$email = kindlycare_get_theme_option('contact_email');
		$open_hours = kindlycare_get_theme_option('contact_open_hours');
		?>
		<div class="sc_columns columns_wrap">
            <div class="sc_form_fields column-left">
                <?php  if (!empty($title)) { ?><div class="sc_form_title sc_item_title"><h2><?php kindlycare_show_layout($title) ?></h2></div><?php }?>
                <?php  if (!empty($subtitle)) { ?><div class="sc_form_subtitle sc_item_subtitle"><h6><?php kindlycare_show_layout($subtitle) ?></h6></div><?php }?>
                <?php  if (!empty($description)){ ?><div class="sc_form_descr sc_item_descr"><?php kindlycare_show_layout($description) ?></div><?php }?>
                <?php  if (!empty($title) || !empty($subtitle) || !empty($description)){ ?><div class="sc_form_delimiter"></div><?php }?>
                <form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
                    <?php kindlycare_sc_form_show_fields($post_options['fields']); ?>
                    <div class="sc_form_info">
                        <div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'kindlycare'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name *', 'kindlycare'); ?>"></div>
                        <div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'kindlycare'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail *', 'kindlycare'); ?>"></div>
                    </div>
                    <div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'kindlycare'); ?></label><textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message', 'kindlycare'); ?>"></textarea></div>
                    <?php
                    $privacy = trx_utils_get_privacy_text();
                    if (!empty($privacy)) {
                        ?><div class="sc_form_item sc_form_field_checkbox"><?php
                        ?><input type="checkbox" id="i_agree_privacy_policy_sc_form_2" name="i_agree_privacy_policy" class="sc_form_privacy_checkbox" value="1">
                        <label for="i_agree_privacy_policy_sc_form_2"><?php trx_utils_show_layout($privacy); ?></label>
                        </div><?php
                    }
                    ?><div class="sc_form_item sc_form_button"><?php
                        ?><button <?php
                        if (!empty($privacy)) echo ' disabled="disabled"'
                        ?> ><?php
                            if (!empty($args['button_caption']))
                                echo esc_html($args['button_caption']);
                            else
                                esc_html_e('Send Message', 'kindlycare');
                            ?></button>
                    </div>
                    <div class="result sc_infobox"></div>
                </form>
            </div>
            <div class="sc_form_address column-right">
                <?php  if (!empty($title)) { ?><div class="sc_form_title sc_item_title"><h2><?php echo esc_html_e('Locations', 'kindlycare'); ?></h2></div><?php }?>
                <?php  if (!empty($subtitle)) { ?><div class="sc_form_subtitle sc_item_subtitle"><h6><?php echo esc_html_e('Find nearest place', 'kindlycare'); ?></h6></div><?php }?>
                <?php  if (!empty($title) || !empty($subtitle) || !empty($description)){ ?><div class="sc_form_delimiter"></div><?php }?>
                <div class="sc_form_contact_info">
                    <div class="sc_form_address_field">
                        <span class="sc_form_address_label"><?php esc_html_e('Address:', 'kindlycare'); ?></span>
                        <span class="sc_form_address_data"><?php kindlycare_show_layout($address_1) . (!empty($address_1) && !empty($address_2) ? ', ' : '') . $address_2; ?></span>
                    </div>
                    <div class="sc_form_address_field">
                        <span class="sc_form_address_label"><?php esc_html_e('Phone number:', 'kindlycare'); ?></span>
                        <span class="sc_form_address_data"><?php kindlycare_show_layout($phone) . (!empty($phone) && !empty($fax) ? ', ' : '') . $fax; ?></span>
                    </div>
                    <div class="sc_form_address_field">
                        <span class="sc_form_address_label"><?php esc_html_e('Mail:', 'kindlycare'); ?></span>
                        <span class="sc_form_address_data mail"><?php kindlycare_show_layout($email); ?></span>
                    </div>
                    <div class="sc_form_address_field">
                        <span class="sc_form_address_label"><?php esc_html_e('We are open:', 'kindlycare'); ?></span>
                        <span class="sc_form_address_data"><?php kindlycare_show_layout($open_hours); ?></span>
                    </div>
                </div>
			</div>
		</div>
		<?php
	}
}
?>
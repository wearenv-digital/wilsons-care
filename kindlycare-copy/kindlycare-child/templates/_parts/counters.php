<?php
// Get template args
extract(kindlycare_template_get_args('counters'));

$show_all_counters = !isset($post_options['counters']);
$counters_tag = is_single() ? 'span' : 'a';

//if (is_array($post_options['counters'])) $post_options['counters'] = join(',', $post_options['counters']);

// Views
if ($show_all_counters || kindlycare_strpos($post_options['counters'], 'views')!==false) {
	?>
	<<?php kindlycare_show_layout($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo esc_attr( sprintf(__('Views - %s', 'kindlycare'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php kindlycare_show_layout($post_data['post_views']); ?></span><?php if (kindlycare_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Views', 'kindlycare'); ?></<?php kindlycare_show_layout($counters_tag); ?>>
	<?php
}

// Comments
if ($show_all_counters || kindlycare_strpos($post_options['counters'], 'comments')!==false) {
	?>
	<a class="post_counters_item post_counters_comments icon-comment" title="<?php echo esc_attr( sprintf(__('Comments - %s', 'kindlycare'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="post_counters_number"><?php kindlycare_show_layout($post_data['post_comments']); ?></span><?php if (kindlycare_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Comments', 'kindlycare'); ?></a>
	<?php 
}
 
// Rating
$rating = $post_data['post_reviews_'.(kindlycare_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || kindlycare_strpos($post_options['counters'], 'rating')!==false)) { 
	?>
	<<?php kindlycare_show_layout($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(__('Rating - %s', 'kindlycare'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php kindlycare_show_layout($rating); ?></span></<?php kindlycare_show_layout($counters_tag); ?>>
	<?php
}

// Likes
if ($show_all_counters || kindlycare_strpos($post_options['counters'], 'likes')!==false) {
	// Load core messages
	kindlycare_enqueue_messages();
	$likes = isset($_COOKIE['kindlycare_likes']) ? $_COOKIE['kindlycare_likes'] : '';
	$allow = kindlycare_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php echo !empty($allow) ? 'enabled' : 'disabled'; ?>" title="<?php echo !empty($allow) ? esc_attr__('Like', 'kindlycare') : esc_attr__('Dislike', 'kindlycare'); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_attr_e('Like', 'kindlycare'); ?>"
		data-title-dislike="<?php esc_attr_e('Dislike', 'kindlycare'); ?>"><span class="post_counters_number"><?php kindlycare_show_layout($post_data['post_likes']); ?></span><?php if (kindlycare_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Likes', 'kindlycare'); ?></a>
	<?php
}

// Edit page link
if (kindlycare_strpos($post_options['counters'], 'edit')!==false) {
	edit_post_link( esc_html__( 'Edit', 'kindlycare' ), '<span class="post_edit edit-link">', '</span>' );
}

// Markup for search engines
if (is_single() && kindlycare_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(kindlycare_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(kindlycare_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>
<?php
// Get template args
extract(kindlycare_template_get_args('widgets-posts'));

global $post;
$post_id = $post->ID;
$post_date = kindlycare_get_date_or_difference(apply_filters('kindlycare_filter_post_date', $post->post_date, $post->ID, $post->post_type));
$post_title = $post->post_title;
$post_link = !isset($show_links) || $show_links ? get_permalink($post_id) : '';

$output = '<article class="post_item' . ($show_image == 0 ? ' no_thumb' : ' with_thumb') . ($post_number == 1 ? ' first' : '') . '">';

if ($show_image) {
    $post_thumb = kindlycare_get_resized_image_tag($post_id, 75, 75);
    if ($post_thumb) {
        $output .= '<div class="post_thumb">' . ($post_thumb) . '</div>';
    }
}

$output .= '<div class="post_content">'
    . '<h6 class="post_title">'
    . ($post_link ? '<a href="' . esc_url($post_link) . '">' : '') . trim(kindlycare_strshort($post_title, 30)) . ($post_link ? '</a>' : '')
    . '</h6>';

if ($show_counters) {
    if (kindlycare_strpos($show_counters, 'views') !== false) {
        $post_counters = kindlycare_storage_isset('post_data_' . $post_id) && kindlycare_storage_get_array('post_data_' . $post_id, 'post_options_counters')
            ? kindlycare_storage_get_array('post_data_' . $post_id, 'post_views')
            : kindlycare_get_post_views($post_id);
        $post_counters_icon = 'post_counters_views icon-eye';
    } else if (kindlycare_strpos($show_counters, 'likes') !== false) {
        $likes = isset($_COOKIE['kindlycare_likes']) ? $_COOKIE['kindlycare_likes'] : '';
        $allow = kindlycare_strpos($likes, ',' . ($post_id) . ',') === false;
        $post_counters = kindlycare_storage_isset('post_data_' . $post_id) && kindlycare_storage_get_array('post_data_' . $post_id, 'post_options_counters')
            ? kindlycare_storage_get_array('post_data_' . $post_id, 'post_likes')
            : kindlycare_get_post_likes($post_id);
        $post_counters_icon = 'post_counters_likes icon-heart ' . ($allow ? 'enabled' : 'disabled');
        kindlycare_enqueue_messages();
    } else if (kindlycare_strpos($show_counters, 'stars') !== false || kindlycare_strpos($show_counters, 'rating') !== false) {
        $post_counters = kindlycare_reviews_marks_to_display(get_post_meta($post_id, $post_rating, true));
        // Uncomment this section if you want hide rating post when viewing this post
        /* $post_counters = kindlycare_reviews_marks_to_display(kindlycare_storage_isset('post_data_' . $post_id) && kindlycare_storage_get_array('post_data_' . $post_id, 'post_options_reviews')
                ? kindlycare_storage_get_array('post_data_' . $post_id, $post_rating)
                : get_post_meta($post_id, $post_rating, true));        */
        $post_counters_icon = 'post_counters_rating icon-star';
    } else {
        $post_counters = kindlycare_storage_isset('post_data_' . $post_id) && kindlycare_storage_get_array('post_data_' . $post_id, 'post_options_counters')
            ? kindlycare_storage_get_array('post_data_' . $post_id, 'post_comments')
            : get_comments_number($post_id);
        $post_counters_icon = 'post_counters_comments icon-comment';
    }

    if (kindlycare_strpos($show_counters, 'stars') !== false && $post_counters > 0) {
        if (kindlycare_strpos($post_counters, '.') === false)
            $post_counters .= '.0';
        if (kindlycare_get_custom_option('show_reviews') == 'yes') {
            $output .= '<div class="post_rating reviews_summary blog_reviews">'
                . '<div class="criteria_summary criteria_row">' . trim(kindlycare_reviews_get_summary_stars($post_counters, false, false, 5)) . '</div>'
                . '</div>';
        }
    }
}
$output .= '</div>';

if ($show_date || $show_counters || $show_author) {
    $output .= '<div class="post_info update">';

    if ($show_date) {
        $output .= '<span class="post_info_item post_info_posted">' . ($post_link ? '<a href="' . esc_url($post_link) . '" class="post_info_date">' : '') . ($post_date) . ($post_link ? '</a>' : '') . '</span>';
    }
    if ($show_author) {
        if (kindlycare_storage_isset('post_data_' . $post_id)) {
            $post_author_id = kindlycare_storage_get_array('post_data_' . $post_id, 'post_author_id');
            $post_author_name = kindlycare_storage_get_array('post_data_' . $post_id, 'post_author');
            $post_author_url = kindlycare_storage_get_array('post_data_' . $post_id, 'post_author_url');
        } else {
            $post_author_id = $post->post_author;
            $post_author_name = get_the_author_meta('display_name', $post_author_id);
            $post_author_url = get_author_posts_url($post_author_id, '');
        }
        $output .= '<span class="post_info_item post_info_posted_by">' . esc_html__('by', 'kindlycare') . ' ' . ($post_link ? '<a href="' . esc_url($post_author_url) . '" class="post_info_author">' : '') . ($post_author_name) . ($post_link ? '</a>' : '') . '</span>';
    }

    if ($show_counters && kindlycare_strpos($show_counters, 'stars') === false) {
        $post_counters_link = kindlycare_strpos($show_counters, 'comments') !== false
            ? get_comments_link($post_id)
            : (kindlycare_strpos($show_counters, 'likes') !== false
                ? '#'
                : $post_link
            );
        $output .= '<span class="post_info_item post_info_counters">'
            . ($post_counters_link ? '<a href="' . esc_url($post_counters_link) . '"' : '<span')
            . ' class="post_counters_item ' . esc_attr($post_counters_icon) . '"'
            . (kindlycare_strpos($show_counters, 'likes') !== false
                ? ' title="' . ($allow ? esc_attr__('Like', 'kindlycare') : esc_attr__('Dislike', 'kindlycare')) . '"'
                . ' data-postid="' . esc_attr($post_id) . '"'
                . ' data-likes="' . esc_attr($post_counters) . '"'
                . ' data-title-like="' . esc_attr__('Like', 'kindlycare') . '"'
                . ' data-title-dislike="' . esc_attr__('Dislike', 'kindlycare') . '"'
                : ''
            )
            . '>'
            . '<span class="post_counters_number">' . ($post_counters) . '</span>'
            . ($post_counters_link ? '</a>' : '</span>')
            . '</span>';
    }
    $output .= '</div>';
}
$output .= '</article>';

// Return result
kindlycare_storage_set('widgets_posts_output', $output);
?>
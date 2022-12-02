<?php
if (is_singular() && kindlycare_get_theme_option('use_ajax_views_counter')=='no') {
    kindlycare_set_post_views(get_the_ID());
}
?>
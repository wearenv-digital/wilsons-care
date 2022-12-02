<?php
//####################################################
//#### Inheritance system (for internal use only) #### 
//####################################################

// Add item to the inheritance settings
if ( !function_exists( 'kindlycare_add_theme_inheritance' ) ) {
	function kindlycare_add_theme_inheritance($options, $append=true) {
		$inheritance = kindlycare_storage_get('inheritance');
		if (empty($inheritance)) $inheritance = array();
		kindlycare_storage_set('inheritance', $append 
			? kindlycare_array_merge($inheritance, $options) 
			: kindlycare_array_merge($options, $inheritance)
			);
	}
}



// Return inheritance settings
if ( !function_exists( 'kindlycare_get_theme_inheritance' ) ) {
	function kindlycare_get_theme_inheritance($key = '') {
		return $key ? kindlycare_storage_get_array('inheritance', $key) : kindlycare_storage_get('inheritance');
	}
}



// Detect inheritance key for the current mode
if ( !function_exists( 'kindlycare_detect_inheritance_key' ) ) {
	function kindlycare_detect_inheritance_key() {
		static $inheritance_key = '';
		if (!empty($inheritance_key)) return $inheritance_key;
		$key = apply_filters('kindlycare_filter_detect_inheritance_key', '');
		if (kindlycare_storage_empty('pre_query')) $inheritance_key = $key;
		return $key;
	}
}


// Return key for override parameter
if ( !function_exists( 'kindlycare_get_override_key' ) ) {
	function kindlycare_get_override_key($value, $by) {
		$key = '';
		$inheritance = kindlycare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v[$by]) && in_array($value, $v[$by])) {
					$key = $by=='taxonomy' 
						? $value
						: (!empty($v['override']) ? $v['override'] : $k);
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for categories) by post_type from inheritance array
if ( !function_exists( 'kindlycare_get_taxonomy_categories_by_post_type' ) ) {
	function kindlycare_get_taxonomy_categories_by_post_type($value) {
		$key = '';
		$inheritance = kindlycare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy']) ? $v['taxonomy'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for tags) by post_type from inheritance array
if ( !function_exists( 'kindlycare_get_taxonomy_tags_by_post_type' ) ) {
	function kindlycare_get_taxonomy_tags_by_post_type($value) {
		$key = '';
		$inheritance = kindlycare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy_tags']) ? $v['taxonomy_tags'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}
?>
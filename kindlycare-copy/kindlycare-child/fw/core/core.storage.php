<?php
/**
 * KindlyCare Framework: theme variables storage
 *
 * @package	kindlycare
 * @since	kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('kindlycare_storage_get')) {
	function kindlycare_storage_get($var_name, $default='') {
		global $KINDLYCARE_STORAGE;
		return isset($KINDLYCARE_STORAGE[$var_name]) ? $KINDLYCARE_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('kindlycare_storage_set')) {
	function kindlycare_storage_set($var_name, $value) {
		global $KINDLYCARE_STORAGE;
		$KINDLYCARE_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('kindlycare_storage_empty')) {
	function kindlycare_storage_empty($var_name, $key='', $key2='') {
		global $KINDLYCARE_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($KINDLYCARE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($KINDLYCARE_STORAGE[$var_name][$key]);
		else
			return empty($KINDLYCARE_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('kindlycare_storage_isset')) {
	function kindlycare_storage_isset($var_name, $key='', $key2='') {
		global $KINDLYCARE_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($KINDLYCARE_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($KINDLYCARE_STORAGE[$var_name][$key]);
		else
			return isset($KINDLYCARE_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('kindlycare_storage_inc')) {
	function kindlycare_storage_inc($var_name, $value=1) {
		global $KINDLYCARE_STORAGE;
		if (empty($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = 0;
		$KINDLYCARE_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('kindlycare_storage_concat')) {
	function kindlycare_storage_concat($var_name, $value) {
		global $KINDLYCARE_STORAGE;
		if (empty($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = '';
		$KINDLYCARE_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('kindlycare_storage_get_array')) {
	function kindlycare_storage_get_array($var_name, $key, $key2='', $default='') {
		global $KINDLYCARE_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($KINDLYCARE_STORAGE[$var_name][$key]) ? $KINDLYCARE_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($KINDLYCARE_STORAGE[$var_name][$key][$key2]) ? $KINDLYCARE_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('kindlycare_storage_set_array')) {
	function kindlycare_storage_set_array($var_name, $key, $value) {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if ($key==='')
			$KINDLYCARE_STORAGE[$var_name][] = $value;
		else
			$KINDLYCARE_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('kindlycare_storage_set_array2')) {
	function kindlycare_storage_set_array2($var_name, $key, $key2, $value) {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if (!isset($KINDLYCARE_STORAGE[$var_name][$key])) $KINDLYCARE_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$KINDLYCARE_STORAGE[$var_name][$key][] = $value;
		else
			$KINDLYCARE_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('kindlycare_storage_set_array_after')) {
	function kindlycare_storage_set_array_after($var_name, $after, $key, $value='') {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if (is_array($key))
			kindlycare_array_insert_after($KINDLYCARE_STORAGE[$var_name], $after, $key);
		else
			kindlycare_array_insert_after($KINDLYCARE_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('kindlycare_storage_set_array_before')) {
	function kindlycare_storage_set_array_before($var_name, $before, $key, $value='') {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if (is_array($key))
			kindlycare_array_insert_before($KINDLYCARE_STORAGE[$var_name], $before, $key);
		else
			kindlycare_array_insert_before($KINDLYCARE_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('kindlycare_storage_push_array')) {
	function kindlycare_storage_push_array($var_name, $key, $value) {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($KINDLYCARE_STORAGE[$var_name], $value);
		else {
			if (!isset($KINDLYCARE_STORAGE[$var_name][$key])) $KINDLYCARE_STORAGE[$var_name][$key] = array();
			array_push($KINDLYCARE_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('kindlycare_storage_pop_array')) {
	function kindlycare_storage_pop_array($var_name, $key='', $defa='') {
		global $KINDLYCARE_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($KINDLYCARE_STORAGE[$var_name]) && is_array($KINDLYCARE_STORAGE[$var_name]) && count($KINDLYCARE_STORAGE[$var_name]) > 0) 
				$rez = array_pop($KINDLYCARE_STORAGE[$var_name]);
		} else {
			if (isset($KINDLYCARE_STORAGE[$var_name][$key]) && is_array($KINDLYCARE_STORAGE[$var_name][$key]) && count($KINDLYCARE_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($KINDLYCARE_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('kindlycare_storage_inc_array')) {
	function kindlycare_storage_inc_array($var_name, $key, $value=1) {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if (empty($KINDLYCARE_STORAGE[$var_name][$key])) $KINDLYCARE_STORAGE[$var_name][$key] = 0;
		$KINDLYCARE_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('kindlycare_storage_concat_array')) {
	function kindlycare_storage_concat_array($var_name, $key, $value) {
		global $KINDLYCARE_STORAGE;
		if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
		if (empty($KINDLYCARE_STORAGE[$var_name][$key])) $KINDLYCARE_STORAGE[$var_name][$key] = '';
		$KINDLYCARE_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('kindlycare_storage_call_obj_method')) {
	function kindlycare_storage_call_obj_method($var_name, $method, $param=null) {
		global $KINDLYCARE_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($KINDLYCARE_STORAGE[$var_name]) ? $KINDLYCARE_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($KINDLYCARE_STORAGE[$var_name]) ? $KINDLYCARE_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('kindlycare_storage_get_obj_property')) {
	function kindlycare_storage_get_obj_property($var_name, $prop, $default='') {
		global $KINDLYCARE_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($KINDLYCARE_STORAGE[$var_name]->$prop) ? $KINDLYCARE_STORAGE[$var_name]->$prop : $default;
	}
}

// Merge two-dim array element
if (!function_exists('kindlycare_storage_merge_array')) {
    function kindlycare_storage_merge_array($var_name, $key, $arr) {
        global $KINDLYCARE_STORAGE;
        if (!isset($KINDLYCARE_STORAGE[$var_name])) $KINDLYCARE_STORAGE[$var_name] = array();
        if (!isset($KINDLYCARE_STORAGE[$var_name][$key])) $KINDLYCARE_STORAGE[$var_name][$key] = array();
        $KINDLYCARE_STORAGE[$var_name][$key] = array_merge($KINDLYCARE_STORAGE[$var_name][$key], $arr);
    }
}
?>
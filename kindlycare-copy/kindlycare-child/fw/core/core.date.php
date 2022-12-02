<?php
/**
 * KindlyCare Framework: date and time manipulations
 *
 * @package	kindlycare
 * @since	kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Convert date from MySQL format (YYYY-mm-dd) to Date (dd.mm.YYYY)
if (!function_exists('kindlycare_sql_to_date')) {
	function kindlycare_sql_to_date($str) {
		return (trim($str)=='' || trim($str)=='0000-00-00' ? '' : trim(kindlycare_substr($str,8,2).'.'.kindlycare_substr($str,5,2).'.'.kindlycare_substr($str,0,4).' '.kindlycare_substr($str,11)));
	}
}

// Convert date from Date format (dd.mm.YYYY) to MySQL format (YYYY-mm-dd)
if (!function_exists('kindlycare_date_to_sql')) {
	function kindlycare_date_to_sql($str) {
		if (trim($str)=='') return '';
		$str = strtr(trim($str),'/\-,','....');
		if (trim($str)=='00.00.0000' || trim($str)=='00.00.00') return '';
		$pos = kindlycare_strpos($str,'.');
		$d=trim(kindlycare_substr($str,0,$pos));
		$str=kindlycare_substr($str,$pos+1);
		$pos = kindlycare_strpos($str,'.');
		$m=trim(kindlycare_substr($str,0,$pos));
		$y=trim(kindlycare_substr($str,$pos+1));
		$y=($y<50?$y+2000:($y<1900?$y+1900:$y));
		return ''.($y).'-'.(kindlycare_strlen($m)<2?'0':'').($m).'-'.(kindlycare_strlen($d)<2?'0':'').($d);
	}
}

// Return difference or date
if (!function_exists('kindlycare_get_date_or_difference')) {
	function kindlycare_get_date_or_difference($dt1, $dt2=null, $max_days=-1) {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($max_days < 0) $max_days = kindlycare_get_theme_option('show_date_after', 30);
		if ($dt2 == null) $dt2 = date('Y-m-d H:i:s');
		$dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			if (abs($days) < $max_days)
				return sprintf($days >= 0 ? esc_html__('%s ago', 'kindlycare') : esc_html__('in %s', 'kindlycare'), kindlycare_get_date_difference($days >= 0 ? $dt1 : $dt2, $days >= 0 ? $dt2 : $dt1));
			else
				return kindlycare_get_date_translations(date(get_option('date_format'), $dt1n));
		} else
			return kindlycare_get_date_translations($dt1);
	}
}

// Difference between two dates
if (!function_exists('kindlycare_get_date_difference')) {
	function kindlycare_get_date_difference($dt1, $dt2=null, $short=1, $sec = false) {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($dt2 == null) $dt2n = time()+$gmt_offset*3600;
		else $dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			$months = floor($days / 30);
			$diff -= $days * 24 * 3600;
			$hours = floor($diff / 3600);
			$diff -= $hours * 3600;
			$min = floor($diff / 60);
			$diff -= $min * 60;
			$rez = '';
			if ($months > 0 && $short == 2)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($months > 1 ? esc_html__('%s months', 'kindlycare') : esc_html__('%s month', 'kindlycare'), $months);
			if ($days > 0 && ($short < 2 || $rez==''))
				$rez .= ($rez!='' ? ' ' : '') . sprintf($days > 1 ? esc_html__('%s days', 'kindlycare') : esc_html__('%s day', 'kindlycare'), $days);
			if ((!$short || $rez=='') && $hours > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($hours > 1 ? esc_html__('%s hours', 'kindlycare') : esc_html__('%s hour', 'kindlycare'), $hours);
			if ((!$short || $rez=='') && $min > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($min > 1 ? esc_html__('%s minutes', 'kindlycare') : esc_html__('%s minute', 'kindlycare'), $min);
			if ($sec || $rez=='')
				$rez .=  $rez!='' || $sec ? (' ' . sprintf($diff > 1 ? esc_html__('%s seconds', 'kindlycare') : esc_html__('%s second', 'kindlycare'), $diff)) : esc_html__('less then minute', 'kindlycare');
			return $rez;
		} else
			return $dt1;
	}
}

// Prepare month names in date for translation
if (!function_exists('kindlycare_get_date_translations')) {
	function kindlycare_get_date_translations($dt) {
		return str_replace(
			array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
				  'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
			array(
				esc_html__('January', 'kindlycare'),
				esc_html__('February', 'kindlycare'),
				esc_html__('March', 'kindlycare'),
				esc_html__('April', 'kindlycare'),
				esc_html__('May', 'kindlycare'),
				esc_html__('June', 'kindlycare'),
				esc_html__('July', 'kindlycare'),
				esc_html__('August', 'kindlycare'),
				esc_html__('September', 'kindlycare'),
				esc_html__('October', 'kindlycare'),
				esc_html__('November', 'kindlycare'),
				esc_html__('December', 'kindlycare'),
				esc_html__('Jan', 'kindlycare'),
				esc_html__('Feb', 'kindlycare'),
				esc_html__('Mar', 'kindlycare'),
				esc_html__('Apr', 'kindlycare'),
				esc_html__('May', 'kindlycare'),
				esc_html__('Jun', 'kindlycare'),
				esc_html__('Jul', 'kindlycare'),
				esc_html__('Aug', 'kindlycare'),
				esc_html__('Sep', 'kindlycare'),
				esc_html__('Oct', 'kindlycare'),
				esc_html__('Nov', 'kindlycare'),
				esc_html__('Dec', 'kindlycare'),
			),
			$dt);
	}
}
?>
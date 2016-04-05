<?php
/*
Plugin Name: Online Scout Manager
Description: A collection of widgets to display data from OSM on your site.
Version: 1.1
Author: Online Youth Manager Ltd, mattradford
License:

  Copyright 2012 Online Youth Manager Ltd.
v
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

require( 'coming-up.php' );
require( 'patrol-points.php' );
require( 'admin-page.php' );
require( 'page-replaces/challenge-badges.php' );
require( 'page-replaces/programme.php' );
require( 'page-replaces/events.php' );
function register_osm_widgets() {
	register_widget( 'OSM_PatrolPoints' );
	register_widget( 'OSM_Whats_Next' );
}
add_action( 'widgets_init', 'register_osm_widgets' );

function osm_query( $url, $parts = null ) {
	global $online_scout_manager_userid, $online_scout_manager_secret;
	if ( null == $parts ) {
		$parts = array();
		$parts['userid'] = get_option( 'online_scout_manager_userid' );
		$parts['secret'] = get_option( 'online_scout_manager_secret' );
	}
	$parts['token'] = 'd8b23abdba6fcf0f9f9ff2a987fbd62c';
	$parts['apiid'] = 175;

	$data = '';
	foreach ( $parts as $key => $val ) {
		$data . = '&' . $key . '=' . urlencode( $val );
	}
	$curl_handle = curl_init();
	curl_setopt( $curl_handle, CURLOPT_URL, 'https://www.onlinescoutmanager.co.uk/' . $url );
	curl_setopt( $curl_handle, CURLOPT_POSTFIELDS, substr( $data, 1 ) );
	curl_setopt( $curl_handle, CURLOPT_POST, 1 );
	curl_setopt( $curl_handle, CURLOPT_CONNECTTIMEOUT, 2 );
	curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, 1 );
	$msg = curl_exec( $curl_handle );
	return json_decode( $msg, true );
}
function osm_get_terms() {
	$terms = get_cached_osm( 'terms' );
	if ( ! $terms ) {
		$terms = osm_query( 'api.php?action=osm_get_terms' );
		update_cached_osm( 'terms', $terms );
	}
	$active_roles = get_option( 'online_scout_manager_active_roles' );
	if ( is_array( $active_roles ) ) {
		foreach ( $active_roles as $sectionid => $role ) {
			$termid = 0;
			foreach ( $terms[ $role['sectionid'] ] as $term ) {
				if ( $term['past'] ) {
					$termid = $term['termid'];
				}
			}
			$role['termid'] = $termid;
			$active_roles['$sectionid'] = $role;
		}
		update_option( 'online_scout_manager_active_roles', $active_roles );
	}
}
function get_cached_osm( $key ) {
	$val = get_option( 'online_scout_manager_' . $key );
	if ( $val and $val['time'] > time() - 86400 ) {
		return $val['content'];
	} else {
		return false;
	}
}
function update_cached_osm( $key, $val, $time_offset = 0 ) {
	$values['time'] = time() + $time_offset;
	$values['content'] = $val;
	update_option( 'online_scout_manager_' . $key, $values );
}
?>

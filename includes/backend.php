<?php
defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

//Register Contest Post Type
function jw_register_contest_post_type() {

	$labels = [
		"name" => __( "Photo Contests", "gp-child" ),
		"singular_name" => __( "Photo Contest", "gp-child" ),
	];

	$args = [
		"label" => __( "Photo Contests", "gp-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => PREFIX . "_photo_contest", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( PREFIX . "_photo_contest", $args );
}
add_action( 'init', 'jw_register_contest_post_type' );
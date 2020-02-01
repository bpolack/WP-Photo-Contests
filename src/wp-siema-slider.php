<?php
/**
* Plugin Name: WP Siema Slider
* Plugin URI: https://infinus.ca
* Description: Siema slider shortcode and slide CPT for Wordpress
* Version: 1.0
* Author: Braighton Polack
**/

//Register scripts and styles
function wp_siema_register_scripts() {
    wp_register_style( 'wp-siema-style', plugins_url( '/wp-siema-slider.css', __FILE__ ), array(), '1.0.0', 'all' );
    wp_register_script( 'siema-slider', plugins_url( '/siema.min.js', __FILE__ ), '', '', true );
    wp_register_script( 'wp-siema-script', plugins_url( '/wp-siema-script.js', __FILE__ ), '', '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wp_siema_register_scripts' );


//Register Post Type and Taxonomy
function cptui_register_my_cpts_siema_slide() {

	$labels = [
		"name" => __( "Siema Sliders", "gp-child" ),
		"singular_name" => __( "Siema Slider", "gp-child" ),
	];

	$args = [
		"label" => __( "Siema Sliders", "gp-child" ),
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
		"rewrite" => [ "slug" => "siema_slide", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "siema_slide", $args );
}
add_action( 'init', 'cptui_register_my_cpts_siema_slide' );

function cptui_register_my_taxes_slider_category() {

	$labels = [
		"name" => __( "Slider Categories", "gp-child" ),
		"singular_name" => __( "Slider Category", "gp-child" ),
	];

	$args = [
		"label" => __( "Slider Categories", "gp-child" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'slider_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "slider_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "slider_category", [ "siema_slide" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_slider_category' );

/*
*************
	Function: sc_siema_slides
	Loads a siema slider based sc args
*************
*/
function sc_siema_slides( $atts ) {
	
	//Include Shortcode Styles + Siema Script
    wp_enqueue_style( 'wp-siema-style' );
    wp_enqueue_script( 'siema-slider' );
    wp_enqueue_script( 'wp-siema-script' );
	
	//Post Type Vars
    $slider_post_type = 'siema_slide';
    $slider_tax = 'slider_category';
	
	//Get Shortcode Attributes
	$a = shortcode_atts( array(
        'slider_category_slug' => '',
        'numresults' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ), $atts );
	
	ob_start();
    
    //Query Slides
    create_slides($slider_post_type, $slider_tax, $a['numresults'], htmlspecialchars($a['orderby']), htmlspecialchars($a['order']), htmlspecialchars($a['slider_category_slug']));
	
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('wp_siema_slider', 'sc_siema_slides');

/*
*************
	Function: create_slides
	Creates slides using a wp query
*************
*/
function create_slides($post_type, $taxonomy, $numresults, $orderby, $order, $category) {
    
    //Basic Query Args
    $queryargs = array(
        'post_type' => $post_type,
        'posts_per_page' => $numresults,
        'orderby' => $orderby,
        'order' => $order,
        'post_status' => 'publish',
    );

    //Taxonomy Query Args
	$tax_args = array('relation' => 'AND');
	if ( !empty($category) ) {
	    $cat_tax_query = array(
			'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $category,
		);
		$tax_args[] = $cat_tax_query;
    }
    
    //Construct finalized Query Args
    $queryargs['tax_query'] = $tax_args;
    
    echo '<div class="wp-siema-wrapper"><div class="wp-siema-slider">';

    $query = new WP_Query( $queryargs );
	if ( $query->have_posts() ):
        while ( $query->have_posts() ):
            
            $query->the_post();
            global $post;
            
            $slide_image = get_post_thumbnail_id();	
            $slide_image_size = 'full';
            ?>

            <div class="siema-slide">
                <div class="siema-slide-image">
                    <?php echo wp_get_attachment_image( $slide_image, $slide_image_size ); ?>
                </div>
                <div class="siema-slide-content-wrapper">
                    <div class="siema-slide-content">
                        <div class="siema-slide-content-width">
                            <?php echo get_the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        endwhile;
    else:
        echo '<span class="none-found">No slides found in this category.</span>';
    endif;

    echo '</div></div>';

    wp_reset_postdata();

}
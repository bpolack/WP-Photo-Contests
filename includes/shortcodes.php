<?php
defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

/*
*************
	Function: generate_photo_contest
	Loads a photo contest by ID
*************
*/
function generate_photo_contest( $atts ) {

    //Get Shortcode Attributes
	$a = shortcode_atts( array(
        'contest_id' => ''
    ), $atts );
	
	//Include Shortcode Styles + Siema Script
    wp_enqueue_style( PREFIX . '-contest-style' );
    wp_enqueue_script( PREFIX . '-siema-slider' );
    wp_enqueue_script( PREFIX . '-contest-scripts-siema' );
    wp_enqueue_script( PREFIX . '-contest-scripts' );
	
	ob_start();

    ?>
    <div class="wp-photo-contest" id="wp-photo-contest-id-<?php echo $a['contest_id']; ?>">
        <div class="wp-photo-contest-header">
            <h2 class="wp-photo-contest-title"><?php echo get_the_title( $a['contest_id'] ); ?></h2>
            <div class="wp-photo-contest-body">
                <?php echo get_the_content( null, false, $a['contest_id'] ); ?>
            </div>
        </div>
        <?php
        
        // Create the Photo Slides
        create_slides($a['contest_id']);

        ?>
        <div class="wp-photo-contest-instructions">
            <p>Rate each photo in the slider above, then you can cast your vote.</p>
        </div>
        <div class="wp-photo-contest-form-details" id="wp-photo-contest-form-details-<?php echo $a['contest_id']; ?>">
            <div class="contest-form-half">
                <input type="text" class="voter-name" name="wp-photo-contest-name" placeholder="Your Name" required />
            </div>
            <div class="contest-form-half">
                <input type="email" class="voter-email"  name="wp-photo-contest-email" placeholder="Your Email" required />
            </div>
            <div class="contest-form-full">
                <input type="submit" class="button voter-submit" value="Submit Your Votes" />
            </div>
            
        </div>
        </form>
    </div>
    <?php
	
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('wp_photo_contest', 'generate_photo_contest');

/*
*************
	Function: create_slides
	Creates slides using the gallery field of a contest
*************
*/
function create_slides($contest_id) {

    $images = get_field('contest_photos', $contest_id);
    
    if ( $images ):
        $image_num = 1;
        $total_images = count($images);
        echo '<form class="wp-photo-contest-form" id="wp-photo-contest-form-'.$contest_id.'" method="post" onsubmit="validateForm(this)" >';

        echo '<div class="wp-siema-wrapper"><div class="wp-siema-slider">';
        foreach( $images as $image ):
            ?>

            <div class="siema-slide">
                <div class="siema-slide-image">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                </div>
                <div class="siema-slide-content-wrapper">
                    <div class="siema-slide-content">
                        <h3>Photo <?php echo $image_num . '/' . $total_images; ?></h3>
                        <p class="contest-image-caption"><?php echo esc_html($image['caption']); ?></p>
                        <div class="star-rating" data-contest-id="<?php echo $contest_id; ?>" data-image-num="<?php echo $image_num; ?>" data-image-name="<?php echo esc_attr($image['title']); ?>">
                            <span data-rating="1"></span>
                            <span data-rating="2"></span>
                            <span data-rating="3"></span>
                            <span data-rating="4"></span>
                            <span data-rating="5"></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $image_num++;
        endforeach;
        echo '</div></div>';
    else:
        echo '<span class="none-found">No photos found for this contest.</span>';
    endif;

}
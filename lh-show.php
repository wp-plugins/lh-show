<?php
/*
Plugin Name: LH Show
Plugin URI: http://localhero.biz/plugins/lh-show/
Description: An implementation of Galleria classic theme as a plugin
Version: 0.07
Author: Peter Shaw
Author URI: http://shawfactor.com/

== Changelog ==

= 0.01 =
* Initial release
= 0.02 =
* Added shortcodes
= 0.03 =
* External links on Carousel and Slider
= 0.04 =
*Removed Carousel
= 0.05 =
Changed Slider to be based on Galleria classic theme
= 0.06 =
*Fixed extract from string in post formats
= 0.07 =
*Upgraded to version 1.2.9 and removed jquery override

License:
Released under the GPL license
http://www.gnu.org/copyleft/gpl.html

Copyright 2011  Peter Shaw  (email : pete@localhero.biz)


This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published bythe Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Size for LH Show Slider
 add_image_size( 'lh-show-featured', 480, 360, true );


function lh_show_extract_from_string($start, $end, $tring) {
	$tring = stristr($tring, $start);
	$trimmed = stristr($tring, $end);
	return substr($tring, strlen($start), -strlen($trimmed));
}


function lh_show_print_galleria_json(){

global $post;

$featuredPosts = new WP_Query();

$category_id = get_cat_ID('featured');

$featuredPosts->query("showposts=5&cat=$category_id");  

$stack = array();



for($i=1; $i<=$featuredPosts; $i++) { // start for() loop  

while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); // loop for posts titles

$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');

$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'lh-show-featured');

$thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');

$format = get_post_format();

$content = get_the_content();



if ($format == "video"){

$pattern = '|^\s*(https?://[^\s"]+)\s*$|im';

if (preg_match_all($pattern,$content,$matches)) {

$foo[video] = $matches[1][0];

}


$foo[thumb] = $thumbnail_image_url[0];
$foo[title] = $post->post_title;
$foo[description] = $post->post_excerpt;


} elseif ($format == "link") {

$link_string = lh_show_extract_from_string('<a href=', '/a>', $content);
$link_bits = explode('"', $link_string);


foreach( $link_bits as $bit ) {
	if( substr($bit, 0, 1) == '>') $link_text = substr($bit, 1, strlen($bit)-2);
	if( substr($bit, 0, 4) == 'http') $link_url = $bit;

}


if ($link_url){

$foo[link] = $link_url;

} else {

$foo[link] = get_permalink($post->ID);

}


$foo[thumb] = $thumbnail_image_url[0];
$foo[image] = $medium_image_url[0];
$foo[big] = $full_image_url[0];
$foo[title] = $post->post_title;
$foo[description] = $post->post_excerpt;
$foo[layer] = $post->post_excerpt;




} else {

$foo[thumb] = $thumbnail_image_url[0];
$foo[image] = $medium_image_url[0];
$foo[big] = $full_image_url[0];
$foo[title] = $post->post_title;
$foo[description] = $post->post_excerpt;
$foo[link] = get_permalink($post->ID);
$foo[layer] = $post->post_excerpt;

}

array_push($stack, $foo);

unset($foo);

endwhile;  

} 

return $stack;

}






function lh_show_print_galleria(){



?>



<!-- load Galleria -->
<script src="<?php echo plugins_url( '' , __FILE__ );  ?>/galleria/galleria-1.2.9.js"></script>
 
<script>



// Load the classic theme
Galleria.loadTheme('<?php echo plugins_url( '' , __FILE__ );  ?>/galleria/themes/classic/galleria.classic.js');

<?php

$test = lh_show_print_galleria_json();


echo "var test = ".json_encode($test);

?>


// Initialize Galleria
Galleria.run('#galleria', {
    dataSource: test ,
    height: 320,
extend: function() {
        this.play(4000); // will advance every 4th second
    }


});



</script>

<?php

}


function lh_show_galleria_short_func( $atts ) {
	extract( shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts ) );

add_action('wp_footer', 'lh_show_print_galleria');

return "<div id=\"galleria\"></div><span id=\"lh_show_plugin_url\" data-lh_show_plugins_url=\"".plugins_url( '' , __FILE__ )."\" > </span><span id=\"fullscreen\">Fullscreen</span>";



}

add_shortcode( 'lh_show_galleria_short', 'lh_show_galleria_short_func' );






function lh_show_print_carousel($var){

global $post;

if (!$var){

$var = "sponsors";

}

$page = get_page_by_title($var);


$carouselPosts = new WP_Query();
$carouselPosts->query("showposts=10&post_parent=$page->ID&post_type=page");

?>

<script>
jQuery("html").addClass("placid_slider_fouc");

jQuery(document).ready(function() {
		   jQuery(".placid_slider_fouc .placid_slider").css({"display" : "block"});
		});
		jQuery(document).ready(function() {
			jQuery("#placid_slider_1").simplyScroll({
				className: "placid_slider_instance",
				autoMode: "loop",
				
				estimatedwidth:200,
				speed:2
			});
		});



</script>

<div class="placid_slider placid_slider_div">
<div class="placid_slider_handle placid_slider_handle_div">

<div id="placid_slider_1">

<?php


for($i=1; $i<=$carouselPosts; $i++) { // start for() loop  


while ($carouselPosts->have_posts()) : $carouselPosts->the_post(); // loop for posts titles


$carousel_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'lh-show-carousel');



?>

<div class="placid_slideri placid_item_div">
<!-- placid_slideri -->
<a href="<?php if ( get_post_meta($post->ID, 'link_url', true) ){
echo get_post_meta($post->ID, 'link_url', true);
} else { 
the_permalink(); 
} ?>" title="<?php echo $post->post_title; ?>">
<img src="<?php echo $carousel_image[0]; ?>" alt="<?php echo $post->post_title; ?>" class="slider_thumbnail full placid_slider_thumbnail slider_thumbnail_img"  width="<?php echo $carousel_image[1]; ?>" height="<?php echo $carousel_image[2]; ?>" />
</a>
<div class="placid_text">
<h2 class="placid_header">
<a href="<?php if ( get_post_meta($post->ID, 'link_url', true) ){
echo get_post_meta($post->ID, 'link_url', true);
} else { 
the_permalink(); 
} ?>" class="placid_text_anchor"><?php echo $post->post_title; ?></a>
</h2>
<!-- /placid_slideri -->
</div>
</div>




<?php

endwhile;  



}

?>


</div>
</div>
</div>



<?php

}


function lh_show_create_carousel($arg) {
do_action( "lh_show_create_carousel", $arg );
}

add_action("lh_show_create_carousel","lh_show_print_carousel", 10, 1 ); 


function lh_show_scripts_method() {
	wp_enqueue_script(
		'lh_smooth_cript',
		plugins_url('/scripts/placid.js', __FILE__),
		array('jquery')
	);
} 



function lh_show_return_slider_iframe($atts){

$foo = "<iframe src=\"".get_bloginfo('wpurl')."/wp-content/plugins/lh-show/\" frameborder=\"0\" scrolling=\"no\" width=\"600\" height=\"450\"></iframe>";

    return $foo;  

} 

add_shortcode( 'lh_show_slider_iframe', 'lh_show_return_slider_iframe' );


function lh_show_return_carousel_iframe($atts){
$foo = "<iframe src=\"".get_bloginfo('wpurl')."/wp-content/plugins/lh-show/placid.php\" frameborder=\"0\" scrolling=\"no\" width=\"95%\" height=\"200\"></iframe>";

    return $foo;  

} 

add_shortcode( 'lh_show_carousel_iframe', 'lh_show_return_carousel_iframe' );

// Enable use of the shortcode in text widgets
			add_filter( 'widget_text', 'do_shortcode' );

function lh_show_modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
//wp_deregister_script('jquery');
//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js', false, '1.8.2');
		wp_enqueue_script('jquery');
	}
}

add_action('init', 'lh_show_modify_jquery');

function lh_show_enqueue_jquery() {
if (!wp_script_is( 'jquery', $list =  'queue')){
wp_enqueue_script('jquery');
}
}    
 
//add_action('wp_enqueue_scripts', 'lh_show_enqueue_jquery');


?>
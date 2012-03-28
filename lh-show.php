<?php
/*
Plugin Name: LH Show
Plugin URI: http://localhero.biz/plugins/lh-show/
Description: PGS take on sliders and carousels
Version: 0.02
Author: Peter Shaw
Author URI: http://shawfactor.com/

== Changelog ==

= 0.01 =
* Initial release
= 0.02 =
* Added shortcodes

License:
Released under the GPL license
http://www.gnu.org/copyleft/gpl.html

Copyright 2011  Peter Shaw  (email : pete@localhero.biz)


This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published bythe Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Size for LH Show Slider
 add_image_size( 'lh-show-featured', 600, 450, true );


//Size for LH Show Carousel
 add_image_size( 'lh-show-carousel', 300, 200, true );


function lh_show_print_slider(){

global $post;

$featuredPosts = new WP_Query();  

$featuredPosts->query('showposts=5&cat=28');  

echo "<div id=\"myGallerySet\">\n<div id=\"myGallery\" class=\"galleryElement\">\n";


for($i=1; $i<=$featuredPosts; $i++) { // start for() loop  

while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); // loop for posts titles

$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'lh-show-featured');

$thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');

?>  

<div class="imageElement">
<h3><?php echo $post->post_title; ?></h3>
<p><?php echo $post->post_excerpt; ?></p>
<a href="<?php the_permalink(); ?>" title="open image" class="open"></a>
<img src="<?php echo $medium_image_url[0];  ?>" class="full" />
<img src="<?php echo $thumbnail_image_url[0]; ?>" class="thumbnail" />
</div>

<?php endwhile;  

} 

echo "</div></div>";

}


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


$carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'lh-show-carousel');





?>

<div class="placid_slideri placid_item_div">
<!-- placid_slideri -->
<a href="<?php the_permalink(); ?>" title="<?php echo $post->post_title; ?>">
<img src="<?php echo $carousel_image_url[0]; ?>" alt="<?php echo $post->post_title; ?>" class="slider_thumbnail full placid_slider_thumbnail slider_thumbnail_img"  width="300" height="200" />
</a>
<div class="placid_text">
<h2 class="placid_header">
<a href="<?php the_permalink(); ?>" class="placid_text_anchor"><?php echo $post->post_title; ?></a>
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

function lh_show_return_carousel_iframe($atts){
$foo = "<iframe src=\"http://www.royalparktouch.com/wp-content/plugins/lh-show/placid.php\" frameborder=\"0\" scrolling=\"no\" width=\"700\" height=\"200\"></iframe>";

    return $foo;  

} 

add_shortcode( 'lh_show_carousel_iframe', 'lh_show_return_carousel_iframe' );

// Enable use of the shortcode in text widgets
			add_filter( 'widget_text', 'do_shortcode' );

?>
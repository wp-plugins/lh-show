<?php
/*
Plugin Name: LH Show
Plugin URI: http://localhero.biz/plugins/lh-show/
Description: PGS take on sliders and carousels
Version: 0.01
Author: Peter Shaw
Author URI: http://shawfactor.com/
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

<script type="text/javascript" src="scripts/carousel_start.js"></script>

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


?>
<?php

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
include("../../../wp-blog-header.php");
?>
<html>
<head>
<title>Auto-Sliding Logo, Images, Text on WordPress with Placid Slider Plugin</title>



<link rel="stylesheet" id="placid_slider_headcss-css"  href="css/placid.css" type="text/css" media="all" />

<?php add_action('wp_enqueue_scripts', 'lh_show_scripts_method'); ?>



<?php wp_head(); ?>




</head>

<body>

<?php lh_show_create_carousel(); ?>




	
</body>
</html>

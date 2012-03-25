<?php

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
include("../../../wp-blog-header.php");



?>
<html>
<head>
<title>LH Show Gallery Test</title>
<link rel="stylesheet" href="css/jd.gallery.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" charset="utf-8" />
<script src="scripts/mootools-1.2.1-core-yc.js" type="text/javascript"></script>
<script src="scripts/mootools-1.2-more.js" type="text/javascript"></script>
<script src="scripts/jd.gallery.js" type="text/javascript"></script>

</head>
<body>
<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true
				});
			}
			window.addEvent('domready',startGallery);
</script>

<div class="content">

<?php

lh_show_print_slider();

?>
</div>
</body>
</html>

<?php


?>
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

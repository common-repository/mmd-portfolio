 //Normal Tooltips
jQuery( function() {
  jQuery(".mmd_entry a .dashicons" ).tooltip({
	  position:{ my: "left",
               at: "left+30"}
	});
});
  

//Image Tooltip
 jQuery( function() {
	jQuery("input[value='gen_dec_one']" ).parent().prop('title', '""');
  jQuery("input[value='gen_dec_one']" ).parent().tooltip({
	        content: '<img class="tooltip_dec_sample" src="/wp/wp-content/plugins/mmd_pf/img/corners.png"/>'
	        });
	jQuery("input[value='gen_dec_two']" ).parent().prop('title', '""');
  jQuery("input[value='gen_dec_two']" ).parent().tooltip({
	        content: '<img class="tooltip_dec_sample" src="/wp/wp-content/plugins/mmd_pf/img/twocorners.png"/>'
	        });
	jQuery("input[value='gen_dec_three']" ).parent().prop('title', '""');
  jQuery("input[value='gen_dec_three']" ).parent().tooltip({
	        content: '<img class="tooltip_dec_sample" src="/wp/wp-content/plugins/mmd_pf/img/tiltedcorners.png"/>'
        });
	jQuery("input[value='gen_dec_four']" ).parent().prop('title', '""');
  jQuery("input[value='gen_dec_four']" ).parent().tooltip({
	        content: '<img class="tooltip_dec_sample" src="/wp/wp-content/plugins/mmd_pf/img/lines.png"/>'
	        });
	jQuery("input[value='gen_dec_five']" ).parent().prop('title', '""');
  jQuery("input[value='gen_dec_five']" ).parent().tooltip({
	        content: '<img class="tooltip_dec_sample" src="/wp/wp-content/plugins/mmd_pf/img/angled.png"/>'
	        });
});
  
  

//Remove the ability to drag and sort metaboxes
jQuery(document).ready( function() {
  jQuery('.meta-box-sortables').sortable({
      disabled: true
  });
  jQuery('.postbox .hndle').css('cursor', 'pointer');
});



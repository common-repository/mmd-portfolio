<?php
/**
 * Plugin Name: MMD Portfolio
 * Plugin URI: https://portfolio-plugin.makermandesign.nl/
 * Description: The MMD portfolio allows users to present their portfolio of work in a clear, visual manner. Features hover and filter animations. 
 * Version: 1.0.0
 * Author: MakerMan Design
 * Author URI: https://www.makermandesign.nl
 * License: GPL2
 */
  
 /*********************************************
 ******		On/Off/Uninstall			*******
 *********************************************/
	 //Activation function
	 function mmd_activate(){
		 
	 }
	 register_activation_hook(__FILE__, 'mmd_activate');
	 
	 //Deactivation function
	 function mmd_deactivate(){
		 
	 }
	 register_deactivation_hook(__FILE__, 'mmd_deactivate');
	 
	 
	 
 /*********************************************
 ******		Plugin CSS/Scripts			*******
 *********************************************/

	 //Scripts - jQuery, jQueryUI and Mixitup for now 
	 add_action('wp_enqueue_scripts', 'mmd_scripts');
	 function mmd_scripts(){
		wp_enqueue_script('jquery');
			wp_register_script('isotope', plugins_url('js/isotope.pkgd.min.js', __FILE__), array('jquery'));
		wp_enqueue_script('isotope');	//Isotope
			wp_register_script('hoverdir', plugins_url('js/jquery-hover-effect.js', __FILE__), array('jquery'));
		wp_enqueue_script('hoverdir');	//Hoverdir 
			wp_register_script('JS-init', plugins_url('js/JS-init.js', __FILE__));
		wp_enqueue_script('JS-init');	//Will contain the initializer code 
	 }
	 
	 //Styles - Basic Stylesheet and Responsiveness
	 add_action('wp_enqueue_scripts', 'mmd_styles');
	 function mmd_styles(){
			wp_register_style('mmd_style', plugins_url('css/mmd_pf_styles.css', __FILE__));
		wp_enqueue_style('mmd_style');
			wp_register_style('mmd_style_responsive', plugins_url('css/mmd_pf_responsive.css', __FILE__));
		wp_enqueue_style('mmd_style_responsive');
 }
 
 
 /*********************************************
 ******		Admin CSS/Scripts			*******
 *********************************************/
	 add_action( 'admin_head', 'mmd_admin_scripts' );
	 function mmd_admin_scripts(){
		wp_enqueue_script('jquery-ui-tooltip');
			wp_register_style('jqueryui-structure', plugins_url('css/jquery-ui.structure.min.css', __FILE__));
		wp_enqueue_style('jqueryui-structure');
			wp_register_style('jqueryui-theme', plugins_url('css/jquery-ui.theme.min.css', __FILE__));
		wp_enqueue_style('jqueryui-theme');
			wp_register_style('mmdAdminMenu', plugins_url('css/mmdAdminMenu.css', __FILE__));
		wp_enqueue_style('mmdAdminMenu');
			wp_register_script('js-admin-init', plugins_url('js/js-admin-init.js', __FILE__));
		wp_enqueue_script('js-admin-init');	//Will contain the initializer code 

		
	 }
	 
 /*********************************************
 ******			Custom Taxonomy			*******
 *********************************************/
add_action('init', 'create_mmd_taxonomy',0);
function create_mmd_taxonomy(){
$labels = array(
    'name' => _x('Filters', 'taxonomy general name', 'mmd_pf'),
    'singular_name' => _x('Filter', 'taxonomy singular name', 'mmd_pf'),
    'all_items' => __('All Filters', 'mmd_pf'),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __('Edit Filter', 'mmd_pf'), 
	'search_items' => __('Search Filters','mmd_pf'),
    'update_item' => __('Update Filter', 'mmd_pf'),
    'add_new_item' => __('Add New Filter', 'mmd_pf'),
    'new_item_name' => __('New Filter Name', 'mmd_pf'),
    'add_or_remove_items' => __('Add or remove filters', 'mmd_pf'),
    'menu_name' => __('Filters', 'mmd_pf'),
  ); 

$args= array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
	'show_admin_column' => true,
    'query_var' => true,
	'update_count_callback' => '_update_post_term_count',
	'rewrite' => array( 'slug' => 'filter' ),
  ); 
register_taxonomy('filters', 'mmd_pf', $args);
}


add_action('init', 'add_mmd_filters_to_cpt');
function add_mmd_filters_to_cpt(){
	register_taxonomy_for_object_type('filters', 'mmd_pf');
}	 
 
 
 /*********************************************
 ******		CMB2 Stuff					*******
 *********************************************/
	 //Load up CMB2
	if ( file_exists( __DIR__ . '/includes/cmb2/init.php' ) ) {
	  require_once __DIR__ . '/includes/cmb2/init.php';
	} elseif ( file_exists(  __DIR__ . '/includes/CMB2/init.php' ) ) {
	  require_once __DIR__ . '/includes/CMB2/init.php';
	} 

	 //Import my CMB2-metaboxes
	 add_action('cmb2_init', 'mmd_pf_register_metaboxes');
	 require_once __DIR__.'/includes/mmd-pf-metaboxes.php';
 
 
 
 
 /*********************************************
 ******		Custom Post Type			*******
 *********************************************/
	 //Register Post Type and settings
	 add_action('init', 'mmd_register_pf_type');
	 function mmd_register_pf_type(){
		$labels = array(
			'name' 				=> __('MMD Portfolios', 'mmd_pf'), 
			'singular_name'		=> __('MMD Portfolio', 'mmd_pf'), 
			'add_new'			=> __('Add New', 'mmd_pf'), 
			'add_new_item'		=> __('New MMD Portfolio', 'mmd_pf'), 
			'new_item'			=> __('New MMD Portfolio', 'mmd_pf'),
			'edit_item'			=> __('Edit MMD Portfolio', 'mmd_pf'),
			'view_item'			=> __('View MMD Portfolio', 'mmd_pf'),
			'all_items'			=> __('All MMD Portfolios', 'mmd_pf'),
			'search_items' 		=> __('Search Portfolios', 'mmd_pf'),
			'not_found'			=> __('No Portfolios found.', 'mmd_pf'),
			'not_found_in_trash'=> __('No Portfolios found in trash.', 'mmd_pf')
			);
		$args = array(
			'labels'			=> $labels,
			'public'			=> false, 
			'publicly_queryable'=> false,
			'show_ui'			=> true, 
			'show_in_admin_bar'	=> false, 
			'taxonomies'		=> array('filters'),
			'menu_position'		=> 25, 
			'capability_type'	=> 'post', 
			'has_archive'		=> false,
			'hierarchical'		=> false,
			'supports'          => array( 'title' ),
			'menu_icon'			=> 'dashicons-sos' //Pre-existing dashicons save a lot of trouble
		);
		register_post_type('mmd_pf', $args);
	 }
 
 
 
 /*********************************************
 ******		Shortcode Stuff				*******
 *********************************************/
 //Get column to display shortcode in
 add_action('manage_mmd_pf_posts_custom_column', 'mmd_shortcode_column', 10, 2);
 add_filter('manage_mmd_pf_posts_columns', 'add_mmd_column');
	require_once __DIR__.'/shortcodecolumn.php';


 
 //Shortcodes init
 add_shortcode('mmd_pf_insert', 'mmd_shortcode');
 function mmd_shortcode($atts){
	extract(shortcode_atts(array(
		"name" 	=>	''
		), $atts));
		
	//Initialise var that'll display the plugin
	$display = '';
	
	//Grab the current post off WP
	global $post;
	$args = array('post_type' => 'mmd_pf', 'name' => $name);
	$MMD_posts = get_posts($args);
	
	//We now have an array: Instantiate foreach loop to generate shortcode for each post.
	foreach($MMD_posts as $post): setup_postdata($post);
	
	
	//Grab our various items for later
	$groups = get_post_meta($post->ID, '_mmd_single_group', true);
	
	//Start generating our content!
	
	//Opening divs
	$display .= '<div id="MMDcontainer">';
		$display .= '<div id="MMDfiltercontainer">';
			

			//Grab color settings
				$MMDfilterTXT = get_post_meta($post->ID, '_mmd_filter_color_text', true);
				$MMDfiltertxtactive = get_post_meta($post->ID, '_mmd_filter_color_text_active', true);
				$MMDfiltertxtBG = get_post_meta($post->ID, '_mmd_filter_color_background', true);
			
			//Title
			$display .= '<div id="MMDtitle">';
				$mmdtitle = esc_html(get_post_meta($post->ID, '_mmd_menu_title', true ));
				$display .='<h3 style="color: '.$MMDfilterTXT.';">'.$mmdtitle.'</h3>';
			$display .= '</div>';
			
			//Separator
						$display .= '<div id="MMDseparator">';
				$mmdseparatorchoice = get_post_meta($post->ID, '_mmd_menu_separator', true);
				if ($mmdseparatorchoice == 'sep_none'){
					$mmdseparator = '';
				} else if ($mmdseparatorchoice == 'sep_sm'){
					$mmdseparator = '<span style="width: 20%;background-color: '.$MMDfilterTXT.';"></span>';
				} else if( $mmdseparatorchoice == 'sep_med'){
					$mmdseparator = '<span style="width: 50%;background-color: '.$MMDfilterTXT.';"></span>';
				} else if( $mmdseparatorchoice == 'sep_lg'){
					$mmdseparator = '<span style="width: 80%;background-color: '.$MMDfilterTXT.';"></span>';
				}
				$display .= $mmdseparator;
			$display .= '</div>';
	
			//Filters	
			$display .= '<style>#MMDfilters li.active{background:'.$MMDfiltertxtBG.';color:'.$MMDfiltertxtactive.'!important;}</style> ';
			$display .= '<ul id="MMDfilters" class="MMDfilterGroup">';
				$MMDfilterchoices = get_the_terms($post->ID, 'filters');
				
				
				//Establish our "all" filter to include all filter options selected.
				if (!empty($MMDfilterchoices[0])){
					$display .= '<li style="color:'.$MMDfilterTXT.';"class="PFfilter active" data-filter="*">All</li>';
				}
				//Now, loop all day until we're fresh out of filters
				for ($i = 0; $i <= count($MMDfilterchoices) ; $i++){
					if(!empty($MMDfilterchoices[$i]->name)){
					$display .= '<li style="color:'.$MMDfilterTXT.';"	class="PFfilter" data-filter=".'.$MMDfilterchoices[$i]->name.'">';
					$display .= $MMDfilterchoices[$i]->name.'</li>';
					}
				}
			$display .= '</ul>';
		$display .= '</div>'; //Filtercontainer
			
			//Set up the grid for our items
		$display .= '<div id="MMDportfoliocontainer">';
			$display .='<div class="MMDimage_grid portfolio_2col" id="MMDportfoliolist">';
				$display .= '<ul id="MMDlist" class="da-thumbs">';

				//Iterate through all entries!
				$groupsindex = 0;
				if( is_object($groups) || is_array ($groups))
					foreach ($groups as $key => $entry){
						
					//Counter might be useful
					$groupsindex++;
					
					//Instantiate and assign classes/data-cat
					$display .= '<li>';	
					$MMDitemfilterchoices = $entry['_mmd_single_item_filters'];
											
					$display .= '<div class ="MMDportfolio ';

					foreach ($MMDitemfilterchoices as $choicex){
						$display .= $choicex.' ';
					}
					$display .='">';

					$MMDimage = wp_get_attachment_image_src( $entry['_mmd_single_item_image_id'], 'large')[0];
					$MMDimagesize = get_post_meta($post->ID, '_mmd_item_size', true);
						if ($MMDimagesize == 'item_small'){
							$MMDsize = '4';
						} else if ($MMDimagesize == 'item_medium'){
							$MMDsize = '3';
						} else if( $MMDimagesize == 'item_large'){
							$MMDsize = '2';
						}

						//JS to get the size measurements right. Responsiveness is nice! 
						$MMDtextcolor = get_post_meta($post->ID, '_mmd_general_color_text', true);

						$display .='<script>';
							$display .= 'jQuery(document).ready(function(){
								var totalwidth = jQuery(".MMDimage_grid")[0].getBoundingClientRect().width;
								var itemsize = totalwidth / '.$MMDsize.';
								jQuery(".MMDimage").css("width", itemsize);
								jQuery(".MMDimage").css("height", itemsize);
								var fontsize = itemsize / 10;
								var fontsize = fontsize + "px !important";
								jQuery(".articletop h4").attr("style", "font-size: " +  fontsize + "; color:'.$MMDtextcolor.'");
							});';
						$display .='</script>';

						//This second, near identical script, forces recalculation when screen orientation
						//changes on mobile devices.
						$display .='<script>';
							$display .= 'jQuery(window).on("orientationchange", function(){
								setTimeout(function () {
								var totalwidth = jQuery(".MMDimage_grid")[0].getBoundingClientRect().width;
								var itemsize = totalwidth / '.$MMDsize.';
								jQuery(".MMDimage").css("width", itemsize);
								jQuery(".MMDimage").css("height", itemsize);
								var fontsize = itemsize / 10;
								var fontsize = fontsize + "px !important";
								jQuery(".articletop h4").attr("style", "font-size: " +  fontsize + "; color:'.$MMDtextcolor.'");
							}, 250);
							});';
						$display .='</script>';
					
					$display .='<img class="MMDimage" src='.$MMDimage.'>';

					$MMDoverlaycolor = get_post_meta($post->ID, '_mmd_general_color_overlay', true);
					$display .='<article style="background-color:'.$MMDoverlaycolor.'" id="MMDarticle'.$groupsindex.'" class="da-animate da-slideFromRight">';
					
					//Item Link Stuff
					$MMDurl = $entry['_mmd_single_item_link'];
					
					$display .= '<script>';
					$display .= 'jQuery(document).ready(function(){';
					if(!empty ($MMDurl)){	//No URL? Do nothing!
						$display .= 'jQuery("#MMDarticle'.$groupsindex.'").hover(function(){jQuery("#MMDarticle'.$groupsindex.'").css("cursor", "pointer")});'; 
							//Sidestep: repair URL
							if ((substr($MMDurl, 0, 5) == 'http:') || (substr($MMDurl, 0, 6) == 'https:')){
							$display .= 'jQuery("#MMDarticle'.$groupsindex.'").on("click", function(){window.location.href="'.$MMDurl.'";});';
							} else {
							$display .= 'jQuery("#MMDarticle'.$groupsindex.'").on("click", function(){window.location.href="//'.$MMDurl.'";});';
							}
					}
					$display .= '});';
					$display .= '</script>';
					
					

						//Item title
						$display .='<div class="articletop">';
							$display .='<h4>'.$entry['_mmd_single_item_header'].'</h4>';
						$display .='</div>';						
							
							//Decorator
						$display .='<div class="articlemiddle">';
							$mmdgendecoratorchoice = get_post_meta($post->ID, '_mmd_general_decorator', true);
							if ($mmdgendecoratorchoice == 'gen_dec_none'){
								$mmdgendecorator = '';
							} else if ($mmdgendecoratorchoice == 'gen_dec_one'){
								$mmdgendecorator = '<svg xmlns="http://www.w3.org/2000/svg"
														version="1.1"
														id="svg4558"
														viewBox="0 0 284.74024 284.76173"
														height="100%"
														width="100%">
														<g
															transform="translate(-147.72656,-274.41797)"
															id="layer1">
															<g
															transform="matrix(0.81,0,0,0.81,55.118359,79.191789)"
															id="g5160">
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 430.04297,519.17969 c -1.34299,0 -2.42383,1.16503 -2.42383,2.61133 v 32.54101 h -32.54102 c -1.4463,0 -2.61132,1.08084 -2.61132,2.42383 0,1.34299 1.16502,2.42383 2.61132,2.42383 h 34.77735 c 0.0348,0 0.0671,-0.009 0.10156,-0.01 0.0292,0.001 0.0565,0.01 0.0859,0.01 0.622,0 1.18109,-0.25807 1.60937,-0.66992 0.0257,-0.0227 0.0515,-0.0447 0.0762,-0.0684 0.0237,-0.0247 0.0456,-0.0504 0.0684,-0.0762 0.41185,-0.42828 0.66992,-0.98737 0.66992,-1.60937 0,-0.0294 -0.009,-0.0567 -0.01,-0.0859 0.001,-0.0345 0.01,-0.0667 0.01,-0.10156 V 521.791 c 0,-1.4463 -1.08084,-2.61133 -2.42383,-2.61133 z"
																id="rect4245" />
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 150.15039,274.41797 c -0.61814,0 -1.17425,0.25287 -1.60156,0.66015 -0.0317,0.0277 -0.0636,0.0548 -0.0937,0.084 -0.0165,0.0174 -0.0308,0.0367 -0.0469,0.0547 -0.42005,0.42993 -0.68164,0.99609 -0.68164,1.625 0,0.0294 0.009,0.0568 0.01,0.0859 -0.001,0.0338 -0.01,0.0654 -0.01,0.0996 v 34.7793 c 0,1.4463 1.08084,2.61133 2.42383,2.61133 1.34299,0 2.42383,-1.16503 2.42383,-2.61133 V 279.2656 h 32.54101 c 1.4463,0 2.61133,-1.08083 2.61133,-2.42382 0,-1.343 -1.16503,-2.42383 -2.61133,-2.42383 h -34.77929 c -0.0342,0 -0.0658,0.009 -0.0996,0.01 -0.0292,-0.001 -0.0565,-0.01 -0.0859,-0.01 z"
																id="rect4251" />
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 150.15039,519.17969 c -1.34299,0 -2.42383,1.16503 -2.42383,2.61133 v 34.77734 c 0,0.0348 0.009,0.0671 0.01,0.10156 -0.001,0.0292 -0.01,0.0565 -0.01,0.0859 0,0.62297 0.25692,1.18281 0.66992,1.61133 0.0222,0.025 0.0434,0.0501 0.0664,0.0742 0.0253,0.0242 0.0517,0.0471 0.0781,0.0703 0.42808,0.41089 0.98818,0.66797 1.60937,0.66797 0.0295,0 0.0568,-0.009 0.0859,-0.01 0.0338,10e-4 0.0654,0.01 0.0996,0.01 h 34.77929 c 1.4463,0 2.61133,-1.08084 2.61133,-2.42383 0,-1.34299 -1.16503,-2.42383 -2.61133,-2.42383 h -32.54101 v -32.54101 c 0,-1.4463 -1.08084,-2.61133 -2.42383,-2.61133 z"
																id="rect4257" />
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 395.07812,274.41797 c -1.4463,0 -2.61132,1.08083 -2.61132,2.42383 0,1.34299 1.16502,2.42382 2.61132,2.42382 h 32.54102 v 32.54102 c 0,1.4463 1.08084,2.61133 2.42383,2.61133 1.34299,0 2.42383,-1.16503 2.42383,-2.61133 v -34.7793 c 0,-0.0342 -0.009,-0.0658 -0.01,-0.0996 0.001,-0.0292 0.01,-0.0565 0.01,-0.0859 0,-0.62119 -0.25708,-1.1813 -0.66797,-1.60938 -0.0233,-0.0264 -0.0461,-0.0528 -0.0703,-0.0781 -0.0241,-0.023 -0.0492,-0.0443 -0.0742,-0.0664 -0.42852,-0.413 -0.98836,-0.66992 -1.61133,-0.66992 -0.0294,0 -0.0568,0.009 -0.0859,0.01 -0.0345,-0.001 -0.0667,-0.01 -0.10156,-0.01 z"
																id="rect4263" />
															</g>
														</g>
														</svg>';
							} else if( $mmdgendecoratorchoice == 'gen_dec_two'){
								$mmdgendecorator = '<svg xmlns="http://www.w3.org/2000/svg"
														version="1.1"
														id="svg4558"
														viewBox="0 0 325.6543 325.68287"
														height="100%"
														width="100%">
														<g
															transform="translate(-141.22875,-154.12972)"
															id="layer1">
															<g
															style="fill:none;stroke:'.$MMDtextcolor.'"
															id="g5170"
															transform="matrix(0.81,0,0,0.81,-806.18064,683.61559)">
															<path
																style="fill:none;fill-rule:evenodd;stroke:'.$MMDtextcolor.';stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
																d="m 1210.3355,-559.173 v -53.81564 h 103.2202"
																id="path3934" />
															<path
																id="path3936"
																d="m 1530.9893,-346.12191 v 53.81563 h -103.2202"
																style="fill:none;fill-rule:evenodd;stroke:'.$MMDtextcolor.';stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" />
															</g>
														</g>
														</svg>';
							} else if ( $mmdgendecoratorchoice == 'gen_dec_three'){
								$mmdgendecorator = '<svg xmlns="http://www.w3.org/2000/svg"
														version="1.1"
														id="svg4558"
														viewBox="0 0 359.91974 359.92001"
														height="100%"
														width="100%">
														<g
															transform="translate(-179.32802,-238.83008)"
															id="layer1">
															<g
															transform="matrix(0.81,0,0,0.81,68.264696,79.570109)"
															id="g5374">
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 336.98242,572.12891 c -0.57813,-0.0214 -1.14763,0.17888 -1.57422,0.60547 -0.85317,0.85316 -0.79965,2.28042 0.11914,3.19921 l 22.09375,22.09375 c 0.0204,0.0204 0.0436,0.0351 0.0645,0.0547 0.019,0.0207 0.0327,0.0444 0.0527,0.0644 0.3957,0.3957 0.91667,0.58774 1.45117,0.59766 0.0301,0.002 0.0598,0.005 0.0898,0.006 0.0301,-6.5e-4 0.0597,-0.004 0.0898,-0.006 0.5343,-0.01 1.05367,-0.2021 1.44922,-0.59766 0.0187,-0.0187 0.031,-0.0413 0.0488,-0.0605 0.0226,-0.021 0.0483,-0.0366 0.0703,-0.0586 l 22.09375,-22.09375 c 0.9188,-0.91879 0.97231,-2.34605 0.11914,-3.19921 -0.85317,-0.85317 -2.28042,-0.79966 -3.19922,0.11914 l -20.67187,20.67187 -20.67383,-20.67187 c -0.4594,-0.4594 -1.04492,-0.7032 -1.62305,-0.72461 z"
																id="rect3881" />
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 359.25781,238.83008 c -0.0183,6.7e-4 -0.0364,0.007 -0.0547,0.008 -0.5345,0.01 -1.05547,0.20196 -1.45117,0.59766 -0.0201,0.0201 -0.0336,0.0437 -0.0527,0.0644 -0.0209,0.0196 -0.044,0.0343 -0.0645,0.0547 l -22.09375,22.09375 c -0.9188,0.91879 -0.97231,2.34409 -0.11914,3.19726 0.85316,0.85317 2.28042,0.80161 3.19921,-0.11718 l 20.67188,-20.67188 20.67187,20.67188 c 0.9188,0.91879 2.34605,0.97035 3.19922,0.11718 0.85317,-0.85317 0.79966,-2.27847 -0.11914,-3.19726 l -22.09375,-22.09375 c -0.022,-0.022 -0.0477,-0.0376 -0.0703,-0.0586 -0.0179,-0.0193 -0.03,-0.0418 -0.0488,-0.0605 -0.39555,-0.39556 -0.91491,-0.58761 -1.44922,-0.59766 -0.0301,-0.002 -0.0598,-0.005 -0.0898,-0.006 -0.0118,2.5e-4 -0.0233,-0.002 -0.0352,-0.002 z"
																id="rect3887" />
															<path
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																d="m 203.76758,394.32227 c -0.57813,0.0214 -1.1656,0.26325 -1.625,0.72265 l -22.09375,22.09375 c -0.022,0.022 -0.0376,0.0477 -0.0586,0.0703 -0.0192,0.0179 -0.0418,0.0301 -0.0605,0.0488 -0.39556,0.39556 -0.58566,0.91492 -0.59571,1.44922 -0.002,0.0301 -0.005,0.0598 -0.006,0.0899 6.6e-4,0.0307 0.004,0.0611 0.006,0.0918 0.0101,0.53431 0.20015,1.05367 0.59571,1.44922 0.0187,0.0187 0.0413,0.031 0.0605,0.0488 0.021,0.0226 0.0366,0.0483 0.0586,0.0703 l 22.09375,22.09375 c 0.9188,0.9188 2.34605,0.97036 3.19922,0.11719 0.85317,-0.85317 0.79965,-2.27847 -0.11914,-3.19727 l -20.67188,-20.6738 20.67188,-20.67188 c 0.91879,-0.9188 0.97231,-2.34605 0.11914,-3.19922 -0.42659,-0.42658 -0.99609,-0.62493 -1.57422,-0.60351 z"
																id="rect3893" />
															<rect
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																id="rect3899"
																width="35.936546"
																height="4.355823"
																x="642.15405"
																y="-85.840675"
																ry="2.3454432"
																transform="rotate(45)" />
															<rect
																ry="2.3454432"
																y="-678.09058"
																x="-85.840675"
																height="4.355823"
																width="35.936546"
																id="rect3901"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																transform="rotate(135)" />
															</g>
														</g>
														</svg>';
							} else if ( $mmdgendecoratorchoice == 'gen_dec_four'){
								$mmdgendecorator = '<svg xmlns="http://www.w3.org/2000/svg"
														version="1.1"
														id="svg4558"
														viewBox="0 0 284.74059 284.76223"
														height="100%"
														width="100%">
														<g
															transform="translate(-143.34398,-228.55254)"
															id="layer1">
															<g
															style="fill:'.$MMDtextcolor.'"
															id="g5240"
															transform="matrix(0.81,0,0,0.81,-293.9398,1471.4358)">
															<rect
																transform="rotate(90)"
																ry="2.6106498"
																y="-857.99261"
																x="-1378.6447"
																height="4.8483496"
																width="40"
																id="rect4345"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1" />
															<rect
																transform="scale(-1)"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																id="rect4347"
																width="40"
																height="4.8483496"
																x="-735.62231"
																y="1216.2635"
																ry="2.6106498" />
															<rect
																transform="rotate(-90)"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																id="rect4349"
																width="40"
																height="4.8483496"
																x="1338.6447"
																y="573.25201"
																ry="2.6106498" />
															<rect
																ry="2.6106498"
																y="-1501.0258"
																x="695.62225"
																height="4.8483496"
																width="40"
																id="rect4351"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1" />
															</g>
														</g>
														</svg>';
							} else if ( $mmdgendecoratorchoice == 'gen_dec_five'){
								$mmdgendecorator = '<svg xmlns="http://www.w3.org/2000/svg"
														version="1.1"
														id="svg4558"
														viewBox="0 0 259.21774 259.2179"
														height="100%"
														width="100%">
														<g
															transform="translate(-241.1054,-277.75331)"
															id="layer1">
															<g
															transform="matrix(0.81,0,0,0.81,70.435706,77.398827)"
															id="g5234">
															<rect
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																id="rect3959"
																width="45.563931"
																height="5.5227466"
																x="3.1320448"
																y="-712.35699"
																ry="2.9737868"
																transform="rotate(135)" />
															<rect
																ry="2.9737868"
																y="-188.10007"
																x="-572.96521"
																height="5.5227466"
																width="45.563931"
																id="rect3961"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																transform="rotate(-135)" />
															<rect
																ry="2.9737868"
																y="388.00946"
																x="-48.696011"
																height="5.5227466"
																width="45.563931"
																id="rect3963"
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																transform="rotate(-45)" />
															<rect
																style="opacity:1;fill:'.$MMDtextcolor.';fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:46.5;stroke-opacity:1"
																id="rect3965"
																width="45.563931"
																height="5.5227466"
																x="527.40118"
																y="-136.272"
																ry="2.9737868"
																transform="rotate(45)" />
															</g>
														</g>
														</svg>';
							}
							$display .= $mmdgendecorator;
						$display .='</div>';
					
					
					$display .='</article>';
					$display .='</div>';
					$display .= '</li>';
					}
					
					
			
			//Closing Divs		
				$display .= '</ul>'; //Item list			
			$display .= '</div>'; //Image grid
		$display .= '</div>'; //Portfoliocontainer
	$display .= '</div>';	//EVERYTHING
	
	endforeach;
	wp_reset_postdata(); //Restore $post to default
	
	return $display;
 }

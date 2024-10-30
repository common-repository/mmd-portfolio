<?php 
function mmd_shortcode_column($column, $post_id){
	 switch($column){
		 case 'mmd_shortcode' :
		 global $post;
		 $slugname = $post->post_name;
		 $PF_code = '<span style="padding-bottom: 3px;border-bottom: 1px solid #555">[mmd_pf_insert name="'.$slugname.'"]</span>';
		 echo $PF_code;
		 break;
	 }
 }
 function add_mmd_column($columns){
	 return array_merge($columns, 
		array('mmd_shortcode' => 'Shortcode')
	 );
 }
 

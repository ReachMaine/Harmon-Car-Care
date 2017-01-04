<?php /* year make model trim selector */

	// If this file is called directly, abort.
	if (!defined('WPINC')) { die; }



global $ymmt_object;
/***** using dynamic select plugin ************/

/* function cf7_ymmt_year_funct($choices, $args=array()) {
	// return an array of label-> value pairs
	$choices = array(
		'-- year. --' => '0',
		
		);
	return $choices;
} */

add_filter('cf7_ymmt_make', 'cf7_ymmt_make_handler');
add_filter('cf7_ymmt_model', 'cf7_ymmt_model_handler');
add_filter('cf7_ymmt_year', 'cf7_ymmt_year_handler');
add_filter('cf7_ymmt_trim', 'cf7_ymmt_trim_handler');
add_filter('cf7_ymmt_tiresize', 'cf7_ymmt_tiresize_handler');

function cf7_ymmt_make_handler() {
	$curl = curl_init();
	if ($curl){
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$query = array(
		  "fmt" => "json",
		  "api_key" => "sdyebqcke3zwkdfcqjpx38pz"
		);
		curl_setopt($curl, CURLOPT_URL,
		  "https://api.edmunds.com/api/vehicle/v2/makes" . "?" . http_build_query($query)
		);
		$curl_result = curl_exec($curl);
		$ymmt_object = json_decode($curl_result);
		curl_close($curl);
		//echo'<pre>';var_dump($ymmt_object);echo '</pre>';
		$choices = array("-- select make --" => '0');
		foreach ($ymmt_object->makes as $key => $value) {
			$veh_make = $value->name;
			$veh_make_id = $value->id;
			$veh_make_nidename = $value->niceName;
			$choices[$veh_make] = $veh_make_nidename;
		}
		//echo '<script><![CDATA['.$curl_result.']]></script>';
		echo '<div id="ymmt-all" class="hidden" style="display: none; visibility: hidden;">'.$curl_result."</div>";
		return $choices;
	} else {
		//echo "No curl handle - make";
	}
}
function cf7_ymmt_model_handler() {

	$choices = array(
		'-- model --' => '0',
		);
	return $choices;
}

function cf7_ymmt_year_handler() {
	$choices = array(
		'-- year --' => '0',
		);
	return $choices;
}
function cf7_ymmt_trim_handler() {

	$choices = array(
		'-- trim level --' => '0',
		);
	return $choices;
}
/* ---------------- */


function cf7_ymmt_tiresize_handler() {
	$choices = array (
			'-- tires --' => '0',
		);
	return $choices;
}

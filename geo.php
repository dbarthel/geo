<?php

$zipcode = $_REQUEST['zipcode'];
//$zipcode =urlencode("seattle, wa");
$latitude = "0";
$longitude ="0";
if($zipcode != "") {
    $geo = 'http://maps.google.com/maps/api/geocode/xml?address='.$zipcode.'&sensor=false';
	$xml = simplexml_load_file($geo);
	$latitude =(string)$xml->result->geometry->location->lat;
    $longitude =(string)$xml->result->geometry->location->lng;
    echo $latitude.",".$longitude."<br>";
}
else {
    $latitude = $_REQUEST['latitude'];
    $longitude = $_REQUEST['longitude'];
    echo $latitude.",".$longitude."<br>";
    //$geo = 'http://maps.google.com/maps/api/geocode/xml?latlng='.$latitude .',' . $longitude.'&sensor=true';
}
$geo = 'http://maps.google.com/maps/api/geocode/xml?latlng='.$latitude .',' . $longitude.'&sensor=true';
echo $geo."<br>";

$xml = simplexml_load_file($geo);
foreach($xml->result->address_component as $component){
   	if($component->type=='street_address'){
		$geodata['precise_address'] = (string)$component->long_name;
	}
	if($component->type=='natural_feature'){
		$geodata['natural_feature'] = (string)$component->long_name;
	}
	if($component->type=='airport'){
		$geodata['airport'] = (string)$component->long_name;
	}
	if($component->type=='park'){
		$geodata['park'] = (string)$component->long_name;
	}
	if($component->type=='point_of_interest'){
		$geodata['point_of_interest'] = (string)$component->long_name;
	}
	if($component->type=='premise'){
		$geodata['named_location'] = (string)$component->long_name;
	}
	if($component->type=='street_number'){
		$geodata['house_number'] = (string)$component->long_name;
	}
	if($component->type=='route'){
		$geodata['street'] = (string)$component->long_name;
	}
	if($component->type=='locality'){
		$geodata['town_city'] = (string)$component->long_name;
	}
	if($component->type=='administrative_area_level_3'){
		$geodata['district_region'] =(string) $component->long_name;
	}
	if($component->type=='neighborhood'){
		$geodata['neighborhood'] = (string)$component->long_name;
	}
	if($component->type=='colloquial_area'){
		$geodata['locally_known_as'] = (string)$component->long_name;
	}
	if($component->type=='administrative_area_level_2'){
		$geodata['county'] = (string)$component->long_name;
	}
	if($component->type=='administrative_area_level_1'){
		$geodata['state'] = (string)$component->long_name;
	}
	if($component->type=='postal_code'){
		$geodata['postcode'] = (string)$component->long_name;
	}
	if($component->type=='country'){
		$geodata['country'] = (string)$component->long_name;
	}
}

//list($lat,$long) = explode(',',htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))));
$geodata['latitude'] = $latitude;
$geodata['longitude'] = $longitude;
$geodata['formatted_address'] = (string)$xml->result->formatted_address;
$geodata['accuracy'] = htmlentities(htmlspecialchars(strip_tags($_GET['accuracy'])));
$geodata['altitude'] = htmlentities(htmlspecialchars(strip_tags($_GET['altitude'])));
$geodata['altitude_accuracy'] = htmlentities(htmlspecialchars(strip_tags($_GET['altitude_accuracy'])));
$geodata['directional_heading'] = htmlentities(htmlspecialchars(strip_tags($_GET['heading'])));
$geodata['speed'] = htmlentities(htmlspecialchars(strip_tags($_GET['speed'])));
$geodata['google_api_src'] = $geo;
echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$latitude.','.$longitude.'&markers='.$latitude.','.$longitude.'&zoom=14&size=150x150&maptype=roadmap&sensor=true" width="150" height="150" alt="'.$geodata['formatted_address'].'" \/><br /><br />';
echo 'Latitude: '.$latitude.' Longitude: '.$longitude.'<br />';
foreach($geodata as $name => $value){
	echo ''.$name.': '.str_replace('&','&amp;',$value).'<br />';
}
//var_dump($geodata);
?>
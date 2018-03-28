<?php
# Copyright (C) 2017-2018 @Thibautg16 and Connected Object pour eedomus
# This file is part of NetatmoWeatherAppEedomus <https://github.com/Thibautg16/NetatmoWeatherAppEedomus>.
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with This program. If not, see <http://www.gnu.org/licenses/>.

function sdk_deg_to_dir($deg)
{
  $val = floor(($deg / 22.5) + 0.5);
  $arr = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");
  return $arr[$val % 16];
}
$api_url = 'https://api.netatmo.com';
$code = getArg('oauth_code');
$prev_code = loadVariable('code');
$CACHE_DURATION = 5; // minutes
$device_id = $_GET['device_id'];
$last_xml_success = loadVariable('last_xml_success'.$device_id);

function sdk_netatmo_check_devices($json_devices){
	if ($json_devices['error']['code'] == 2 /*invalid access token*/)
	{
		// on force l'expiration pour la fois suivante
		saveVariable('expire_time', 0);
	}
	if ($json_devices['error'] != '')
	{
		die("Erreur lors de la lecture des devices: <b>".$json_devices['error']['message'].'</b>');
	}
}

function sdk_netatmo_devices_html($json_devices){
	$html='';
	
	if(sizeof($json_devices) > 0){
		$html .= '<br/>';
		$html .= '<br/>';
		$html .= 'Voici la liste de vos stations météo Netatmo :';
		$html .= '<br/>';
		$html .= '<ul>';
	}

	for ($i = 0; $i < sizeof($json_devices['body']['devices']); $i++){
		$html .= '<li><b>'.$json_devices['body']['devices'][$i]['station_name'].'</b>: <input onclick="this.select();" type="text" size="40" readonly="readonly" value="'.$json_devices['body']['devices'][$i]['_id'].'" /></li>';
	}

	if(sizeof($json_devices) > 0){
		$html .= '</ul>';
	}

	return $html;
}

if ((time() - $last_xml_success) / 60 < $CACHE_DURATION)
{
	sdk_header('text/xml');
	$cached_xml = loadVariable('cached_xml'.$device_id);
	echo $cached_xml;
	die();
}
if (strlen($prev_code) > 1 && $code == $prev_code)
{
  // on reprend le dernier refresh_token seulement s'il correspond au même code
	$refresh_token = loadVariable('refresh_token');
	$expire_time = loadVariable('expire_time');
	// s'il n'a pas expiré, on peut reprendre l'access_token
  if (time() < $expire_time)
  {
    $access_token = loadVariable('access_token');
  }
}
// on a déjà un token d'accés non expiré pour le code demandé
if ($access_token == '')
{
  if (strlen($refresh_token) > 1)
  {
    // on peut juste rafraichir le token
    $grant_type = 'refresh_token';
    $postdata = 'grant_type='.$grant_type.'&refresh_token='.$refresh_token;
  }
  else
  {
    // 1ère utilisation aprés obtention du code
    $grant_type = 'authorization_code';
    $redirect_uri = 'https://secure.eedomus.com/sdk/plugins/netatmo/callback.php';
    $scope = 'read_station';
    $postdata = 'grant_type='.$grant_type.'&code='.$code.'&redirect_uri='.$redirect_uri.'&scope='.$scope;
  }
  $response = httpQuery($api_url.'/oauth2/token', 'POST', $postdata, 'netatmo_oauth');
  $params = sdk_json_decode($response);
  if ($params['error'] != '')
  {
    die("Erreur lors de l'authentification: <b>".$params['error'].'</b> (grant_type = '.$grant_type.')');
  }
  // on sauvegarde l'access_token et le refresh_token pour les authentifications suivantes
  if (isset($params['refresh_token']))
  {
    $access_token = $params['access_token'];
    saveVariable('access_token', $access_token);
    saveVariable('refresh_token', $params['refresh_token']);
    saveVariable('expire_time', time()+$params['expires_in']);
    saveVariable('code', $code);
  }
  else if ($access_token == '')
  {
    die("Erreur lors de l'authentification");
  }
}
if ($_GET['mode'] == 'verify'){
	$url_devices = $api_url.'/api/getstationsdata?access_token='.$access_token;
	$result_devices = httpQuery($url_devices);
	$json_devices = sdk_json_decode($result_devices);
	sdk_netatmo_check_devices($json_devices);
	$devices_html=sdk_netatmo_devices_html($json_devices);

	?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>eedomus</title>
  <style type="text/css">
  
  body,td,th {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
  }
  </style>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  </head><?
  echo '<br/>';
	echo "Votre code d'authentification Netatmo est : ".'<input onclick="this.select();" type="text" size="40" readonly="readonly" value="'.$code.'" />';
	echo $devices_html;
	echo "<p>Vous pouvez copier/coller dans le code d'authentification Netatmo et l'id de votre station dans le paramétrage de votre périphérique eedomus.";
	echo '<br/>';
	echo "Vous pouvez ensuite fermer cette page.</p>";
	die();
}

// l'utilisateur indique un device_id (si plusieurs station sur le même compte)
if($device_id != ""){
	$url_devices = $api_url.'/api/getstationsdata?device_id='.$device_id.'&access_token='.$access_token;
}
else{
	$url_devices = $api_url.'/api/getstationsdata?access_token='.$access_token;
}

$result_devices = httpQuery($url_devices);
// gestion offline pour debug
//saveVariable('result_devices', $result_devices); die();
//$result_devices = loadVariable('result_devices');
$json_devices = sdk_json_decode($result_devices);
sdk_netatmo_check_devices($json_devices);
$data_store = array();
// Stations
$e = 0;
for ($i = 0; $i < sizeof($json_devices['body']['devices']); $i++)
{
	$extension_device[$i]['id'] = $json_devices['body']['devices'][$i]['_id'];
	$extension_device[$i]['name'] = $json_devices['body']['devices'][$i]['station_name'];
	$extension_device[$i]['wifi_status'] = $json_devices['body']['devices'][$i]['wifi_status'];
	$data_store[$json_devices['body']['devices'][$i]['_id']] = $json_devices['body']['devices'][$i]['dashboard_data'];
	
	// Modules d'extension
	for ($k = 0; $k < sizeof($json_devices['body']['devices'][$i]['modules']); $k++)
  {
    $extension_module[$e]['id'] = $json_devices['body']['devices'][$i]['modules'][$k]['_id'];
    $extension_module[$e]['name'] = $json_devices['body']['devices'][$i]['modules'][$k]['module_name'];
    $extension_module[$e]['battery_percent'] = $json_devices['body']['devices'][$i]['modules'][$k]['battery_percent'];
    $extension_module[$e]['rf_status'] = $json_devices['body']['devices'][$i]['modules'][$k]['rf_status'];
		$data_store[$json_devices['body']['devices'][$i]['modules'][$k]['_id']] = $json_devices['body']['devices'][$i]['modules'][$k]['dashboard_data'];
    $e++;
  }
}
function sdk_netatmo_xml($prefix, $data_store, $extension_module)
{
  $ret = '';
  for ($i = 0; $i < sizeof($extension_module); $i++)
  {
    // pour des raisons de rétro-compatibilité les 2 tags internal et external sont conservés
    if ($i == 0 && $prefix == 'device') { $xml_tag = 'internal'; }
    else if ($i == 0 && $prefix == 'extension') { $xml_tag = 'external'; }
    else { $xml_tag = $prefix.'_'.$i; }
    
    $id = $extension_module[$i]['id'];
    
		$ret .= '<'.$xml_tag.'>';
		
		
		// attention aux "&" qui doivent être convertis
		$ret .= '<name>'.htmlspecialchars($extension_module[$i]['name']).'</name>';
		if (isset($extension_module[$i]['battery_percent'])){
			$ret .= '<battery_percent>'.$extension_module[$i]['battery_percent'].'</battery_percent>';
		}
		if (isset($extension_module[$i]['wifi_status'])){
			if ($extension_module[$i]['wifi_status'] <= 66){
				$wifi_status=0;
			}
			else if($extension_module[$i]['wifi_status'] > 66 && $extension_module[$i]['wifi_status'] <= 76){
				$wifi_status=1;
			}
		  else if($extension_module[$i]['wifi_status'] > 76){
				$wifi_status=2;
			}
			$ret .= '<wifi_status>'.$wifi_status.'</wifi_status>';
		}
		if (isset($extension_module[$i]['rf_status'])){
			if ($extension_module[$i]['rf_status'] <= 70){
				$rf_status=0;
			}
			else if($extension_module[$i]['rf_status'] > 70 && $extension_module[$i]['rf_status'] <= 80){
				$rf_status=1;
			}
		  else if($extension_module[$i]['rf_status'] > 80){
				$rf_status=2;
			}
			$ret .= '<rf_status>'.$rf_status.'</rf_status>';
		}
		if (isset($data_store[$id]['Temperature']))
		{
			$ret .= '<temperature>'.$data_store[$id]['Temperature'].'</temperature>';
		}
		if (isset($data_store[$id]['CO2']))
		{
			$ret .= '<co2>'.$data_store[$id]['CO2'].'</co2>';
		}
		if (isset($data_store[$id]['Humidity']))
		{
			$ret .= '<humidity>'.$data_store[$id]['Humidity'].'</humidity>';
		}
		if (isset($data_store[$id]['temp_trend']))
		{
			$ret .= '<temp_trend>'.$data_store[$id]['temp_trend'].'</temp_trend>';
		}
		if (isset($data_store[$id]['pressure_trend']))
		{
			$ret .= '<pressure_trend>'.$data_store[$id]['pressure_trend'].'</pressure_trend>';
		}				
		if (isset($data_store[$id]['Rain']))
		{
			$ret .= '<rain>'.$data_store[$id]['Rain'].'</rain>';
		}
		if (isset($data_store[$id]['sum_rain_1']))
		{
			$ret .= '<rain1>'.$data_store[$id]['sum_rain_1'].'</rain1>';
		}
		if (isset($data_store[$id]['sum_rain_24']))
		{
			$ret .= '<rain24>'.$data_store[$id]['sum_rain_24'].'</rain24>';
		}
		if (isset($data_store[$id]['AbsolutePressure']))
		{
			$ret .= '<pressure>'.$data_store[$id]['AbsolutePressure'].'</pressure>';
		}
		if (isset($data_store[$id]['Noise']))
		{
			$ret .= '<soundlevel>'.$data_store[$id]['Noise'].'</soundlevel>';
		}
		
		if (isset($data_store[$id]['WindAngle']))
		{
			$ret .= '<WindAngle>'.sdk_deg_to_dir($data_store[$id]['WindAngle']).'</WindAngle>';
		}
		if (isset($data_store[$id]['WindStrength']))
		{
			$ret .= '<WindStrength>'.$data_store[$id]['WindStrength'].'</WindStrength>';
		}
		if (isset($data_store[$id]['GustAngle']))
		{
			$ret .= '<GustAngle>'.sdk_deg_to_dir($data_store[$id]['GustAngle']).'</GustAngle>';
		}
		if (isset($data_store[$id]['GustStrength']))
		{
			$ret .= '<GustStrength>'.$data_store[$id]['GustStrength'].'</GustStrength>';
		}
		$ret .= '</'.$xml_tag.'>';
	}
	return $ret;
}
// permet d'avoir une mise en forme plus lisible dans un browser
sdk_header('text/xml');
// XML de sortie
$xml_content = sdk_netatmo_xml('device', $data_store, $extension_device);
$xml_content .= sdk_netatmo_xml('extension', $data_store, $extension_module);
$cached_xml = '<?xml version="1.0" encoding="utf8" ?>';
$cached_xml .= '<netatmo>';
$cached_xml .= '<cached>0</cached>';
$cached_xml .= $xml_content;
$cached_xml .= '</netatmo>';
echo $cached_xml;
$cached_xml = str_replace('<cached>0</cached>', '<cached>1</cached>', $cached_xml);
if ($xml_content != '') // non vide
{
	saveVariable('cached_xml'.$device_id, $cached_xml);
	saveVariable('last_xml_success'.$device_id, time());
}
?>

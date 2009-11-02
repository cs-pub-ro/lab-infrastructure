<?php
/**
 * Script care raspunde la cereri rest de tipul
 * 	/get/name/MAC/
 * (c) Alex Eftimie 2009
 */
require ('conf.php');

$method = $_GET['method'];
$param1 = $_GET['param1'];

switch ($method) {
case 'name':
	if (!empty($machines[$param1]))
		echo $machines[$param1];
	else
		echo "Unknown";
	break;

case 'wall':
	if (file_exists('walls/'.$param1.'.jpg')) 
		echo "http://$conf[host]$conf[base]/walls/$param1.jpg";
	else
		echo $conf[defaultwall];
	break;

case 'custom':
	echo "http://$conf[host]$conf[base]/walls/custom.php?param1=";
	if (!empty($machines[$param1]))
		echo $machines[$param1];
	else 
		echo "Unknown";
	break;

case 'custom_by_name':
	echo "http://$conf[host]$conf[base]/walls/custom.php?param1=".$param1;
	break;

case 'defaultwall':
	echo "$conf[defaultwall]";
	break;

case 'info':
	echo "Usage: /get/[method]/[param1]/[param2]/...<br/>";
	echo "Methods: <ul>
		<li>info<br/>
		<ul><li>returns: this info</li></ul>
		</li>
		<li>name<ul><li>param1 MAC</li>
		<li>returns: name</li></ul>
		Ex: <a href=$conf[base]/get/name/00:30:05:bb:95:d5/>/get/name/00:30:05:bb:95:d5/</a> returns: Thompson</li>
		<li>defaultwall
			<ul>
			<li>returns: url</li>
			</li>
			</ul>
		<li>wall<ul>
			<li>param1: MAC</li>
			<li>returns: url</li>
			</ul>
		Verifica daca exista wall/[MAC].jpg. Daca nu, returneaza defaultwall.
		</li>
		<li>custom<ul>
			<li>param1: MAC</li>
			<li>returns: url</li>
			</ul>
		Returneaza o imagine generata automat.
		</li>
		<li>custom_by_name<ul>
			<li>param1: hostname</li>
			<li>returns: url</li>
			</ul>
		Returneaza imaginea generata automat.
		</li>
		</ul>\n";
	break;
default:
	#header("HTTP/1.0 403 Bad request");
	#print_r($_GET); print_r($machines);
	header("Location: $conf[base]/get/info/");
}
die;


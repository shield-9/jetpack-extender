<?php
if(!isset($_GET["url"]))
	die("No URL Supplied!");

include(dirname(__FILE__).'/../../../wp-load.php');


$filepath = str_replace(plugin_dir_url(__FILE__), plugin_dir_path(__FILE__), $_GET["url"]);

if(strpos( $filepath, dirname(__FILE__) )===FALSE or !file_exists($filepath) or is_dir($filepath))
	die("Invalid URL Supplied!");
else
	echo "OK";
?>
<?php
#Print the top part of an html page and including commonly used files
if (!file_exists("../config.php")) {
  header('refresh: 0; url=../configuration');
  exit();
}
session_start();
include(dirname(__DIR__, 1) . "/config.php");
$GLOBALS["url1"] = $url1;
$GLOBALS["urlé"] = $url2;
include($url1 . "functions/alert.php");
include($url1 . "functions/save.php");
include($url1 . "functions/nav.php");
include($url1 . "functions/login_required.php");
include($url1 . "functions/auto_logout.php");
$connection = new mysqli($host, $username, $password, $dbname);
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="initial-scale=1, width=device-width">';
echo '<link href="' . $url2 . 'static/favicon.ico" rel="icon">';
echo '<title>' . $title . ' </title>';
echo '<link rel="stylesheet" href="' . $url2 . 'vendor/bootstrap/bootstrap.min.css">';
echo '<link rel="stylesheet" href="' . $url2 . 'vendor/bootstrap/bootstrap-icons.min.css">';
echo '<link rel="stylesheet" href="' . $url2 . 'styles.css">';
echo '</head>';
echo '<body>';
?>
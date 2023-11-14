<?php
$title = "Home";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(2);
?>
<h1 class="mt-6 text-center">Welcome to FunAcademy!</h1>
<h3 class="text-center">Discover the different types of stories on our website.</h3>
<br>
<img src="<?php echo $url2 ?>static/img.jpg" alt="Picture of a child holding a book." class="img-fluid">
<?php
include($url1 . "functions/bottom.php");
?>
<?php
$title = "Playing cartoon";
include(dirname(__DIR__, 1) . "/functions/top.php");login_required(1);
if (!isset($_GET["id"])) {
  header('refresh: 3; url=' . $url2 . 'video');
  return;
}
$connection = new mysqli($host, $username, $password, $dbname);
$q = $connection->query("SELECT media.file, title FROM media WHERE media_id = '{$_GET["id"]}'");
$r = $q->fetch_array();
if (!is_array($r)) {
  feedback("red", "Content not found!", "");
  return;
}
?>
<main class=" pt-2 justify-content-center mt-6 p-0">
  <h1 class="text-center mb-5">
    <?php
    echo $r["title"];
    ?>
  </h1>
  <center>
    <video src="<?php echo $url2 . 'video/file/' . $r["file"] . ".mp4" ?>" controls=""
      style="border: 6px solid; border-radius:20px; border-color: rgb(112, 44, 186); max-height:600px; max-width: 1000px;  height:30vw"></video>
  </center>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
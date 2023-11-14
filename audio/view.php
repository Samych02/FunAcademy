<?php
$title = "Playing Audiobook";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(1);
if (!isset($_GET["id"])) {
  header('refresh: 3; url=' . $url2 . 'video');
  return;
}
$q = $connection->query("SELECT media.file, title, thumbnail FROM media WHERE media_id = '{$_GET["id"]}'");
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
    <div style="width:fit-content">
      <center style="margin-top:-1px">
        <img src="<?php echo $url2 . "audio/thumbnail/" . $r["thumbnail"] . ".png" ?>" alt="Image de couverture"
          width="500px"
          style="max-height:360px;border-right:6px solid;border-left:6px solid;border-top: 6px solid; border-top-left-radius:20px; border-top-right-radius:20px;border-color: rgb(112, 44, 186);">
      </center>
      <center style="margin-bottom:-6px;">
        <audio src="<?php echo $url2 . 'audio/file/' . $r["file"] . ".mp3" ?>" controls=""
          style="width:500px;border-right:6px solid;border-left:6px solid;border-bottom: 6px solid; border-bottom-left-radius:20px; border-bottom-right-radius:20px;border-color: rgb(112, 44, 186);"></audio>
      </center>
    </div>
  </center>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
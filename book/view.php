<?php
$title = "Lecture du book";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(1);
if (!isset($_GET["id"])) {
  header('refresh: 3; url=' . $url2 . 'book');
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
<main class="pt-2 justify-content-center mt-6 p-0">
  <h1 class="text-center mb-5">
    <?php
    echo $r["title"];
    ?>
  </h1>
  <center>
    <iframe style="border: 6px solid; border-radius:20px; border-color: rgb(112, 44, 186);"
      src="<?php echo $url2 . 'vendor/pdf.js/web/viewer.html?file=' . $url2 . 'book/file/' . $r["file"] . '.pdf' ?>"
      title="webviewer" frameborder="0" width="500" height="600"></iframe>
  </center>

</main>
<?php
include($url1 . "functions/bottom.php");
?>
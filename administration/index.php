<?php
$title = "Manage content";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(0);
function table($id, $title, $type)
{
  switch ($type) {
    case '0':
      $type = "Video";
      break;
    case '1':
      $type = "Audio";
      break;
    case '2':
      $type = "Book";
      break;
  }
  echo '<tr>';
  echo '<td>' . $id . '</td>';
  echo '<td>' . $title . '</td>';
  echo '<td>' . $type . '</td>';
  echo '<td><form action="edit.php" method="POST"><button type="submit" style="background:none;border:none;" name="edit" value="' . $id . '"><i class="bi bi-pencil-square h5 text-primary"></i></button></form></td>';
  echo '<td><form method="POST" onsubmit="return confirm(' . "'Are you sure you want to delete this content?')" . '";><button type="submit" style="background:none;border:none;" name="delete" value="' . $id . '"><i class="bi bi-trash text-danger h5"></i></button></form></td>';
  echo '</tr>';
}
if (isset($_POST["delete"])) {
  $q0 = $connection->query("SELECT * FROM media WHERE media_id = '{$_POST["delete"]}';");
  $r0 = $q0->fetch_array();
  switch ($r0["type"]) {
    case '0':
      unlink($url1 . "video/file/" . $r0["file"] . ".mp4");
      if ($r0["thumbnail"] != "1970-01-01 00:00:01")
        unlink($url1 . "video/thumbnail/" . $r0["thumbnail"] . ".png");
      break;
    case '1':
      unlink($url1 . "audio/file/" . $r0["file"] . ".mp3");
      if ($r0["thumbnail"] != "1970-01-01 00:00:01")
        unlink($url1 . "audio/thumbnail/" . $r0["thumbnail"] . ".png");
      break;
    case '2':
      unlink($url1 . "book/file/" . $r0["file"] . ".pdf");
      if ($r0["thumbnail"] != "1970-01-01 00:00:01")
        unlink($url1 . "book/thumbnail/" . $r0["thumbnail"] . ".png");
      break;
  }
  $q1 = $connection->query("DELETE FROM media WHERE media.media_id = '{$_POST["delete"]}';");
  $q2 = $connection->query("DELETE FROM favorite WHERE favorite.media_id = '{$_POST["delete"]}';");
  if ($q1 and $q2) {
    feedback("green", "Content deleted successfully!", "");
  }
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="text-center mb-5">Manage content</h1>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th class="col-1">id</th>
            <th>Titre</th>
            <th class="col-3">Type</th>
            <th class="col-1">Edite</th>
            <th class="col-1">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $connection = new mysqli($host, $username, $password, $dbname);
          $q3 = $connection->query("SELECT media.media_id, media.type, media.title FROM media ORDER BY media.type;");
          while ($r3 = $q3->fetch_array()) {
            table($r3["media_id"], $r3["title"], $r3["type"]);
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
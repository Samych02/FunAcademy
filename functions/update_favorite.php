<?php
#Update favorite list when pressing the favorite button
if (isset($_POST["submit"])) {
  if ($_POST["submit"] > 0) {
    $q1 = $connection->query("INSERT INTO favorite (user_id, media_id) VALUES ('{$_SESSION["user_id"]}', '{$_POST["submit"]}');");
    if ($q1) {
      $q2 = $connection->query("SELECT favorite.media_id AS media_id FROM favorite WHERE favorite.user_id = '{$_SESSION["user_id"]}';");
      $flist = array();
      while ($r2 = $q2->fetch_array()) {
        $flist[] = $r2["media_id"];
      }
      $_SESSION["flist"] = $flist;
      feedback("green", "Successfully added to favorites!", "");
    }
  } else {
    $_POST['submit'] *= -1;
    $q1 = $connection->query("DELETE FROM favorite WHERE user_id = '{$_SESSION['user_id']}' AND media_id = '{$_POST['submit']}'; ");
    if ($q1) {
      $q2 = $connection->query("SELECT favorite.media_id AS media_id FROM favorite WHERE favorite.user_id = '{$_SESSION["user_id"]}';");
      $flist = array();
      while ($r2 = $q2->fetch_array()) {
        $flist[] = $r2["media_id"];
      }
      $_SESSION["flist"] = $flist;
      feedback("green", "Successfully removed from favorites!", "");
    }
  }
}
?>
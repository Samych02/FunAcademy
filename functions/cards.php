<?php
function card1($file, $thumbnail, $title, $description, $fid, $media_type)
{
  switch ($media_type) {
    case '0':
      $tdir = "video/thumbnail/";
      $fdir = "video/view.php?id=" . abs($fid);
      break;
    case '1':
      $tdir = "audio/thumbnail/";
      $fdir = "audio/view.php?id=" . abs($fid);
      break;
    case '2':
      $tdir = "book/thumbnail/";
      $fdir = "book/view.php?id=" . abs($fid);
      break;
  }
  echo '<div class="row justify-content-center gutters-md">';
  echo '<div class="card mb-3 ps-0 me-2 cardd">';
  echo '<img src="' . $GLOBALS["url2"] . $tdir . $thumbnail . '.png" class="card-img-top " alt="Image de couverture">';
  echo '<div class="card-body" style="position: relative;">';
  echo '<h5 class="card-title">' . $title . "</h5>";
  echo '<p class="card-text mb-5">' . $description . "</p>";
  echo '<form method="post"><button type="submit" class="btn fav" name="submit" value="' . $fid . '">' . (($fid > 0) ? "Add to favorites" : "Remove from favorites") . '</button></form>';
  echo '</div>';
  echo '<a href="' . $GLOBALS["url2"] . $fdir . '" class="stretched-link"></a>';
  echo '</div>';
}
function card2($file, $thumbnail, $title, $description, $fid, $media_type)
{
  switch ($media_type) {
    case '0':
      $tdir = "video/thumbnail/";
      $fdir = "video/view.php?id=" . abs($fid);
      break;
    case '1':
      $tdir = "audio/thumbnail/";
      $fdir = "audio/view.php?id=" . abs($fid);
      break;
    case '2':
      $tdir = "book/thumbnail/";
      $fdir = "book/view.php?id=" . abs($fid);
      break;
  }
  echo '<div class="card mb-3 ps-0 ms-2 cardd">';
  echo '<img src="' . $GLOBALS["url2"] . $tdir . $thumbnail . '.png" class="card-img-top " alt="Image de couverture">';
  echo '<div class="card-body" style="position: relative;">';
  echo '<h5 class="card-title">' . $title . "</h5>";
  echo '<p class="card-text mb-5">' . $description . "</p>";
  echo '<form method="post"><button type="submit" class="btn fav" name="submit" value="' . $fid . '">' . (($fid > 0) ? "Add to favorites" : "Remove from favorites") . '</button></form>';
  echo '</div>';
  echo '<a href=' . $GLOBALS["url2"] . $fdir . '" class="stretched-link"></a>';
  echo '</div></div>';
}
function card3()
{
  echo '<div class="card mb-3 ps-0 ms-2 cardd empty">';
  echo '<img src="" class="card-img-top " alt="">';
  echo '<div class="card-body" style="position: relative;">';
  echo '<h5 class="card-title"></h5>';
  echo '<p class="card-text mb-5"></p>';
  echo '</div></div></div>';
}
function list_card($media_type, $query, $connection)
{
  if ($query == "all") {
    $q1 = $connection->query("SELECT * from media WHERE type = '{$media_type}';");
  } elseif ($query == "fav") {
    $q1 = $connection->query("SELECT * FROM media WHERE media.media_id IN 
    (SELECT favorite.media_id AS media_id FROM favorite WHERE favorite.user_id = '{$_SESSION["user_id"]}') 
    AND media.type = '{$media_type}'");
  }
  $rcount = $q1->num_rows;
  if ($rcount == 0) {
    echo ('<h1 class="text-center mb-5">No content of this type at the moment.</h1>');
  } elseif ($rcount == 1) {
    $r1 = $q1->fetch_array();
    card1($r1["file"], $r1["thumbnail"], $r1["title"], $r1["description"], ((in_array($r1["media_id"], $_SESSION["flist"]) == false) ? $r1["media_id"] : -1 * $r1["media_id"]), $media_type);
    card3();
  } else {

    for ($i = 0; $i < 2 * intdiv($rcount, 2); $i++) {
      if ($i % 2 == 0) {
        $r1 = $q1->fetch_array();
        card1($r1["file"], $r1["thumbnail"], $r1["title"], $r1["description"], ((in_array($r1["media_id"], $_SESSION["flist"]) == false) ? $r1["media_id"] : -1 * $r1["media_id"]), $media_type);
      } else {
        $r1 = $q1->fetch_array();
        card2($r1["file"], $r1["thumbnail"], $r1["title"], $r1["description"], ((in_array($r1["media_id"], $_SESSION["flist"]) == false) ? $r1["media_id"] : -1 * $r1["media_id"]), $media_type);
      }
    }
    if ($rcount % 2 != 0 and $rcount > 1) {
      $r1 = $q1->fetch_array();
      card1($r1["file"], $r1["thumbnail"], $r1["title"], $r1["description"], ((in_array($r1["media_id"], $_SESSION["flist"]) == false) ? $r1["media_id"] : -1 * $r1["media_id"]), $media_type);
      card3();
    }
  }
}
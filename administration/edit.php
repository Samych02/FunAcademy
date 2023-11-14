<?php
$title = "Modification du contenu";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(0);
$q1 = $connection->query("SELECT * FROM media WHERE media_id = '{$_POST["edit"]}';");
$r1 = $q1->fetch_array();
switch ($r1["type"]) {
  case '0':
    $type = "Video";
    $lab = "Accepted format: MP4 | Max size: 9.5MO";
    break;
  case '1':
    $type = "Audio";
    $lab = "Accepted format: MP3 | Max size: 9.5MO";
    break;
  case '2':
    $type = "book";
    $lab = "Accepted format: PDF | Max size: 9.5MO";
    break;
}
if (isset($_POST["submit"])) {
  $tflag = 0;
  if ($_FILES["thumbnail"]["name"] != "") {
    switch ($r1["type"]) {
      case '0':
        $tfile = $url1 . "video/thumbnail/" . $r1["file"] . ".png";
        break;
      case '1':
        $tfile = $url1 . "audio/thumbnail/" . $r1["file"] . ".png";
        break;
      case '2':
        $tfile = $url1 . "book/thumbnail/" . $r1["file"] . ".png";
        break;
    }
    if (!strstr($_FILES["thumbnail"]["type"], "image/jpeg") and !strstr($_FILES["thumbnail"]["type"], "image/png")) {
      $tflag = 1;
      feedback("red", "The thumbnail file is not valid!", "");
    } else {
      if ($_FILES["thumbnail"]["size"] > 5242880) {
        $tflag = 1;
        feedback("red", "The thumbnail size should not exceed 5MB", "");
      }
    }
    if ($r1["thumbnail"] == "1970-01-01 00:00:01" and $tflag == 0) {
      $tq = $connection->query("UPDATE media SET thumbnail = '{$r1["file"]}' 
      WHERE media_id = '{$_POST["edit"]}' ");
    }
  }
  $fflag = 0;
  if ($_FILES["file"]["name"] != "") {
    switch ($r1["type"]) {
      case '0':
        $ffile = $url1 . "video/file/" . $r1["file"] . ".mp4";
        if (!strstr($_FILES["file"]["type"], "video/mp4")) {
          $fflag = 1;
          feedback("red", "The video file is not valid!", "");
        }
        break;
      case '1':
        $ffile = $url1 . "audio/file/" . $r1["file"] . ".mp3";
        if (!strstr($_FILES["file"]["type"], "audio/")) {
          $fflag = 1;
          feedback("red", "The audio file is not valid!", "");
        }
        break;
      case '2':
        $ffile = $url1 . "book/file/" . $r1["file"] . ".pdf";
        if (!strstr($_FILES["file"]["type"], "application/pdf")) {
          $fflag = 1;
          feedback("red", "he book file is not valid!", "");
        }
        break;
    }
    if ($fflag == 0) {
      if ($_FILES["file"]["size"] > 9961472) {
        $fflag = 1;
        feedback("red", "The file size should not exceed 9.5MB!", "");
      }
    }
  }
  if ($fflag + $tflag == 0) {
    $title = $connection->real_escape_string($_POST["title"]);
    $description = $connection->real_escape_string($_POST["description"]);
    $q2 = $connection->query("UPDATE media SET title = '{$title}', description = '{$description}'
    WHERE media_id = '{$_POST["edit"]}' ");
    if ($q2) {
      if ($_FILES["file"]["name"] != "") {
        move_uploaded_file($_FILES["file"]["tmp_name"], $ffile);
      }
      if ($_FILES["thumbnail"]["name"] != "") {
        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $tfile);
      }
      $_POST["title"] = "";
      $_POST["type"] = "";
      $_POST["description"] = "";
      feedback("green", "Content edited successfully!", "");
    }
  }
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="mb-3">Edit content</h1>
  <form method="post" class="was-validated" enctype="multipart/form-data">
    <div class="row mb-5 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <select class="form-select py-0" name="type" id="slct">
          <option disabled selected>
            <?php
            echo $type;
            ?>
          </option>
        </select>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="text" class="form-control" name="title" placeholder="" required="required"
          value="<?php echo $r1["title"] ?>" maxlength="40" id="title">
        <label class="lab" for="title">Titre</label>
        <div id="the-count1" class="mt-1"><span id="current1">0 </span><span id="maximum1">/ 40</span></div>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <textarea autocomplete="off" type="text" class="form-control" name="description" placeholder=""
          required="required" maxlength="450" id="description"><?php echo $r1["description"] ?></textarea>
        <label class="lab" for="description">Description</label>
        <div id="the-count2" class="mt-1"><span id="current2">0 </span><span id="maximum2">/ 450</span></div>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form col-12 col-sm-8 col-md-6 col-xl-4">
        <label for="formFile" class="form-label">Modifer l'image de couverture</label>
        <input class="form-control" type="file" name="thumbnail">
        <small class="text-danger text-left mb-4">Accepted file format: JPEG and PNG | Max size: 5MO</small><br>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form col-12 col-sm-8 col-md-6 col-xl-4">
        <label for="formFile" class="form-label">Edit file</label>
        <input class="form-control" type="file" name="file">
        <small class="text-danger text-left mb-4">
          <?php
          echo $lab ?>
        </small><br>
      </div>
    </div>
    <input type="hidden" name="edit" value="<?php echo $_POST["edit"] ?>">
    <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
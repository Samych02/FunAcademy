<?php
$title = "Adding content";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(0);
if (isset($_POST["submit"])) {
  $tflag = 0;
  $date = date('Y-m-d H:i:s');
  $tname = "1970-01-01 00:00:01";
  if ($_FILES["thumbnail"]["name"] != "") {
    $tname = $date;
    switch ($_POST["type"]) {
      case '0':
        $tfile = $url1 . "video/thumbnail/" . $tname . ".png";
        break;
      case '1':
        $tfile = $url1 . "audio/thumbnail/" . $tname . ".png";
        break;
      case '2':
        $tfile = $url1 . "book/thumbnail/" . $tname . ".png";
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
  }
  $fflag = 0;
  switch ($_POST["type"]) {
    case '0':
      $ffile = $url1 . "video/file/" . $date . ".mp4";
      if (!strstr($_FILES["file"]["type"], "video/mp4")) {
        $fflag = 1;
        feedback("red", "The video file is not valid!", "");
      }
      break;
    case '1':
      $ffile = $url1 . "audio/file/" . $date . ".mp3";
      if (!strstr($_FILES["file"]["type"], "audio/")) {
        $fflag = 1;
        feedback("red", "The audio file is not valid!", "");
      }
      break;
    case '2':
      $ffile = $url1 . "book/file/" . $date . ".pdf";
      if (!strstr($_FILES["file"]["type"], "application/pdf")) {
        $fflag = 1;
        feedback("red", "The book file is not valid!", "");
      }
      break;
  }
  if ($fflag == 0) {
    if ($_FILES["file"]["size"] > 9961472) {
      $fflag = 1;
      feedback("red", "The file size should not exceed 9.5MB!", "");
    }
  }
  if ($fflag + $tflag == 0) {
    $title = $connection->real_escape_string($_POST["title"]);
    $description = $connection->real_escape_string($_POST["description"]);
    $q = $connection->query("INSERT INTO media (type, title, description, thumbnail, file)
    VALUES ('{$_POST["type"]}', '{$title}', '{$description}', '{$tname}', '{$date}')");
    if ($q) {
      move_uploaded_file($_FILES["file"]["tmp_name"], $ffile);
      if ($_FILES["thumbnail"]["name"] != "") {
        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $tfile);
      }
      $_POST["title"] = "";
      unset($_POST["type"]);
      $_POST["description"] = "";
      feedback("green", "Content added successfully!", "");
    }
  }
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="mb-3">Adding content</h1>
  <form method="post" class="was-validated" enctype="multipart/form-data">
    <div class="row mb-5 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <select class="form-select py-0" name="type" required id="slct">
          <option disabled value="" <?php if (!isset($_POST["type"]))
            echo 'selected'; ?>>Content type</option>
          <option value="0" <?php if (isset($_POST["type"]) and $_POST["type"] == 0)
            echo 'selected'; ?>>Cartoons
          </option>
          <option value="1" <?php if (isset($_POST["type"]) and $_POST["type"] == 1)
            echo 'selected'; ?>>Audiobook
          </option>
          <option value="2" <?php if (isset($_POST["type"]) and $_POST["type"] == 2)
            echo 'selected'; ?>>Books</option>
        </select>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="text" class="form-control" name="title" placeholder="" required="required"
          value="<?php save("title") ?>" maxlength="40" id="title">
        <label class="lab" for="title">Title</label>
        <div id="the-count1" class="mt-1"><span id="current1">0 </span><span id="maximum1">/ 40</span></div>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <textarea autocomplete="off" type="text" class="form-control" name="description" placeholder=""
          required="required" maxlength="450" id="description"><?php save("description") ?></textarea>
        <label class="lab" for="description">Description</label>
        <div id="the-count2" class="mt-1"><span id="current2">0 </span><span id="maximum2">/ 450</span></div>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form col-12 col-sm-8 col-md-6 col-xl-4">
        <label for="formFile" class="form-label">Choose a thumbnail (facultatif)</label>
        <input class="form-control" type="file" name="thumbnail">
        <small class="text-danger text-left mb-4">Accepted file format: JPEG and PNG | Max size: 5MO</small><br>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form col-12 col-sm-8 col-md-6 col-xl-4">
        <label for="formFile" class="form-label">Select a file</label>
        <input class="form-control" type="file" name="file" required>
        <small id="vreq" class="text-danger text-left mb-4"></small><br>
      </div>
    </div>
    <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
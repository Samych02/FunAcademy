<?php
$title = "Edit admin password";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(0);
if (!empty($_POST["submit"])) {
  include($url1 . "config.php");
  $l["host"] = $host;
  $l["username"] = $username;
  $l["password"] = $password;
  $l["dbname"] = $dbname;
  $l["url1"] = $url1;
  $l["url2"] = $url2;
  $file = fopen($url1 . "config.php", "w+");
  fwrite($file, "<?php\n\$host = \"" . $l["host"] . "\";\n");
  fwrite($file, "\$username = \"" . $l["username"] . "\";\n");
  fwrite($file, "\$password = \"" . $l["password"] . "\";\n");
  fwrite($file, "\$dbname = \"" . $l["dbname"] . "\";\n");
  fwrite($file, "\$url1 = \"" . $l["url1"] . "\";\n");
  fwrite($file, "\$url2 = \"" . $l["url2"] . "\";\n");
  fwrite($file, "\$apassword = \"" . $_POST["apassword"] . "\";\n?>");
  fclose($file);
  feedback("green", "The admin password was changed successfully!", "");
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <form method="post" class="was-validated ">
    <div class="row  justify-content-center mb-1 pt-5">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="password" class="form-control" name="apassword" placeholder="" required
          value="">
        <label class="lab" for="apassword">Enter a new password</label>
      </div>
    </div>
    <button type="submit" class="btn btn-lg mt-4" name="submit" value="submit">Submit</button>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
<?php
$title = "connection";
include(dirname(__DIR__, 1) . "/functions/top.php");if (isset($_SESSION["user_id"])) {
  navbar((($_SESSION["user_type"] == 0) ? 0 : 1));
  feedback("green", "You are already logged in!", "You will be redirected to homepage in 3s.");
  header('refresh: 3; url=' . $url2);
  return;
}
navbar(2);
if (!empty($_POST["submit"])) {
  $q1 = $connection->query("SELECT * FROM users WHERE username = '{$_POST["username"]}';");
  $r1 = $q1->fetch_array();
  if (is_array($r1) and password_verify($_POST["password"], $r1["password"])) {
    $_SESSION["user_id"] = $r1["user_id"];
    $_SESSION["user_type"] = $r1["user_type"];
    $_SESSION["username"] = $r1["username"];
    $_SESSION["name"] = $r1["name"];
    $_SESSION["surname"] = $r1["surname"];
    $_SESSION["email"] = $r1["email"];
    $_SESSION["bdate"] = $r1["bdate"];
    $_SESSION["is_connected"] = "";
    $_SESSION["loggeddate"] = time();
    $_SESSION["keepconnected"] = (isset($_POST["keepconnected"]) ? true : false);
    $q2 = $connection->query("SELECT favorite.media_id AS media_id FROM favorite WHERE favorite.user_id = '{$_SESSION["user_id"]}';");
    $flist = array();
    while ($r2 = $q2->fetch_array()) {
      $flist[] = $r2["media_id"];
    }
    $_SESSION["flist"] = $flist;
    feedback("green", "Connected successfully!", "You will be redirected to homepage in 3s.");
    header('refresh: 3; url=' . $url2);
  } else {
    feedback("red", "username and/or password incorrect", "");
    $_POST["username"] = "";
    $_POST["password"] = "";
  }
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="mb-3 ">Connection</h1>
  <form method="post" class="was-validated">
    <div class=" row justify-content-center mb-3">
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="text" class="form-control" name="username" placeholder="" required value="<?php save("username") ?>">
        <label class=" lab" for="username">Username</label>
      </div>
    </div>
    <div class=" row justify-content-center mb-3">
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="password" class="form-control" name="password" placeholder="" required value="<?php save("password") ?>">
        <label class="lab" for="password">Password</label>
      </div>
    </div>
    <div class=" row justify-content-center mb-4">
      <div class="form-check col-6 col-sm-4 col-md-3 col-xl-2">
        <input class="form-check-input ms-2" type="checkbox" name="keepconnected" value="" <?php echo ((isset($_POST["keepconnected"])) ? "checked" : "")?>>
        <label class="form-check-label" for="keepconnected">Stay connected</label>
      </div>
    </div>
    <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
    <a href="<?php echo $url2 ?>login/reset.php" class="btn btn-lg">
      Forgotten password?
    </a>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
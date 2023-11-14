<?php
$title = "Verification admin";
include(dirname(__DIR__, 1) . "/functions/top.php");navbar(2);
if (!empty($_POST["submit"])) {
  if (strcmp($_POST["apassword"], $apassword) == 0) {
    $_SESSION["user_type"] = 0;
    header('Refresh: 0; url=' . $url2 . 'register');
  } else {
    feedback("red", "Password incorrect", "");
  }
}
?>

<body>
  <main class="container-fluid  text-center justify-content-center mt-6">
    <form method="post" class="was-validated">
      <div class="row  justify-content-center mb-1 pt-5">
        <div class="form-floating col-4">
          <input autocomplete="off" type="password" class="form-control" name="apassword" placeholder="" required
            value="">
          <label class="lab" for="apassword">Administrator password</label>
        </div>
      </div>
      <div class="mb-3">
        <small class="text-danger text-left mb-4">Default password: admin</small><br>
      </div>
      <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
    </form>
  </main>
</body>
<?php
include($url1 . "functions/bottom.php");
?>
<?php
$title = "Mon compte";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(1);
include($url1 . "functions/verification.php");
if (isset($_POST["echange"])) {
  $q1 = $connection->query("SELECT password FROM users WHERE email = '{$_SESSION["email"]}';");
  $r1 = $q1->fetch_array();
  if (password_verify($_POST["password"], $r1["password"])) {
    if (emailVerif($_POST["email"])) {
      if (!does_exist("email", $_POST["email"])) {
        $q2 = $connection->query("UPDATE users SET email = '{$_POST["email"]}' WHERE email = '{$_SESSION["email"]}'; ");
        if ($q2) {
          $_SESSION["email"] = $_POST["email"];
          $_POST["email"] = "";
          $_POST["password"] = "";
          feedback("green", "Your email address has been updated successfully!", "");
        }
      } else {
        $_POST["email"] = "";
        feedback("red", "This email address is already used!", "");
      }
    } else {
      $_POST["email"] = "";
      feedback("red", "Invalid email address!", "");
    }
  } else {
    $_POST["password"] = "";
    feedback("red", "Wrong password!", "");
  }
}
if (isset($_POST["pchange"])) {
  $connection = new mysqli($host, $username, $password, $dbname);
  $q1 = $connection->query("SELECT password FROM users WHERE email = '{$_SESSION["email"]}';");
  $r1 = $q1->fetch_array();
  if (password_verify($_POST["opassword"], $r1["password"])) {
    if (passwordVerif($_POST["npassword"])) {
      $hashed_password = password_hash($_POST["npassword"], PASSWORD_DEFAULT);
      $q2 = $connection->query("UPDATE users SET password = '{$hashed_password}' WHERE email = '{$_SESSION["email"]}'; ");
      if ($q2) {
        $_POST["npassword"] = "";
        $_POST["opassword"] = "";
        feedback("green", "Your password was updated successfully!", "");
      }
    } else {
      $_POST["npassword"] = "";
      feedback("red", "Your new password doesn't meet the requirement!", "");
    }
  } else {
    $_POST["opassword"] = "";
    feedback("red", "Wrong old password!", "");
  }
}
?>
<main class="container-fluid pt-5 justify-content-center mt-6">
  <div class="row justify-content-center">
    <div class="col-md-12 col-xl-10">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Last name</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <?php echo strtoupper($_SESSION["name"]) ?>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">First name</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <?php echo ucfirst($_SESSION["surname"]) ?>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Birthdate</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <?php echo $_SESSION["bdate"] ?>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Email</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <?php echo $_SESSION["email"] ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row gutters-md justify-content-center">
    <div class="col-md-6 col-xl-5 mb-3">
      <div class="card w-100 h-100">
        <div class="card-body">
          <h5 class="text-center mb-4">Change your email address</h5>
          <form method="post" class="was-validated">
            <div class="form-floating mb-3">
              <input autocomplete="off" type="text" class="form-control" name="email" placeholder="" required
                value="<?php save("email") ?>">
              <label class="lab" for="name">New email address</label>
            </div>
            <div class="form-floating mb-4">
              <input autocomplete="off" type="password" class="form-control" name="password" placeholder="" required
                value="<?php save("password") ?>">
              <label class="lab" for="password">Your password</label>
            </div>
            <div class="text-center">
              <button type="submit text-center" class="btn btn-lg" name="echange" value="echange">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xl-5 mb-3">
      <div class="card w-100 h-100">
        <div class="card-body">
          <h5 class="text-center mb-4">Edit your password</h5>
          <form method="post" class="was-validated">
            <div class="form-floating mb-4">
              <input autocomplete="off" type="password" class="form-control" name="opassword" placeholder="" required
                value="<?php save("opassword") ?>">
              <label class="lab" for="password">Old password</label>
            </div>
            <div class="form-floating mb-4">
              <input autocomplete="off" type="password" class="form-control" name="npassword" placeholder="" required
                value="<?php save("npassword") ?>" data-bs-toggle="popover" data-bs-trigger="focus"
                data-bs-title="Password requirements:"
                data-bs-content="At least 8 characters including a capital letter, a number and a symbol">
              <label class="lab" for="password">New password</label>
            </div>
            <div class="text-center">
              <button type="submit text-center" class="btn btn-lg" name="pchange" value="pchange">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
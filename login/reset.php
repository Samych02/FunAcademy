<?php
$title = "Reset your password";
include(dirname(__DIR__, 1) . "/functions/top.php");
include($url1 . "functions/verification.php");
navbar(2);
$error["email"] = 0;
$error["squestion"] = 0;
$error["sanswer"] = 0;
$error["password"] = 0;
if (!empty($_POST["submit"])) {
  if (!emailVerif($_POST["email"])) {
    $_POST["email"] = "";
    $error["email"] = 1;
    feedback("red", "Invalid email address!", "");
  }
  if (!nameVerif($_POST["sanswer"])) {
    $_POST["sanswer"] = "";
    $error["sanswer"] = 1;
    feedback("red", "Invalid secret answer!", "");
  }
  if ($error["sanswer"] + $error["email"] == 0) {
    $connection = new mysqli($host, $username, $password, $dbname);
    $q1 = $connection->query("SELECT squestion, sanswer FROM users WHERE email = '{$_POST["email"]}';");
    $r1 = $q1->fetch_array();
    if (is_array($r1)) {
      if ($r1["squestion"] == $_POST["squestion"] and strcasecmp($r1["sanswer"], $_POST["sanswer"]) == 0) {
        if (!passwordVerif($_POST["password"])) {
          $_POST["password"] = "";
          feedback("red", "Le mot de passe ne respecte pas les exigences demandées!", "");
        } else {
          $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
          $q2 = $connection->query("UPDATE users SET password = '{$hashed_password}' WHERE email = '{$_POST["email"]}'; ");
          if ($q2) {
            feedback("green", "Password reseted successfully!", "You will be redirected to login page in 3s.");
            header('refresh: 3; url=' . $url2 . 'login');
          } else {
            feedback("red", "Unknown error!", "");
            header('Refresh: 0');
          }
        }
      } else {
        $_POST["sanswer"] = $_POST["password"] = "";
        unset($_POST["squestion"]);
        feedback("red", "The verification information are incorrect!", "");
      }
    } else {
      $_POST["email"] = $_POST["sanswer"] = $_POST["password"] = "";
      unset($_POST["squestion"]);
      feedback("red", "This account doesn't exist!", "");
    }
  }
}
unset($_SESSION);
session_unset();
session_destroy();
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="mb-3 ">Reset password</h1>
  <h3 class="mb-3">Identity check</h3>
  <form method="post" class="was-validated">
    <div class=" row justify-content-center mb-3">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-3">
        <input autocomplete="off" type="text" class="form-control" name="email" placeholder="" required
          value="<?php save("email") ?>">
        <label class=" lab" for="email">Email</label>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-3">
        <select class="form-select py-0" name="squestion" required>
          <option disabled value="" <?php if (!isset($_POST["squestion"]))
            echo 'selected="selected" '; ?>>Choose a
            secret question</option>
          <option value="0" <?php if (isset($_POST["squestion"]) and $_POST["squestion"] == 0)
            echo 'selected="selected"'; ?>>What city were you born in?</option>
          <option value="1" <?php if (isset($_POST["squestion"]) and $_POST["squestion"] == 1)
            echo 'selected="selected"'; ?>>What is your favorite color?</option>
        </select>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-3">
        <input autocomplete="off" type="text" class="form-control" name="sanswer" placeholder="" required
          value="<?php save("sanswer") ?>">
        <label class="lab" for="sanswer">Answer</label>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-3">
        <input autocomplete="off" type="password" class="form-control" name="password" placeholder="" required
          value="<?php save("password") ?>" data-bs-toggle="popover" data-bs-trigger="focus"
          data-bs-title="Password requirements:"
          data-bs-content="At least 8 characters including a capital letter, a number and a symbol">
        <label class="lab" for="password">New password</label>
      </div>
    </div>
    <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
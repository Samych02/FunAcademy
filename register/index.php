<?php
$title = "SAccount creation";
include(dirname(__DIR__, 1) . "/functions/top.php");include($url1 . "functions/verification.php");
navbar(2);
if (!isset($_SESSION["user_type"]) or isset($_GET["e"])) {
  session_unset();
  session_destroy();
  session_start();
  $_SESSION["user_type"] = 1;
}
if (!empty($_POST["submit"])) {
  $error["name"] = 0;
  $error["surname"] = 0;
  $error["email"] = 0;
  $error["username"] = 0;
  $error["password"] = 0;
  $error["sanswer"] = 0;
  if (!nameVerif($_POST["name"])) {
    $_POST["name"] = "";
    $error["name"] = 1;
    feedback("red", "Invalide last name!", "");
  }
  if (!nameVerif($_POST["surname"])) {
    $_POST["surname"] = "";
    $error["surname"] = 1;
    feedback("red", "invalid first name!", "");
  }
  if (!emailVerif($_POST["email"])) {
    $_POST["email"] = "";
    $error["email"] = 1;
    feedback("red", "Invalid email address!", "");
  }
  if (does_exist("email", $_POST["email"])) {
    $_POST["email"] = "";
    $error["email"] = 2;
    feedback("red", "Email address already in use!", "");
  }
  if (!usernameVerif($_POST["username"])) {
    $_POST["username"] = "";
    $error["username"] = 1;
    feedback("red", "Username can only contain letter, dash and underscore", "");
  }
  if (does_exist("username", $_POST["username"])) {
    $_POST["username"] = "";
    $error["username"] = 2;
    feedback("red", "Username already in use!", "");
  }
  if (!passwordVerif($_POST["password"])) {
    $_POST["password"] = "";
    $error["password"] = 1;
    feedback("red", "Password doesn't meet the requirements!", "");
  }
  if (!nameVerif($_POST["sanswer"])) {
    $_POST["sanswer"] = "";
    $error["sanswer"] = 1;
    feedback("red", "Invalid secret answer!", "");
  }
  if ($error["name"] + $error["surname"] + $error["email"] + $error["username"] + $error["password"] + $error["sanswer"] == 0) {
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $connection = new mysqli($host, $username, $password, $dbname);
    $q = $connection->query("INSERT INTO users (user_type, email, username, password, name, surname, bdate, squestion, sanswer)
    VALUES ('{$_SESSION["user_type"]}', '{$_POST["email"]}', '{$_POST["username"]}', '{$hashed_password}', '{$_POST["name"]}', '{$_POST["surname"]}',
     '{$_POST["bdate"]}', '{$_POST["squestion"]}', '{$_POST["sanswer"]}')");
    if ($q) {
      feedback("green", "Account created successfully!", "You will be redirected to login page in 3s.");
      header('refresh: 3; url=' . $url2 . 'login');
    }
  }
}
?>
<main class="container-fluid  text-center justify-content-center mt-6">
  <h1 class="mb-3 ">Account type 
    <?php
    echo ($_SESSION["user_type"] == 0 ? "administrator" : "kid");
    ?>
  </h1>
  <form method="post" class="was-validated">
    <h3 class="mb-2">Personal information:</h3>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="text" class="form-control" name="name" placeholder="" required
          value="<?php save("name") ?>">
        <label class="lab" for="name">Last name</label>
      </div>
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="text" class="form-control" name="surname" placeholder="" required
          value="<?php save("surname") ?>">
        <label class="lab" for="surname">First name</label>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="date" class="form-control" name="bdate" placeholder="" required
          value="<?php save("bdate") ?>" max="<?php echo date("Y-m-d") ?>">
        <label class="lab" for="bdate">Birthdate</label>
      </div>
    </div>
    <h3 class="mb-2">Login information:</h3>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="text" class="form-control" name="email" placeholder="" required
          value="<?php save("email") ?>">
        <label class="lab" for="email">Email</label>
      </div>
    </div>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="text" class="form-control" name="username" placeholder="" required
          value="<?php save("username") ?>">
        <label class="lab" for="username">Username</label>
      </div>
      <div class="form-floating col-6 col-sm-4 col-md-3 col-xl-2">
        <input autocomplete="off" type="password" class="form-control" name="password" placeholder="" required
          value="<?php save("password") ?>" data-bs-toggle="popover" data-bs-trigger="focus"
          data-bs-title="Password requirements:"
          data-bs-content="At least 8 characters including a capital letter, a number and a symbol">
        <label class="lab" for="password">Password</label>
      </div>
    </div>
    <h3 class="mb-2">Account recovery information:</h3>
    <div class="row mb-4 justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <select class="form-select py-0" name="squestion" required>
          <option disabled value="" <?php if (!isset($_POST["squestion"]))
            echo 'selected="selected" '; ?>>Choose a secret question</option>
          <option value="0" <?php if (isset($_POST["squestion"]) and $_POST["squestion"] == 0)
            echo 'selected="selected"'; ?>>What city were you born in?</option>
          <option value="1" <?php if (isset($_POST["squestion"]) and $_POST["squestion"] == 1)
            echo 'selected="selected"'; ?>>What is your favorite color?</option>
        </select>
      </div>
    </div>
    <div class="row  justify-content-center">
      <div class="form-floating col-12 col-sm-8 col-md-6 col-xl-4">
        <input autocomplete="off" type="text" class="form-control" name="sanswer" placeholder="" required
          value="<?php save("sanswer") ?>">
        <label class="lab" for="sanswer">Answer</label>
      </div>
    </div>
    <div class="mb-3">
      <small class="text-danger text-left mb-4">*All fields are required</small><br>
    </div>
    <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
  </form>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
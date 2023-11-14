<?php
$url1 = dirname(__DIR__, 1) . "/";
$a1 = explode("/", dirname(__DIR__, 1));
$a2 = explode("/", $_SERVER["DOCUMENT_ROOT"]);
if (end($a1) == end($a2)) {
  $url2 = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . "/";
} else {
  $url2 = strtolower(explode('/', $_SERVER['SERVER_PROTOCOL'])[0]) . "://" . $_SERVER["HTTP_HOST"] . "/" . end($a1) . "/";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1, width=device-width">
  <link href="<?php echo $url2; ?>static/favicon.ico" rel="icon">
  <title>Configuration</title>
  <link rel="stylesheet" href="<?php echo $url2 ?>vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $url2 ?>vendor/bootstrap/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo $url2 ?>styles.css">
</head>

<body>
  <?php
  include($url1 . "functions/save.php");
  include($url1 . "functions/alert.php");
  if (!empty($_POST["submit"])) {
    try {
      @$connection = new mysqli($_POST["host"], $_POST["username"], $_POST["password"], $_POST["dbname"]);
      $q1 = $connection->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA= '{$_POST["dbname"]}'");
      while ($r1 = $q1->fetch_array()) {
        $q2 = $connection->query("DROP TABLE {$r1[0]}");
      }
      $q1 = $connection->query("CREATE TABLE `users` (`user_id` INT(11) NOT NULL AUTO_INCREMENT , 
    `user_type` BOOLEAN NOT NULL DEFAULT TRUE , `email` VARCHAR(255) NOT NULL , `username` VARCHAR(255) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , `name` VARCHAR(255) NOT NULL , `surname` VARCHAR(255) NOT NULL , 
    `bdate` DATE NOT NULL , `squestion` BOOLEAN NOT NULL , `sanswer` VARCHAR(255) NOT NULL , 
    `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`user_id`)) ENGINE = InnoDB;");
      $q2 = $connection->query("CREATE TABLE `media` (`media_id` INT NOT NULL AUTO_INCREMENT , `type` TINYINT NOT NULL , 
    `title` VARCHAR(50) NOT NULL , `description` VARCHAR(500) NOT NULL , `thumbnail` TIMESTAMP NULL DEFAULT NULL , 
    `file` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`media_id`)) ENGINE = InnoDB; ");
      $q3 = $connection->query("CREATE TABLE `favorite` (`user_id` INT NOT NULL , `media_id` INT NOT NULL ) ENGINE = InnoDB; ");
      if ($q1 * $q2 * $q3 == true) {
        $connection->close();
        $file = fopen("../config.php", "w+");
        fwrite($file, "<?php\n\$host = \"" . $_POST["host"] . "\";\n");
        fwrite($file, "\$username = \"" . $_POST["username"] . "\";\n");
        fwrite($file, "\$password = \"" . $_POST["password"] . "\";\n");
        fwrite($file, "\$dbname = \"" . $_POST["dbname"] . "\";\n");
        fwrite($file, "\$url1 = \"" . $url1 . "\";\n");
        fwrite($file, "\$url2 = \"" . $url2 . "\";\n");
        fwrite($file, "\$apassword = \"" . "admin" . "\";\n?>");
        fclose($file);
        feedback("green", "Successfully connected to the database!", "You will be redirected to the signup page in 3s.");
        header('refresh: 3; url=' . $url2 . 'register/registerA.php');
      }
    } catch (Exception $e) {
      $error1 = "Could not connect to the database!";
      switch ($e->getCode()) {
        case "2002":
          $error2 = "Check the hostname.";
          $_POST["host"] = "";
          break;
        case "1045":
          $_POST["username"] = $_POST["password"] = "";
          $error2 = ("Check the username and/or the password.");
          break;
        case "1049":
          $error2 = ("Check the database name.");
          $_POST["dbname"] = "";
          break;
        default:
          echo $e->__toString();
          $error2 = ("Unknown error.");
          $_POST["host"] = $_POST["username"] = $_POST["password"] = $_POST["dbname"] = "";
          break;
      }
      feedback("red", $error1, $error2);
    }
  }
  ?>
  <nav class="navbar navbar-expand-lg bg-light fixed-top border">
    <div class="container-fluid justify-content-center">
      <h3>Configuring FunAcademy database</h3>
    </div>
  </nav>
  <main class="container-fluid  text-center justify-content-center mt-6">
    <form method="post" class="was-validated">
      <div class="form-floating col-5 mx-auto mb-4">
        <input autocomplete="off" type="text" class="form-control" name="host" placeholder="" required
          value="<?php save("host") ?>">
        <label for="host">DB hostname</label>
      </div>
      <div class="form-floating col-5 mx-auto mb-4">
        <input autocomplete="off" type="text" class="form-control" name="username" placeholder="" required
          value="<?php save("username") ?>">
        <label for="username">DB username</label>
      </div>
      <div class="form-floating col-5 mx-auto mb-4">
        <input autocomplete="off" type="password" class="form-control" name="password" placeholder=""
          value="<?php save("password") ?>">
        <label for="password">DB password</label>
      </div>
      <div class="form-floating col-5 mx-auto mb-3">
        <input autocomplete="off" type="text" class="form-control" name="dbname" placeholder="" required
          value="<?php save("dbname") ?>">
        <label for="dbname">DB name</label>
      </div>
      <button type="submit" class="btn btn-lg" name="submit" value="submit">Submit</button>
    </form>
  </main>
  <script src="<?php echo $url2 ?>vendor/bootstrap/bootstrap.bundle.min.js"></script>
</body>
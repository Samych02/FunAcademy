<?php
# Auto logging out if session timed out
if (isset($_SESSION["loggeddate"]) && isset($_SESSION["keepconnected"])) {
  if (time() - $_SESSION["loggeddate"] > (($_SESSION["keepconnected"]) ? 5000000 : 3600)) {
    unset($_SESSION);
    session_unset();
    session_destroy();
    header('Refresh: 0; url=' . $url2);
  }
}
?>
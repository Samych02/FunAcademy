<?php
/**
 *Make login required in order to access a certain page
 * the parameter sets which user type is required (0 for admins and 1 for both. 2 means no login required)
 * it also shows the correct navbar
 */
function login_required($user_type)
{
  switch ($user_type) {
    case 0:
      if (isset($_SESSION["user_type"]) and $_SESSION["user_type"] == 0) {
        navbar(0);
      } else {
        navbar(2);
        feedback("red", "Vous n'avez pas le droit à accéder à cette page!", "Vous serez dirigé vers la page d'acceuil dans 3s.");
        header('refresh: 3; url=' . $GLOBALS["url2"]);
        exit();
      }
      break;
    case 1:
      if (isset($_SESSION["user_type"]) and isset($_SESSION["name"])) {
        navbar((($_SESSION["user_type"] == 0) ? 0 : 1));
      } else {

        navbar(2);
        feedback("red", "Vous devez être connecté pour accéder à cette page!", "Vous serez dirigé vers la page de connection dans 3s.");
        header('refresh: 3; url=' . $GLOBALS["url2"] . 'login');
        exit();
      }
      break;
    case 2:
      if (isset($_SESSION["user_type"]) and isset($_SESSION["name"])) {
        navbar((($_SESSION["user_type"] == 0) ? 0 : 1));
      } else {
        navbar(2);
      }
      break;
  }
}
?>
<?php
/**
 *show navbar depending on user type
 */
#logging out if log out button is pressed
if (isset($_POST["logout"])) {
  unset($_SESSION);
  session_unset();
  session_destroy();
  header('refresh: 0; url=' . $url2);
}

function navbar($user_type)
{
  echo '<nav class="navbar navbar-expand-lg bg-light fixed-top">';
  echo '<div class="container-fluid">';
  echo '<a class="navbar-brand me-5" href="' . $GLOBALS["url2"] . '"><img src="' . $GLOBALS["url2"] . 'static/logo.svg" alt="FunAcademy" height="60" width="120"></a>';
  echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
  echo '<div class="collapse navbar-collapse " id="navbarNavDropdown">';
  echo '<ul class="navbar-nav">';
  echo '<li class="nav-item"><a href="' . $GLOBALS["url2"] . 'video" class="nav-link btn me-2"><i class="bi bi-camera-reels"></i> Cartoons</a></li>';
  echo '<li class="nav-item"><a href="' . $GLOBALS["url2"] . 'audio" class="nav-link btn me-2"><i class="bi bi-mic"></i> Audiobooks</a></li>';
  echo '<li class="nav-item"><a href="' . $GLOBALS["url2"] . 'book" class="nav-link btn me-2"><i class="bi bi-card-image"></i> Books</a></li></ul>';
  echo '<ul class="navbar-nav ms-auto">';
  if ($user_type == 2) {
    echo '<li class="nav-item"><a href="' . $GLOBALS["url2"] . 'login" class="nav-link btn me-2"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>';
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link btn dropdown-toggle" data-bs-toggle="dropdown" href="" role="button" aria-expanded="false"><i class="bi bi-person-fill"></i> Sign up</a>';
    echo '<ul class="dropdown-menu text-center" style="min-width: 100%">';
    echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'register/registerA.php">Admin</a></li>';
    echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'register/?e">Kid</a></li>';
    echo '</ul></li></ul></div></div></nav>';
  } elseif ($user_type == 0 or $user_type == 1) {
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link btn dropdown-toggle" data-bs-toggle="dropdown" href="" role="button" aria-expanded="false"style="min-width:180px !important;">Welcome ' . $_SESSION["username"] . ' </a>';
    echo '<ul class="dropdown-menu text-left me-3 mr-3" style="min-width: 100%">';
    echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'account"><i class="bi bi-person-circle"></i> My account</a></li>';
    echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'account/favorite.php"><i class="bi bi-star-fill"></i> My favorites</a></li>';
    if ($user_type == 0) {
      echo '<li><a class="dropdown-item" href=""><i class="bi bi-gear-wide-connected  "></i> Administration</a>';
      echo '<ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">';
      echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'administration/add.php">Add content</a></li>';
      echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'administration/index.php">Manage content</a></li>';
      echo '<li><a class="dropdown-item" href="' . $GLOBALS["url2"] . 'administration/pwchange.php">Change administrator password</a></li></ul></li>';
    }
    echo '<li><form name="logout" method="post" action="' . $GLOBALS["url2"] . 'home/index.php">';
    echo '<button type="submit" class="dropdown-item" name="logout" value="submit"><i class="bi bi-door-closed"></i> Logout</button>';
    echo '</form></li></ul></li></ul></div></div></nav>';
  }
}
?>
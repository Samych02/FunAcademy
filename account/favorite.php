<?php
$title = "My favorites";
include(dirname(__DIR__, 1) . "/functions/top.php");
login_required(1);
include($url1 . "functions/update_favorite.php");
include($url1 . "functions/cards.php");
?>
<main class="container-fluid pt-2 justify-content-center mt-6">
  <h1 class="text-center mb-5">Cartoons</h1>
  <?php
  list_card(0, "fav", $connection);
  ?>
  <hr>
  <h1 class="text-center mb-5">Audiobooks</h1>
  <?php
  list_card(1, "fav", $connection);
  ?>
  <hr>
  <h1 class="text-center mb-5">Books</h1>
  <?php
  list_card(2, "fav", $connection);
  ?>
</main>
<?php
include($url1 . "functions/bottom.php");
?>
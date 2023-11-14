<?php
/**
 *js alert function used for debugging
 */
function alert($message)
{
  echo '<script>alert(\'' . $message . '\')</script>';
}

/**
 *Display feedback text (color should either be red or green)
 */
function feedback($color, $message1, $message2)
{
  echo '<div class="' . (($color == "green") ? "alert-success" : "alert-danger") .' alert alert-dismissible d-flex align-items-center fade show mt-6 py-1">';
  echo '<i class="' . (($color == "green") ? "bi-check-circle-fill" : "bi-exclamation-octagon-fill") .'" style="font-size: 30px;"></i>';
  echo '<strong class="mx-2">';
  echo $message1;
  echo '</strong>';
  echo $message2;
  echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
  echo '</div>';
}
?>
<?php
/**
 *Save form data when not submitted succesfully
 */
function save($name)
{
  echo (!empty($_POST[$name])) ? $_POST[$name] : "";
}
?>
<?php
function nameVerif($string)
{
  if (preg_match("/^[a-zA-Zàâæáäãåāéèêëęėēûùüúūîïìíįīôœöòóõ ]{3,200}$/", $string)) {
    return true;
  }
  return false;
}
function usernameVerif($string)
{
  if (preg_match("/^[a-zA-Z0-9àâæáäãåāéèêëęėēûùüúūîïìíįīôœöòóõ\-_]{1,200}$/", $string)) {
    return true;
  }
  return false;
}
function emailVerif($string)
{
  if (preg_match("/^[a-zA-Z0-9._-]{1,190}+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $string)) {
    return true;
  }
  return false;
}
function passwordVerif($string){
  if (preg_match("/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[&\"'(§!)-_^¨$*`£%+:=@#,?.]).{8,200}$/", $string)) {
    return true;
  }
  return false;
  
}
function does_exist($element, $string){
  include ($GLOBALS["url1"] . "config.php");
  $connection = new mysqli($host, $username, $password, $dbname);
  if ($connection->connect_errno) {
    return true;
  }
  $q = $connection->query("SELECT {$element} FROM users;");
  while ($r = $q->fetch_array()) {
    if (strcasecmp($string, $r[0]) == 0) {
      return true;
    }
  }
  $connection->close();
  return false;
}
?>
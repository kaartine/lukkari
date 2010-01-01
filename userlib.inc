<?php
session_start();
session_register("session");

if($session[logged_in]==false)
  $session[name] = "kaartine";

function cleanAdminSession($id, $name, $pass)
{
 global $session;
 $session[id] = $id;
 $session[name] = $name;
 $session[password] = $pass;
 $session[logged_in] = true;
}

function checkUser()
{
 global $session;
 $session[logged_in] = false;
 $user_row = getRow("users","id",$session[id]);
 if(!$user_row || $user_row[name] != $session[name] || $user_row[password] != $session[password])
 {
  header("Location: login.php");
  exit;
 }
 
 $session[logged_in] = true;
 return $user_row;
}

?>

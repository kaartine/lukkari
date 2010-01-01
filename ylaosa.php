<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link type="text/css" rel="stylesheet" href="tyylit.css">
<title>-= Tupakoitsijat haisevat =-</title>
<meta name="Generator" content="HTMLPad 2002 Pro version 4.11 pro">
<meta name="Keywords" content="Jukka Kaartinen, Kaartinen, Trapezoidal Map, Ultimate">
<meta name="Description" content="Nothing">
<meta name="Author" content="Jukka Kaartinen">
<meta name="Owner" content="Jukka Kaartinen">
</head>

<body bgcolor="115577" link="ffffff" vlink="000000">

<table border="0" width="100%" align="center">
<tr>

<td align="center">
<code>

<?php
if($session[logged_in])
{
  print "<a href=\"user.php?\"".SID.">Lis&auml;&auml; kurssi</a> | ";
  print "<a href=\"logout.php?\"".SID.">Logout</a>";
  print "<br>Username: $session[name]";
}
else
{
 print "<a href=\"index.php?linkki=login\">Login</a> ";   
}
?>
</code>

</td>

</tr>

<tr>
<td class="keski">

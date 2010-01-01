<?php
 include("dblib.inc");
 include("userlib.inc");

 $message="";
 if(isset($tila) && $tila == "login")
 {
  if(empty($form[name]) || empty($form[password]))
   $message .= "Sun t‰ytyy t‰ytt‰‰ kaikki kent‰t!<br>\n";
   
  if( ! ($row_array = checkPass($form[name], md5($form[password])) ))
   $message .= "V‰‰r‰ salasana, yrit‰s uudestaan!<br>\n";
   
  if($message == "")
  {
   cleanAdminSession($row_array[id], $row_array[name], $row_array[password]);
   header("Location: koulu.php?".SID);
  }
 }
 
include("ylaosa.php");
?>

<br>
<h2>Login</h2>
<?php if(message != "") print "<p><b>$message</b></p>";?>

<form action="<?php print $PHP_SELF;?>" method="POST">
      <input type="hidden" name="tila" value="login">
      <input type="hidden" name="<?php print session_name();?>" value="<?php print session_id();?>">
      <p>Login:<br>
      <input name="form[name]" type="text" size="10" value="<?php print $form[name] ?>" tabindex="1" maxlength="8">
      </p>
      <p>Password:<br>
      <input name="form[password]" type="password" size="10" tabindex="2" maxlength="8">
      </p>
      <input type="submit" value="Login" tabindex="3">
</form>

<?php
include("alaosa.php");
?>

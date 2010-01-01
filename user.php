<?php
include ("dblib.inc");
include ("userlib.inc");
include ("date.inc");

$user_row = checkUser();

$message = "";
$date = time();

//<!--meneill‰ oleva kurssi-->
if(isset($tila) && $tila=="lisaame")
{
    if(isset($poistu))
    {
	header("Location: koulu.php?".SID);
	exit();
    }
    
    if(empty($form[numero]) )
      $message .= "VIRHE: Annapa kurssin numero.<br>\n";
    if(empty($form[kuvaus]))
      $message .= "VIRHE: Annapa kurssin kuvaus.<br>\n";
    if(empty($form[lyhenne]))
      $form[lyhenne] = "&nbsp;";
    
    foreach (array("paiva","kuukausi","vuosi") as $date_unit)
    {
	if(!isset($form[$date_unit]))
	{
	    $message .= "VIRHE: P‰iv‰m‰‰r‰st‰ ei saa selv‰‰.<br>\n";
	    break;
	}
    }
    
    $date = mktime(0,0,0,$form[kuukausi],$form[paiva],$form[vuosi]);
    
    if($message == "")
    {
	if(isset($kurssi_id) && $kurssi_id > 0)
	{
	    $id = $kurssi_id;
	}
	else
	  $id = false;	
	
      //	     phpinfo();
	lisaaKurssi($form,$date,"meneilla",$id,$session[name]);
	header("Location: koulu.php?".SID);
	exit();
    }
    else
      print $message;
}

//<!--Suoritettu kurssi-->
if(isset($tila) && $tila=="lisaa")
{
  if(empty($form[numero]) )
    $message .= "VIRHE: Annapa kurssin numero.<br>\n";
  if(empty($form[kuvaus]))
    $message .= "VIRHE: Annapa kurssin kuvaus.<br>\n";
  
  foreach (array("paiva","kuukausi","vuosi") as $date_unit)
  {
    if(!isset($form[$date_unit]))
    {
      $message .= "VIRHE: P‰iv‰m‰‰r‰st‰ ei saa selv‰‰.<br>\n";
      break;
    }
  }
  
  $date = mktime(0,0,0,$form[kuukausi],$form[paiva],$form[vuosi]);
  
  if($message == "")
  {
    lisaaKurssi($form,$date,"kurssit",false,$session[name]);
    header("Location: koulu.php?".SID);
  }
  else
    print $message;
}

if(isset($kurssi_id))
{
  $paivat = array("maa","tii","kes","tor","per");
  print "sessions: $session[name]";
  $kurssi = getRow("meneilla","id",$kurssi_id,$session[name]);
  
  for($i = 1; $i <= 4; $i++)
  {
    $periodi = "periodi$i";
    $tunnit[$i] = haeLukkari($periodi,$session[name],$kurssi_id);
    
    foreach($paivat as $paiva)
    {
      $tunnit[$i][$paiva] = unserialize($tunnit[$i][$paiva]);
    }
  }
}

include("ylaosa.php");
?>

<h2 align="left">Meneill&auml; oleva kurssi</h2>

<!--Lis‰‰ meneill‰ oleva kurssi-->
<form action="<?php print $PHP_SELF;?>" method="POST">
      <table border="1" cellpadding="1" cellspacing="0">
      <tr>
      <td rowspan="16" valign="top">
      <input type="hidden" name="tila" value="lisaame">
      <input type="hidden" name="<?php print session_name();?>" value="<?php print session_id();?>">
      <input type="hidden" name="kurssi_id" value="<?php print $kurssi_id ?>">
      
      <p>Kurssin nro.:<br>
      <input type="text" name="form[numero]" value="<?php print $kurssi[kurssinnum]; ?>" tabindex="1">
      </p>
      <p>
      Kurssin kuvaus:<br>
      <input type="text" name="form[kuvaus]" size="50" tabindex="2" maxlength="50" value="<?php print $kurssi[kurssinkuv]; ?>">
      </p>
      <p>
      Kurssin lyhenne:<br>
      <input type="text" name="form[lyhenne]" size="8" tabindex="3" maxlength="8" value="<?php print $kurssi[lyhenne]; ?>">
      </p>
      <p>Tentti P&auml;iv&auml;:<br>
      <select name="form[paiva]" size="1" tabindex="4">
              <option value="0" selected="selected">Ei tiedossa</option>
              <?php writeDayOptions($date,false);?>
      </select>
      <select name="form[kuukausi]" size="1" tabindex="5">
              <option value="0" selected="selected">Ei tiedossa</option>
              <?php writeMonthOptions($date,false);?>
      </select>
      <select name="form[vuosi]" size="1" tabindex="6">
              <option value="0" selected="selected">Ei tiedossa</option>
              <?php writeYearOptions($date,false);?>
      </select>
      </p>
      <p>
      Opintoviikot:<br>
      <select name="form[ov]" size="1" tabindex="7">
              <option value="1" <?php $kurssi[ov] == 1 ? print "selected=\"selected\"" : print ""; ?>>1</option>
              <option value="2" <?php $kurssi[ov] == 2 ? print "selected=\"selected\"" : print ""; ?>>2</option>
              <option value="3" <?php $kurssi[ov] == 3 ? print "selected=\"selected\"" : print ""; ?>>3</option>
              <option value="4" <?php $kurssi[ov] == 4 ? print "selected=\"selected\"" : print ""; ?>>4</option>
              <option value="5" <?php $kurssi[ov] == 5 ? print "selected=\"selected\"" : print ""; ?>>5</option>
              <option value="6" <?php $kurssi[ov] == 6 ? print "selected=\"selected\"" : print ""; ?>>6</option>
      </select>
      </p>
      </td>

<?php
for($i = 1; $i <= 4; $i++)
{
  print "<th colspan=\"5\">";
  print "Periodi $i";
  print "</th>";
  
  print "<tr>";
  $paivat = array("Ma" => "maa", "Ti" => "tii", "Ke" =>"kes", "To" => "tor", "Pe" => "per");
  foreach($paivat as $paiva => $koodi)
  {
    print "<th>$paiva</th>";
  }
  print "</tr>";
  print "<tr>";
  
  foreach($paivat as $paiva => $koodi)
  {
    $periodi = "periodi$i";
    print "<td valign=\"top\">";
    print "<select name=\"form[$periodi][$koodi][]\" size=\"11\" multiple=\"multiple\">";
    writeHourOptions($tunnit[$i][$koodi]);
    print "</select>";
    print "</td>";
  }
  print "</tr>";
  print "<tr>";
  for($k=1; $k < 6; $k++)
  {
    $luokka = "luokka$k";
    print "<td><input type=\"text\" name=\"form[$periodi][$luokka]\" 
	    value=\"".$tunnit[$i][$luokka]."\" size=\"8\"></td>";
  }
  print "</tr>";
}

print "</table>";
$value = isset($kurssi_id) ? "P&auml;ivit&auml" : "Lis&auml;&auml";
print "<input type=\"submit\" value=\"$value\" tabindex=\"8\">";
print "<input type=\"submit\" name=\"poistu\" value=\"Poistu\">";

?>
	
</form>

<br>
<hr noshade="noshade" size="1" width="80%" color="#000000">
<br>

<h2 align="left">L&auml;p&auml;isty kurssi</h2>

<!--Lis‰‰ suoritettu kurssi-->
<form action="<?php print $PHP_SELF;?>" method="GET">
      <input type="hidden" name="tila" value="lisaa">
      <input type="hidden" name="<?php print session_name();?>" value="<?php print session_id();?>">
      <input type="hidden" name="kurssi_id" value="<?php $kurssi_id ?>">
      
      <p>Kurssin nro.:<br>
      <input type="text" name="form[numero]" value="" tabindex="1">
      </p>
      <p>
      Kurssin kuvaus:<br>
      <input type="text" name="form[kuvaus]" size="50" tabindex="2" maxlength="50">
      </p>
      <p>Suoritus P&auml;iv&auml;m&auml;&auml;r&auml;:<br>
      <select name="form[paiva]" size="1" tabindex="3">
              <?php writeDayOptions($date,true);?>
      </select>
      <select name="form[kuukausi]" size="1" tabindex="4">
              <?php writeMonthOptions($date,true);?>
      </select>
      <select name="form[vuosi]" size="1" tabindex="5">
              <?php writeYearOptions($date,true);?>
      </select>
      </p>
      <p>
      Opintoviikot:<br>
      <select name="form[ov]" size="1" tabindex="6">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
      </select>
      </p>
      <p>
      Arvosana:<br>
      <select name="form[av]" size="1" tabindex="7">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4" selected="selected">4</option>
              <option value="5">5</option>
      </select>
      </p>
      <input type="submit" value="Lis&auml;&auml;" tabindex="8">
</form>


<?php
include("alaosa.php");
?>

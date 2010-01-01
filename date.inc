<?php
// $selected kertoo laitetaanko tämä päivämää oletukseksi
// $selected true == oletus
// $selected false ==
function writeDayOptions($d,$selected)
{
 $d_array = getDate($d);
 for ($x = 1; $x <= 31; $x++)
 {
  print "<option value=\"$x\"";
  print (($d_array[mday] == $x && $selected) ? "selected=\"selected\"" : "");
  print ">$x\n";
 }
}

function writeMonthOptions($d,$selected)
{
 $d_array = getDate($d);
 $months = array("&nbsp;&nbsp;1. Tam","&nbsp;&nbsp;2. Hel","&nbsp;&nbsp;3. Maa","&nbsp;&nbsp;4. Huh","&nbsp;&nbsp;5. Tou","&nbsp;&nbsp;6. Kes","&nbsp;&nbsp;7. Hei","&nbsp;&nbsp;8. Elo","&nbsp;&nbsp;9. Syy","10. Lok","11. Mar","12. Jou");

 foreach ($months as $key=>$value)
 {
  print "<option value=\"".($key+1)."\"";
  print (($d_array[mon] == $key+1 && $selected) ? "selected=\"selected\"" : "");
  print ">$value\n";
 }
}

function writeYearOptions($d,$selected)
{
 $d_array = getDate($d);
 $now_array = getDate(time());

 for($x = 1999; $x <= $now_array[year]; $x++)
 {
  print "<option value=\"$x\"";
  print (($d_array[year] == $x && $selected) ? "selected=\"selected\"" : "");
  print ">$x\n";
 }
}

function writeHourOptions($valitut)
{
 print "<option value=\"-1\"";
 print (($valitut[0] == -1) || !isset($valitut[0])? "selected=\"selected\"" : "");
 print ">Vapaata</option>\n";

 $korjattu = array();
 for ($x = 0; $x < 10; $x++ )
 {
  if(isset($valitut[$x]) && $valitut[$x] != -1)
  {
   $arvo = $valitut[$x];
   $korjattu[$arvo-8] = $valitut[$x];
  }

  print "<option value=\"".($x+8)."\"";
  print (($korjattu[$x] == ($x+8)) ? "selected=\"selected\"" : "");
  print ">".($x+8)." - ".($x+9)."</option>\n";
 }
}
?>

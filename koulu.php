<?php
include ("dblib.inc");
include ("userlib.inc");

//checkUser();

//Poistaa kurssin
if(isset($tila) && $tila=="poista" && isset($kurssi_id) && isset($taulu))
{
  if(checkUser())
  {
    poistaKurssi($kurssi_id, $taulu,$session[name]);
    if($taulu == "meneilla")
      poistaKurssi($kurssi_id, "periodi",$session[name]);
  }
}

include("ylaosa.php");
?>

<br>
<?php
if($session[logged_in])
{
  ?>
	Tulosta seuraavat periodit:
	<form action="printtaa.php" method="GET">
		<table border="0" cellpadding="1" celspacing="0">
		<tr>
		<td>1. <input type="checkbox" name="periodi1"></td>
		<td>2. <input type="checkbox" name="periodi2"></td>
		<td>3. <input type="checkbox" name="periodi3"></td>
		<td>4. <input type="checkbox" name="periodi4"></td>
		</tr>		
		<tr><td colspan="4">Kurssin nro.<input type="checkbox" name="knumero"></td></tr>
		<tr><td colspan="4">Kurssin nimi<input type="checkbox" name="knimi" checked="true"></td></tr>
		<tr><td colspan="4">Luokka<input type="checkbox" name="luokkat" checked="true"></td></tr>		
		</table>
		<input type="submit" value="Katsele">
	</form>	
  
  <?php
}

?>
	
<br>			
<!--lukujärjestys-->
 <strong>Lukuj&auml;rjestykseni</strong>
<br>
<?php
$init = array(8 => "&nbsp;",9 => "&nbsp;",10 => "&nbsp;",
	      11 => "&nbsp;",12 => "&nbsp;",13 => "&nbsp;",
	      14 => "&nbsp;",15 => "&nbsp;",16 => "&nbsp;",
	      17 => "&nbsp;",18 => "&nbsp;");

for($i = 1; $i <= 4; $i++)
{
  print "<br>";
  print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
  $lukkari = array(maa => $init, tii => $init, kes => $init, tor => $init, per => $init);
  
  $periodi = "periodi".$i;
  print "<tr><td colspan=\"6\"><b> Periodi $i </b></td></tr>";
  //    print "kursseja: ".sizeof($kurssit);
    
  print "<tr bgcolor=\"#4476C1\">";
  print "<th width=\"50\">Klo</th>";
  print "<th width=\"150\">Maanantai</th>";
  print "<th width=\"150\">Tiistai</th>";
  print "<th width=\"150\">Keskiviikko</th>";
  print "<th width=\"150\">Torstai</th>";
  print "<th width=\"150\">Perjantai</th>";
  print "</tr>";
  
  //    print "$session[name]_$periodi";
  $kurssit = haeLukkari($periodi,$session[name]);

  $paivat = array("maa","tii","kes","tor","per");
  foreach( $kurssit as $kurssi)
  {	
    $laskuri = 1;
    foreach($paivat as $pv)
    {
      $luokka = "luokka".$laskuri;
      $paiva = unserialize($kurssi[$pv]);
      if(is_array($paiva) )
      {	
	foreach($paiva as $klo)
	{		    
	  if(!empty($lukkari[$pv][$klo]) && $lukkari[$pv][$klo] != "&nbsp;")
	    $lukkari[$pv][$klo] .="<font class=\"erotin\"> ## </font><br>&nbsp;";
	  	  
      	  $lukkari[$pv][$klo] .= $kurssi[kurssinnum]."<font class=\"lyhenne\">".$kurssi[lyhenne]."</font>&nbsp;<font class=\"luokka\">".$kurssi[$luokka]."</font>";
	}
      }
      $laskuri++;
    }
  }
  $tunti = 8;
  $bgcolor = "#000000";
  $tuplat = array(maa=>0,tii=>0,kes=>0,tor=>0,per=>0);
  while($tunti < 18)
  {
    print "<tr>";
    print "<th bgcolor=\"#4444C1\">".$tunti." - ".($tunti+1)."</th>";

    if(($lukkari[maa][$tunti+1] == $lukkari[maa][$tunti] ||
	$lukkari[maa][$tunti-1] == $lukkari[maa][$tunti]) && $lukkari[maa][$tunti] != "&nbsp;")
    {
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[maa][$tunti]."</td>";
    }
    else
    {
      print "<td bgcolor=\"#000000\" class=\"lukkari\">".$lukkari[maa][$tunti]."</td>";
    }
    
    if(($lukkari[tii][$tunti+1] == $lukkari[tii][$tunti] ||
	$lukkari[tii][$tunti-1] == $lukkari[tii][$tunti]) && $lukkari[tii][$tunti] != "&nbsp;")
    {
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[tii][$tunti]."</td>";
    }
    else
    {
      print "<td bgcolor=\"#000000\" class=\"lukkari\">".$lukkari[tii][$tunti]."</td>";
    }
	
    if(($lukkari[kes][$tunti+1] == $lukkari[kes][$tunti] ||
	$lukkari[kes][$tunti-1] == $lukkari[kes][$tunti]) && $lukkari[kes][$tunti] != "&nbsp;")
    {
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[kes][$tunti]."</td>";
    }
    else
    {
      print "<td bgcolor=\"#000000\" class=\"lukkari\">".$lukkari[kes][$tunti]."</td>";
    }
    
    if(($lukkari[tor][$tunti+1] == $lukkari[tor][$tunti] ||
	$lukkari[tor][$tunti-1] == $lukkari[tor][$tunti]) && $lukkari[tor][$tunti] != "&nbsp;")
    {
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[tor][$tunti]."</td>";
    }
    else
    {
      print "<td bgcolor=\"#000000\" class=\"lukkari\">".$lukkari[tor][$tunti]."</td>";
    }
    
    if(($lukkari[per][$tunti+1] == $lukkari[per][$tunti] ||
	$lukkari[per][$tunti-1] == $lukkari[per][$tunti]) && $lukkari[per][$tunti] != "&nbsp;")
    {
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[per][$tunti]."</td>";
    }
    else
    {
      print "<td bgcolor=\"#000000\" class=\"lukkari\">".$lukkari[per][$tunti]."</td>";
    }
    
    print "</tr>";
    $tunti++;
  }
  print "</table>";
}
?>
		


<br>
<!--Meneillä olevat kurssit-->
<p align="left">
<strong>Meneill&auml; olevat kurssit</strong>
<table border="1"  cellpadding="1" cellspacing="0">
 <tr bgcolor="#4476C1">
  <th><a href="?sort1=kurssinnum" class="menu2">Kurssin nro.</a></th>
  <th width="8"><a href="?sort1=lyhenne" class="menu2">Lyhenne</a></th>
  <th width="200"><a href="?sort1=kurssinkuv" class="menu2">Kurssin kuvaus</a></th>
  <th><a href="?sort1=pvm" class="menu2">Tentti p&auml;iv&auml;</a></th>
  <th><a href="?sort1=ov" class="menu2">Ov</a></th>
  <td></td>
 </tr>

<?php
 $kurssinnum = 0;
 $kurssinkuv = "tyhj&auml;";
 $tenttipvm = "tyhj&auml;";
 $ov = 0;

 $ovviikot = 0;

 $kurssit = haeKurssit($sort1,"meneilla",$session[name]);

 foreach( $kurssit as $kurssi)
 {
  $id = $kurssi[id];
  $kurssinnum = $kurssi[kurssinnum];
  $kurssinkuv = $kurssi[kurssinkuv];
  $lyhenne = $kurssi[lyhenne];
  $tenttipvm = $kurssi[pvm];
  $ov = $kurssi[ov];

  print "<tr>";
      if($session[logged_in])
      {
       print "<td bgcolor=\"#33CC33\" align=\"right\"><a href=\"user.php?kurssi_id=$id&".SID."\">$kurssinnum</a></td>";
      }
      else
      {
       print "<td bgcolor=\"#33CC33\" align=\"right\">$kurssinnum</td>";
      }
      
      print "<td bgcolor=\"#33CC33\" align=\"left\">$lyhenne</td>";
      print "<td bgcolor=\"#33CC33\" align=\"left\">$kurssinkuv</td>";
      print "<td bgcolor=\"#33CC33\" align=\"center\">";
      $tenttipvm > -1 ? print date("d.m.Y",$tenttipvm) : print "Ei tiedossa";
      print "</td>";
      print "<td bgcolor=\"#33CC33\" align=\"center\">$ov</td>";

      if($session[logged_in])
      {
       print "<td bgcolor=\"#33CC33\" align=\"center\"><a href=\"?tila=poista&kurssi_id=$id&taulu=meneilla&".SID."\"";
	print " onClick=\"return window.confirm('Oletko aivan varma!')\">Poista</a></td>";
      }
      else
      {
       print "<td bgcolor=\"#33CC33\" align=\"center\">Poista</td>";
      }
  print "</tr>";

  $ovviikot += $ov;
 }

 print "<tr bgcolor=\"#4444C1\"><th class=\"tborder\" align=\"right\" colspan=\"4\">Noppia hakusessa</th><th class=\"tborder\">$ovviikot</th><td rowspan=\"3\"></td></tr>";
 print "<tr bgcolor=\"#4444C1\"><th align=\"right\" colspan=\"4\">Kursseja hakusessa</th><th>".count($kurssit)."</th></tr>";

?>
</table>

<br>
<!--Käydyt kurssit-->
<p align="left">
<strong>K&auml;ydyt kurssit</strong>	
<table border="1"  cellpadding="1" cellspacing="0">
 <tr bgcolor="#4476C1">
  <th><a href="?sort2=kurssinnum" class="menu2">Kurssin nro.</a></th>
  <th width="200"><a href="?sort2=kurssinkuv" class="menu2">Kurssin kuvaus</a></th>
  <th><a href="?sort2=pvm" class="menu2">Suoritusp&auml;iv&auml;</a></th>
  <th><a href="?sort2=ov" class="menu2">Ov</a></th>
  <th><a href="?sort2=av" class="menu2">Arvosana</a></th>
  <td></td>
 </tr>

<?php
$kurssinnum = 0;
$kurssinkuv = "tyhj&auml;";
$suorpm = "tyhj&auml;";
$ov = 0;
$av = 0;

$ovviikot = 0;
$keskiarvo = 0.0;

if(!isset($sort))
  $sort2="pvm";
$kurssit = haeKurssit($sort2,"kurssit",$session[name]);

foreach( $kurssit as $kurssi)
{
    $id = $kurssi[id]; 
    $kurssinnum = $kurssi[kurssinnum];
    $kurssinkuv = $kurssi[kurssinkuv];
    $suorpm = $kurssi[pvm];
    $ov = $kurssi[ov];
    $av = $kurssi[av];
    
    print "<tr>";
    print "<td bgcolor=\"#33CC33\" align=\"right\">$kurssinnum</td>";
    print "<td bgcolor=\"#33CC33\" align=\"left\">$kurssinkuv</td>";
    print "<td bgcolor=\"#33CC33\" align=\"center\">";
    print date("d.m.Y",$suorpm);
    print "</td>";
    print "<td bgcolor=\"#33CC33\" align=\"center\">$ov</td>";
    print "<td bgcolor=\"#33CC33\" align=\"center\">$av</td>";
    
    if($session[logged_in])
    {
	print "<td bgcolor=\"#33CC33\" align=\"center\"><a href=\"?tila=poista&kurssi_id=$id&taulu=kurssit&".SID."\"";
	print " onClick=\"return window.confirm('Oletko aivan varma!')\">Poista</a></td>";
    }
    else
    {
	print "<td bgcolor=\"#33CC33\" align=\"center\">Poista</td>";
    }
    print "</tr>";
    
    $ovviikot += $ov;
    $keskiarvo += (double)$ov*$av;
}
if($ovviikot != 0)
  $keskiarvo /= (double)$ovviikot;
else
  $keskiarvo = 0.0;

printf("<tr bgcolor=\"#4444C1\"><th class=\"tborder\" align=\"right\" colspan=\"4\">Opintoviikkoja</th><th class=\"tborder\">% 3d</th><td rowspan=\"3\"></td></tr>",$ovviikot);
printf("<tr bgcolor=\"#4444C1\"><th align=\"right\" colspan=\"4\">Keskiarvo</th><th>%1.2f</th></tr>",$keskiarvo);
print "<tr bgcolor=\"#4444C1\"><th align=\"right\" colspan=\"4\">Kursseja yhteens&auml;</th><th>".count($kurssit)."</th></tr>";

?>
</table>
</p>

<?php

include("alaosa.php");

?>

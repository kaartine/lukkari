<?php
include ("dblib.inc");
include ("userlib.inc");


$init = array(8 => "&nbsp;",9 => "&nbsp;",10 => "&nbsp;",
	      11 => "&nbsp;",12 => "&nbsp;",13 => "&nbsp;",
	      14 => "&nbsp;",15 => "&nbsp;",16 => "&nbsp;",
	      17 => "&nbsp;",18 => "&nbsp;");
//phpinfo();
for($i = 1; $i <= 4; $i++)
{
  $pr = "periodi".$i;
  if(isset($$pr) && $$pr = "on")
  {  
    print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">";
    $lukkari = array(maa => $init, tii => $init, kes => $init, 
		     tor => $init, per => $init);
  
    $periodi = "periodi".$i;
    print "<tr><td colspan=\"6\"><b> Periodi $i </b></td></tr>";
    
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
	      $lukkari[$pv][$klo] .="<font class=\"erotin\"> ##<br></font>&nbsp;";
	    
	    if(isset($knumero))
	      $lukkari[$pv][$klo] .= $kurssi[kurssinnum]."&nbsp;";
	    if(isset($knimi))
	      $lukkari[$pv][$klo] .= "<font class=\"lyhenne\">".$kurssi[lyhenne]."</font>&nbsp;";
	    if(isset($luokkat))
	      $lukkari[$pv][$klo] .= "<font class=\"lyhenne\">".$kurssi[$luokka]."</font>&nbsp;";
	  }
	}
	$laskuri++;
      }
    }
    
    $tunti = 8;
    $bgcolor = "#FFFFFF";
    $tuplat = array(maa=>0,tii=>0,kes=>0,tor=>0,per=>0);
    while($tunti < 18)
    {
      print "<tr>";
      print "<th bgcolor=\"#FFFFFF\">".$tunti."-".($tunti+1)."</th>";
    
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[maa][$tunti]."</td>";
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[tii][$tunti]."</td>";
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[kes][$tunti]."</td>";
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[tor][$tunti]."</td>";
      print "<td bgcolor=\"$bgcolor\" class=\"lukkari\">".$lukkari[per][$tunti]."</td>";
      
      print "</tr>";
      $tunti++;
    }
    print "</table><br>";
  }
}
?>

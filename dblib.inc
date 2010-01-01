<?php

$link;
connectToDB();

function getUserID($username)
{
  global $link;
  $query = "select id from users where name='$username'";
 
  $result = mysql_query( $query, $link);
//  print $query."<br>";
  if ( ! $result )
    die ( "getRow fatal error: ".mysql_error() );
  $userid = mysql_fetch_array( $result );
// print $userid[id]."<br>";
  return $userid[id];
  
  //  if($session[logged_in] == true)
  //  return $session[id];
}

function connectToDB()
{
 global $link;
 $link = mysql_connect( "localhost", "kaartine", "kaartamo" );

 if ( ! $link )
  die( "Couldn't connect to MySQL" );
 mysql_select_db( "lukkari", $link )
 or die ( "Couldn't open organizer: ".mysql_error() );
}

function getRow( $table, $fnm, $fval, $username="" )
{
  global $link;
  $query = "SELECT * FROM $table WHERE $fnm='$fval'";
    
  if($username != "")
  {
    
    //    $result = mysql_query( "select id from users where name='$username'", $link);
    //  if ( ! $result )
    //  die ( "getRow fatal error: ".mysql_error() );
    //$userID = mysql_fetch_array( $result );

    $userID = getUserID($username);
    $query .= "and user='$userID'";
  }
    
  $result = mysql_query( $query, $link );
  if ( ! $result )
    die ( "getRow fatal error: ".mysql_error() );
  return mysql_fetch_array( $result );
}

function checkPass( $login, $password )
{
 global $link;
 $result = mysql_query( "SELECT id, name, password FROM users
 WHERE name='$login' and password='$password'", $link );
 if ( ! $result )
  die ( "checkPass fatal error: ".mysql_error() );
 if ( mysql_num_rows( $result ) )
  return mysql_fetch_array( $result );
 return false;
}

function uusiKurssi( $kurssinnum, $kurssinkuv, $pvm, $ov, $av,&$dberror, $username )
{
  global $link;
  $table = "kurssit";

  $userID = getUserID($username);

  $query = "UPDATE INTO $table ( kurssinnum, kurssinkuv, pvm, ov, av, user )
    VALUES( '$kurssinnum', '$kurssinkuv', '$pvm', '$ov', '$av', '$userID')";

 $result = mysql_query( $query, $link );
 if ( ! $result )
  die ( "insertEvent error: ".mysql_error() );
}

function paivitaLukkari($form,$id, $username,$uusi = true )
{
  global $link;
  $query = "";
  $userID = getUserID($username);
  
  for($i = 1; $i <= 4; $i++)
  {
    $periodi = "periodi$i";
    
    $maa = serialize($form[$periodi][maa]);
    $tii = serialize($form[$periodi][tii]);
    $kes = serialize($form[$periodi][kes]);
    $tor = serialize($form[$periodi][tor]);
    $per = serialize($form[$periodi][per]);

    if($uusi == true)
    {
      $query = "INSERT INTO $periodi (id, maa, tii, kes, tor, per, user, 
				      luokka1, luokka2, luokka3, luokka4,
				      luokka5)
	VALUES( '$id', '$maa', '$tii', '$kes', '$tor', '$per', '$userID', 
		'".$form[$periodi][luokka1]."', '".$form[$periodi][luokka2]."', 
		'".$form[$periodi][luokka3]."', '".$form[$periodi][luokka4]."',
		'".$form[$periodi][luokka5]."')";
    }
    else
    {
      $query = "UPDATE $periodi SET id='$id', maa='$maa', tii='$tii',
		 kes='$kes', tor='$tor', per='$per',
		 luokka1='".$form[$periodi][luokka1]."', luokka2='".$form[$periodi][luokka2]."', 
		 luokka3='".$form[$periodi][luokka3]."', luokka4='".$form[$periodi][luokka4]."',
		 luokka5='".$form[$periodi][luokka5]."' WHERE id='$id' and user='$userID'";
    }

    $result = mysql_query( $query, $link );
    if ( ! $result )
      die ( "insertEvent error: ".mysql_error() );
  }
}

function haeLukkari($periodi, $username, $id = 0 )
{
  global $link;
  $userID = getUserID($username);
  $table = "$periodi";
 
  $query = "";
  
  $query = "SELECT $table.*, meneilla.id, meneilla.kurssinnum,";
  $query .= " meneilla.lyhenne";
  $query .= " FROM $table, meneilla";
  
  $query .= " WHERE $table.id=meneilla.id and meneilla.user=$userID and $table.user='$userID'";
  
  if($id > 0)
    $query .= " AND $table.id=".$id;
  
//  print $query;
  $result = mysql_query( $query, $link );
  if ( ! $result )
    die ( "getIDevents fatal error: ".mysql_error() );
  
  if($id == 0)
  {
    $ret = array();
    while ( $row = mysql_fetch_array( $result ) )
      array_push( $ret, $row );
    
    return $ret;
  }
  else
    return mysql_fetch_array( $result );
}

function lisaaKurssi($kurssi,$pvm,$taulu,$id,$username)
{
  global $link;
  $userID = getUserID($username);
  $table = "$taulu";
  $query = "";
  
  if ( $taulu == "kurssit")
  {
    $query = "INSERT INTO $table (kurssinnum, kurssinkuv, pvm, ov, av, user)
      VALUES( '$kurssi[numero]', '$kurssi[kuvaus]', '$pvm', '$kurssi[ov]', '$kurssi[av]', '$userID')";
  }
  elseif ( $taulu == "meneilla")
  {  
    if( !$id )
    {
      $query = "INSERT INTO $table (kurssinnum, kurssinkuv, lyhenne, pvm, ov, user)
	VALUES( '$kurssi[numero]', '$kurssi[kuvaus]', '$kurssi[lyhenne]', '$pvm', 
		'$kurssi[ov]', '$userID')";
    }
    else
    {
      $query = "UPDATE $table SET kurssinnum='$kurssi[numero]',";
      $query .= "kurssinkuv='$kurssi[kuvaus]', pvm='$pvm', ov='$kurssi[ov]', 
		  lyhenne='$kurssi[lyhenne]' WHERE id='$id' and user='$userID'";
    }
  }
  $result = mysql_query( $query, $link );
  if ( ! $result )
    die ( "insertEvent error: ".mysql_error() );
  
  if($taulu == "meneilla" && !$id)
    paivitaLukkari($kurssi,mysql_insert_id(),$username);
  elseif($taulu == "meneilla" && $id)
    paivitaLukkari($kurssi,$id,$username,false);
}

/*function vanhalisaaKurssi($numero,$kuvaus,$pvm,$ov,$av,$taulu,$id,$username )
{
  global $link;
  $userID = getUserID($username);
  $table = "$taulu";
  $query = "";
  
  if ( $taulu == "kurssit")
  {
    $query = "INSERT INTO $table (kurssinnum, kurssinkuv, pvm, ov, av)
      VALUES( '$numero', '$kuvaus', '$pvm', '$ov', '$av') where user=$userID";
  }
  elseif ( $taulu == "meneilla")
  {
    if($id == -1)
    {
      $query = "INSERT INTO $table (kurssinnum, kurssinkuv, pvm, ov)
	VALUES( '$numero', '$kuvaus', '$pvm', '$ov') where user=$userID";
    }
    else
    {
      $query = "UPDATE $table SET kurssinnum='$numero',";
      $query .= "kurssinkuv='$kuvaus', pvm='$pvm', ov='$ov' WHERE id='$id' and user=$userID";
    }
  }
  
  $result = mysql_query( $query, $link );
  if ( ! $result )
    die ( "insertEvent error: ".mysql_error() );
}
*/

function poistaKurssi( $id, $taulu, $username )
{
  global $link;
  $userID = getUserID($username);
  $table = $taulu;
  if($taulu == "periodi")
  {
    for($i = 1; $i <= 4; $i++)
    {
      $table = $taulu;
      $table .= $i;
      $query = "DELETE FROM $table WHERE id='$id' and user=$userID";
      $result = mysql_query( $query, $link );
      if ( ! $result )
        die ( "deleteEvent fatal error: ".mysql_error() );
    }
  }
  else 
  {
    $query = "DELETE FROM $table WHERE id='$id' and user=$userID";
    $result = mysql_query( $query, $link );
    if ( ! $result )
      die ( "deleteEvent fatal error: ".mysql_error() );
  }
  return ( mysql_affected_rows($link) );
}

function haeKurssit($jarj, $taulu, $username )
{
  global $link;
  $userID = getUserID($username);
  $table = "$taulu";
  
  if(empty($jarj))
    $jarj = "kurssinnum";
  
  if(!isset($taulu))
    die("You must select a table!");
  
  $query = "SELECT *";
  $query .= "FROM $table where user=$userID";
  $query .= " ORDER BY $table.".$jarj;
  
  $result = mysql_query( $query, $link );
  if ( ! $result )
    die ( "getIDevents fatal error: ".mysql_error() );

  $ret = array();
  while ( $row = mysql_fetch_array( $result ) )
    array_push( $ret, $row );
  return $ret;
}

?>

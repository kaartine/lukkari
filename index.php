<?php
include ("dblib.inc");
include ("userlib.inc");

     if (!isset($linkki))
        header("Location: koulu.php?".SID);
     elseif ($linkki == "login")
        header("Location: login.php?".SID);
     else
        header("Location: paasivu.php?".SID);
?>




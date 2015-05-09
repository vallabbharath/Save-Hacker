<?php
$dbh=mysql_connect ("localhost", "dotsifrx_parking", "Nimda@123") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("dotsifrx_parking");
if (isset($_GET["id"])) {
  $id = intval(base64_decode($_GET["id"]));

      $result = "SELECT * FROM vehicleowner where userid='$id'";
    $selsql=mysql_query($result) or die ("select query failed");
    $inttotal=mysql_num_rows($selsql);

$rows=mysql_fetch_assoc($selsql);
     $visible=$rows['visible'];

    if ($inttotal > 0) {

      if ($visible == "1") {
        $msg = "Your account has already been activated.";
        $msgType = "info";
      } else {
        $updatesql="update vehicleowner set visible='1' where userid='$id' ";
mysql_query($updatesql)or die("update query failed");
        $msg = "Your account has been activated.";
        $msgType = "success";
      }
    } else {
      $msg = "No account found";
      $msgType = "warning";
    }
  } 

echo $msg;

?>
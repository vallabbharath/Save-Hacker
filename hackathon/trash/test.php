<?php
$myStr='20150509';
$stryear = substr($myStr, 0, 4);

$split2 = substr($myStr, 4, 5);

$strmonth = substr($split2, 0, 2);

$strdate = substr($split2, 2, 3);



$strfulldt=$strdate.'-'.$strmonth.'-'.$stryear;
//echo $strfulldt;


$myStr='1830';
$split1 = substr($myStr, 0, 2);
$split2 = substr($myStr, 2, 3);


$strfromtime=$split1.':'.$split2;
?>
<?php

include("parser_fbinotel.php");

$binotel = NEW binotel;

$binotel->widgetID = "23531";


$binotel->startDay = "01";
$binotel->startMonth = "11";
$binotel->startYear = "2016";


$binotel->stopDay = "31";
$binotel->stopMonth = "11";
$binotel->stopYear  = "2016";

$binotel->login = "";
$binotel->password = "";


$binotel->start();
echo $binotel->getGetCall($_REQUEST['requesttype']);





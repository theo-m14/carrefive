<?php
include("src/bddcall.php");
include('src/functions.php');
$bdd = bddcall();
exportCSV($bdd);
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=productExport.csv");
?>
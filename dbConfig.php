<?php
$dbHost ="localhost";  //database adddress
$dbUsername ="id20510999_esp_board";   //database username
$dbPassword ="Cifri_neppa_23";        // database password
$dbName ="id20510999_esp_board";       //dbname

//create databse connection
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

//cheak connection is succesfull or not
if($db->connect_error){
    die("connection failed:" .$db->connect_error);
}

?>

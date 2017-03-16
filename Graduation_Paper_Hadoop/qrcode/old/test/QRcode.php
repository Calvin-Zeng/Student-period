<?php
include "QRdataencoding.php";

function qrcode_img($data){
$QRdata = new QRdataencoding;
$QRdata -> qrcode_data_string=$data;
$QRdata -> qrcode_module_size=@$_GET["s"];
$name=$QRdata -> QRsetting ( );
return $name ;
}
echo qrcode_img("nnnnnnnnnnn"); ?>
 


<?php
include "QRdataencoding.php";
$QRdata = new QRdataencoding;
$QRdata -> qrcode_data_string=@$_GET['d'];
$QRdata -> qrcode_module_size=@$_GET['s'];
$name=$QRdata -> QRsetting ( );
 ?>
 


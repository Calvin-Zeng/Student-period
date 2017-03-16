<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
require_once('php_python.php'); 
?>
<?php
echo ppython("module::make",$_GET['url'],"123");
?>

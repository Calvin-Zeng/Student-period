
<?php 
require_once('php_python.php'); 
?>
<?php
 header("Content-Type:text/html; charset=utf-8");
$data=$_POST["myHttpData"];
echo "從Android 客戶端發送 所接收到的訊息:".$data;

?>
<?php/*
header ("Content-Type:text/html; charset=utf-8");
$GLOBALS['THRIFT_ROOT'] = 'thrift';
require_once( $GLOBALS['THRIFT_ROOT'].'/Thrift.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/packages/Hbase/Hbase.php' );

$socket = new TSocket( '120.105.81.160',9090);
$socket->setSendTimeout( 10000 ); // Ten seconds (too long for production, but this is just a demo ;)
$socket->setRecvTimeout( 20000 ); // Twenty seconds
$transport = new TBufferedTransport( $socket );
$protocol = new TBinaryProtocol( $transport );
$client = new HbaseClient( $protocol );
*/
?> 



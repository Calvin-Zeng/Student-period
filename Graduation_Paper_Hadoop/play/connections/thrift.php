<?php
$GLOBALS['THRIFT_ROOT'] = '../thrift';

require_once( $GLOBALS['THRIFT_ROOT'].'/Thrift.php' );

require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php' );

# According to the thrift documentation, compiled PHP thrift libraries should
# reside under the THRIFT_ROOT/packages directory.  If these compiled libraries 
# are not present in this directory, move them there from gen-php/.  
require_once( $GLOBALS['THRIFT_ROOT'].'/packages/Hbase/Hbase.php' );

function printRow( $rowresult ) {
  echo( "row: {$rowresult->row}, cols: \n" );
  $values = $rowresult->columns;
  asort( $values );
  foreach ( $values as $k=>$v ) {
    echo( "  {$k} => {$v->value}\n" );
  }
}

$socket = new TSocket( '120.105.81.163',9090);
$socket->setSendTimeout( 10000 ); // Ten seconds (too long for production, but this is just a demo ;)
$socket->setRecvTimeout( 20000 ); // Twenty seconds
$transport = new TBufferedTransport( $socket );
$protocol = new TBinaryProtocol( $transport );
$client = new HbaseClient( $protocol );

$transport->open();

?>
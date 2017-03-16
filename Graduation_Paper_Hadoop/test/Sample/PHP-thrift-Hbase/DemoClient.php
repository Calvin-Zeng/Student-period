<meta charset="UTF-8" />

<?php
/**
 * Copyright 2008 The Apache Software Foundation
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

# Instructions:
# 1. Run Thrift to generate the php module HBase
#    thrift -php ../../../src/main/resources/org/apache/hadoop/hbase/thrift/Hbase.thrift
# 2. Modify the import string below to point to {$THRIFT_HOME}/lib/php/src.
# 3. Execute {php DemoClient.php}.  Note that you must use php5 or higher.
# 4. See {$THRIFT_HOME}/lib/php/README for additional help.

# Change this to match your thrift root
$GLOBALS['THRIFT_ROOT'] = 'thrift';

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

$t = 'test0816';

?>

<html>
<head>
<title>test</title>
</head>
<body>
<pre>




<?php

#
# Scan all tables, look for the demo table and delete it.
#
echo( "scanning tables...\n" );
$tables = $client->getTableNames();
sort( $tables );
foreach ( $tables as $name ) {
  echo( "  found: {$name}\n" );
  if ( $name == $t ) {
    if ($client->isTableEnabled( $name )) {
      echo( "    disabling table: {$name}\n");
      $client->disableTable( $name );
    }
    echo( "    deleting table: {$name}\n" );
    $client->deleteTable( $name );
  }
}

        //定義columns 的物件結構，一個Column需要new出一個ColumnDescriptor物件
        $columns = array(
                new ColumnDescriptor( array(
                        'name' => 'info:'
                ) ),
                new ColumnDescriptor( array(
                        'name'=> 'null:',
                ) )
        );

        //$t = "test0816";//Table name
        echo( "creating table: {$t}\n" );
        try
        {
                $client->createTable( $t, $columns );
        }
        catch ( AlreadyExists $ae )
        {
                echo( "WARN: {$ae->message}\n" );
        }


		
//列出 table內的column family
        //$t = "results";//資料表名稱
        echo( "column families in {$t}:\n" );
        $descriptors = $client->getColumnDescriptors( $t );
        asort( $descriptors );
        foreach ( $descriptors as $col )
        {
                echo( " column: {$col->name}, maxVer: {$col->maxVersions}\n" );
        }		

		//$t = "results";//Table name
        $row = "s1";//row name
        $valid = "湯姆";
		$valid1 = "Tom2";
        $mutations = array(
        new Mutation( array(
                'column' => 'info:name',
                'value' => $valid
                 ) )
        );
		$mutations1 = array(
				        new Mutation( array(
                'column' => 'info:null',
                'value' => $valid1
                 ) )
        );
        $client->mutateRow( $t, $row, $mutations );
		$client->mutateRow( $t, $row, $mutations1 );
        echo "新增成功<br>  ";
		
				$table_name = 'test0816';
$row_name = 's1';
$fam_col_name = 'info:name';

  $arr = $client->get($table_name, $row_name , $fam_col_name);
  // $arr = array
  foreach ( $arr as $k=>$v  ) {
    // $k = TCell
	//echo ("fam_col_name = {$v->col_name} , <br>  "); 
    echo ("value = {$v->value} , <br>  "); 
    echo ("timestamp = {$v->timestamp}  <br>");
}

		
?>
		

</pre>
</body>
</html>


<?php 
#
# Test UTF-8 handling
#
$invalid = "foo-\xfc\xa1\xa1\xa1\xa1\xa1";
$valid = "foo-\xE7\x94\x9F\xE3\x83\x93\xE3\x83\xBC\xE3\x83\xAB";

# non-utf8 is fine for data
$mutations = array(
  new Mutation( array(
    'column' => 'entry:foo',
    'value' => $invalid
  ) ),
);
$client->mutateRow( $t, "foo", $mutations );

# try empty strings
$mutations = array(
  new Mutation( array(
    'column' => 'entry:',
    'value' => ""
  ) ),
);
$client->mutateRow( $t, "", $mutations );

# this row name is valid utf8
$mutations = array(
  new Mutation( array(
    'column' => 'entry:foo',
    'value' => $valid
  ) ),
);
$client->mutateRow( $t, $valid, $mutations );

# non-utf8 is not allowed in row names
try {
  $mutations = array(
    new Mutation( array(
      'column' => 'entry:foo',
      'value' => $invalid
    ) ),
  );
  $client->mutateRow( $t, $invalid, $mutations );
  throw new Exception( "shouldn't get here!" );
} catch ( IOError $e ) {
  echo( "expected error: {$e->message}\n" );
}

# Run a scanner on the rows we just created
echo( "Starting scanner...\n" );
$scanner = $client->scannerOpen( $t, "", array( "entry:" ) );
try {
  while (true) printRow( $client->scannerGet( $scanner ) );
} catch ( NotFound $nf ) {
  $client->scannerClose( $scanner );
  echo( "Scanner finished\n" );
}

#
# Run some operations on a bunch of rows.
#
for ($e=100; $e>=0; $e--) {

  # format row keys as "00000" to "00100"
  $row = str_pad( $e, 5, '0', STR_PAD_LEFT );

  $mutations = array(
    new Mutation( array(
      'column' => 'unused:',
      'value' => "DELETE_ME"
    ) ),
  );
  $client->mutateRow( $t, $row, $mutations);
  printRow( $client->getRow( $t, $row ));
  $client->deleteAllRow( $t, $row );

  $mutations = array(
    new Mutation( array(
      'column' => 'entry:num',
      'value' => "0"
    ) ),
    new Mutation( array(
      'column' => 'entry:foo',
      'value' => "FOO"
    ) ),
  );
  $client->mutateRow( $t, $row, $mutations );
  printRow( $client->getRow( $t, $row ));

  $mutations = array(
    new Mutation( array(
      'column' => 'entry:foo',
      'isDelete' => 1
    ) ),
    new Mutation( array(
      'column' => 'entry:num',
      'value' => '-1'
    ) ),
  );
  $client->mutateRow( $t, $row, $mutations );
  printRow( $client->getRow( $t, $row ) );

  $mutations = array(
    new Mutation( array(
      'column' => "entry:num",
      'value' => $e
    ) ),
    new Mutation( array(
      'column' => "entry:sqr",
      'value' => $e * $e
    ) ),
  );
  $client->mutateRow( $t, $row, $mutations );
  printRow( $client->getRow( $t, $row ));
  
  $mutations = array(
    new Mutation( array(
      'column' => 'entry:num',
      'value' => '-999'
    ) ),
    new Mutation( array(
      'column' => 'entry:sqr',
      'isDelete' => 1
    ) ),
  );
  $client->mutateRowTs( $t, $row, $mutations, 1 ); # shouldn't override latest
  printRow( $client->getRow( $t, $row ) );

  $versions = $client->getVer( $t, $row, "entry:num", 10 );
  echo( "row: {$row}, values: \n" );
  foreach ( $versions as $v ) echo( "  {$v->value};\n" );
  
  try {
    $client->get( $t, $row, "entry:foo");
    throw new Exception ( "shouldn't get here! " );
  } catch ( NotFound $nf ) {
    # blank
  }

}

$columns = array();
foreach ( $client->getColumnDescriptors($t) as $col=>$desc ) {
  echo("column with name: {$desc->name}\n");
  $columns[] = $desc->name.":";
}

echo( "Starting scanner...\n" );
$scanner = $client->scannerOpenWithStop( $t, "00020", "00040", $columns );
try {
  while (true) printRow( $client->scannerGet( $scanner ) );
} catch ( NotFound $nf ) {
  $client->scannerClose( $scanner );
  echo( "Scanner finished\n" );
}
  
$transport->close();

?>
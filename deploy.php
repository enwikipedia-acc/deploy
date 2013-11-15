<?php

	require_once ("config.inc.php");
	
	$revision = isset( $_GET['r'] ) ? $_GET['r'] : '';
	if( $revision == '' ) {
		echo("Please specify a revision");
		die;
	}
	
	$key = isset( $_GET['k'] ) ? $_GET['k'] : '';
	if( $key == '' ) {
		echo("Please specify a key");
		die;		
	}
	
	if( md5( md5($revision) . $apiDeployPassword ) != $key ) {
		echo("Invalid key.");
		die;
	}
	
	$output = array();
	exec( './deploy.sh ' . $revision . ' 2>&1', $output );
	
	foreach( $output as $line )
	{
		echo $line . "\n";
	}
	
	die;
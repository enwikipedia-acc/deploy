<?php

	require_once ("config.inc.php");
	
	$ignorelist = array(
		"Fetching origin",
		"Fetching RileyHuntley",
		"Fetching stwalkerster",
		"Fetching FunPika",
		"Fetching JohnFLewis",
		"Fetching cyberpower678",
		"You are not currently on a branch, so I cannot use any",
		"'branch.<branchname>.merge' in your configuration file.",
		"Please specify which remote branch you want to use on the command",
		"line and try again (e.g. 'git pull <repository> <refspec>').",
		"See git-pull(1) for details",
	);
	
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
		if(! in_array( $line, $ignorelist ) )
		{
			echo $line . "\n";
		}
	}
	
	die;
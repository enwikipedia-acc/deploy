<?php

	require_once ("config.inc.php");
	
	$ignorelist = array(
		"Fetching origin",
		"Fetching RileyHuntley",
		"Fetching stwalkerster",
		"Fetching FunPika",
		"Fetching JohnFLewis",
		"Fetching cyberpower678",
		"Fetching t13",
		"Fetching manishearth",
		"Fetching mrb",
		"Fetching theo",
		"You are not currently on a branch, so I cannot use any",
		"'branch.<branchname>.merge' in your configuration file.",
		"Please specify which remote branch you want to use on the command",
		"line and try again (e.g. 'git pull <repository> <refspec>').",
		"See git-pull(1) for details.",
		"You are in 'detached HEAD' state. You can look around, make experimental",
		"changes and commit them, and you can discard any commits you make in this",
		"state without impacting any branches by performing another checkout.",
		"If you want to create a new branch to retain commits you create, you may",
		"do so (now or later) by using -b with the checkout command again. Example:",
		"  git checkout -b new_branch_name",
		"Please specify which branch you want to merge with on the command",
		"Submodule 'lib/bootstrap-sortable' () registered for path 'lib/bootstrap-sortable'",
		"Submodule 'lib/password_compat' () registered for path 'lib/password_compat'",
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
	exec( './deploy.sh ' . escapeshellarg($revision) . ' 2>&1', $output );
	
	foreach( $output as $line )
	{
		if(! in_array( $line, $ignorelist ) )
		{
			echo $line . "\n";
		}
	}
	
	die;

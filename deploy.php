<?php
	require_once ("config.inc.php");
	
	$ignorelist = array(
		"Fetching origin",
		"Fetching RileyHuntley",
		"Fetching stwalkerster",
		"Fetching stw",
		"Fetching FunPika",
		"Fetching JohnFLewis",
		"Fetching cyberpower678",
		"Fetching t13",
		"Fetching manishearth",
		"Fetching mrb",
		"Fetching mdaniels5757",
		"Fetching theo",
		"Fetching fastlizard4",
		"Fetching methecooldude",
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
		"Submodule 'lib/mediawiki-extensions-OAuth' () registered for path 'lib/mediawiki-extensions-OAuth'",
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
	
	
	// get the latest stuff from the remotes.
	$fetchOutput = array();
	exec( './fetch.sh', $fetchOutput );
	foreach( $fetchOutput as $line )
	{
		if(! in_array( $line, $ignorelist ) )
		{
			echo $line . "\n";
		}
	}

	$found = false;
	$revlist = array();
	exec( './revlist.sh 2>&1', $revlist );
	foreach( $revlist as $rev )
	{
		if(trim($rev) == $revision)
		{
			$found = true;
			break;
		}
	}
	
	if(!$found)
	{
		echo("Revision not found. Please use entire SHA1 or remote branch format (eg. origin/master)");
		die;
	}

    echo "Running deployment...\n";

	$output = array();
	exec( './deploy.sh ' . escapeshellarg($revision) . ' 2>&1', $output );


    $fileName = uniqid('logs/') . '.log';
    file_put_contents($fileName, implode("\n", $output));

    echo "Deployment complete. Please review the deployment log at https://accounts-dev.wmflabs.org/deploy/${fileName}\n";


    die;

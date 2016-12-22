<?php

	/*
		
		Google keyword rank checker
		
		This is a keyword rank checking script, helpful for those who are always tracking their keywords ranking.

		How to use the script:
			script_path/scriptname.php?keywords=mobile,phone,android&search=whatmobile

		In above example, the script will search all 3 keywords "mobile", "phone" & "android" at Google.com and match the URL "whatmobile" with each result that individual search produced; if a match is found, it is later displayed in a bootstrap table.
		
		Author Name:	Janib Soomro
		Author Email:	janib4all@gmail.com
		Creation date:	20th Dec. 2016
	
	*/
	
	if (!isset($_GET['keywords']) && !isset($_GET['keywords'])) {
		echo	'<h2>How to use the script!</h2>';
		echo	basename($_SERVER['PHP_SELF']) . '?keywords=keyword#1,keyword#2&search=search_term';
		echo	'<br>';
		die();
	}
	
	require_once('class.load.php');

	$keywords	=	$_GET['keywords'];
	$kwdarray	=	explode(',', $keywords);
	$kwdcount	=	count($kwdarray);
	$srcterm	=	$_GET['search'];

	echo	'<head>';
	echo	'	<title>Bootstrap Example</title>';
	echo	'	<meta charset="utf-8">';
	echo	'	<meta name="viewport" content="width=device-width, initial-scale=1">';
	echo	'	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
	echo	'	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	echo	'	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
	echo	'</head>';
	echo	'<body>';
	echo	'	<div class="container">';
	echo	'		<table class="table table-hover">';
	echo	'			<thead>';
	echo	'				<tr>';
	echo	'					<th>Keyword</th>';
	echo	'					<th>Position</th>';
	echo	'					<th>URL</th>';
	echo	'				</tr>';
	echo	'			</thead>';
	echo	'			<tbody>';

		$fetch		=	new scrap();
		for ($kwdloop = 0; $kwdloop < $kwdcount; $kwdloop++) {
			echo			$fetch->loadpage($kwdarray[$kwdloop], $srcterm);
		}

	echo	'			</tbody>';
	echo	'		</table>';
	echo	'	</div>';
	echo	'</body>';
	echo	'</html>';
	
?>

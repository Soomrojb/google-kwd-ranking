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
		Last Modified:	26th Apr. 2017
		
		Version # 2: Customized.php
	
	*/
	
	if (!isset($_GET['keywords']) && !isset($_GET['keywords'])) {
		echo	'<h2>How to use the script!</h2>';
		echo	basename($_SERVER['PHP_SELF']) . '?keywords=keyword#1,keyword#2&search=search_term';
		echo	'<br>';
		die();
	}
	
	require_once('class.load.v2.php');
	require_once('class.database.php');
	$DBase		=	new DTbase();
	$Crawler	=	new Crawler();
	
	$keywords	=	$_GET['keywords'];
	$website	=	$_GET['search'];
	$kwdarray	=	explode(',', $keywords);

	foreach($kwdarray as $keyword) {
		$KwdID	=	$DBase->getkwdid($keyword);
		$SrchRc	=	$Crawler->LoadPage($keyword, $website);
		
		if ($SrchRc) {
			$DBase->UpdateRecs($KwdID, $SrchRc[0][1]);
		} else {
			$DBase->UpdateRecs($KwdID, '0');
		}
	}

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
	echo	"					<th>Keywords</th>";
	
		for ($DaysLoop = 0; $DaysLoop < 5; $DaysLoop++) {
			$curDate	=	date("Y-m-d", strtotime("-$DaysLoop day"));
			echo	"			<th>$curDate</th>";
		}

	echo	'			</thead>';
	echo	'			<tbody>';
	
		foreach($kwdarray as $keyword) {
			echo	'				<tr>';
			echo	"					<td>$keyword</td>";
			for ($DaysLoop = 0; $DaysLoop < 5; $DaysLoop++) {
				$curDate	=	date("Y-m-d", strtotime("-$DaysLoop day"));
				echo	"			<td>" . $DBase->ShowRecs($curDate, $keyword) . "</td>";
			}
			echo	'				</tr>';
		}

	echo	'			</tbody>';
	echo	'		</table>';
	echo	'	</div>';
	echo	'</body>';
	echo	'</html>';

?>

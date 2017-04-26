<?php

	class DTbase {

		//	Database Array
		public	$dbCreds	=	array(
									'host'		=>	'localhost',
									'dbuser'	=>	'admin',
									'dbpass'	=>	'admin$',
									'dbname'	=>	'googlekwds',
									'tables'	=>	array(
														'keywords'	=>	'keywords',
														'ranking'	=>	'ranking'
													)
								);

		//	General Purpose Variables
		public	$Connection;
		
		function __construct() {
			$this->connect_database();
		}

		public function connect_database(){
			$this->Connection	=	mysqli_connect($this->dbCreds['host'], $this->dbCreds['dbuser'], $this->dbCreds['dbpass']);
			if (!$this->Connection) {
					echo	"Error connecting to database!";
				} else {
					var_dump($this->Connection);
					echo '<br/>';
					$status	=	mysqli_select_db($this->Connection, $this->dbCreds['dbname']);
					var_dump($status);
					echo '<br/>';
						if(!$status){
							echo	"Error accessing the database!";
						} else {
							//	Database successfully connected!
						}
				}
		}

		public function test($mykeyword) {
			echo	'<br/>test ok!<br/>';
			$kwdtable	=	$this->dbCreds['tables']['keywords'];
			$SqlQry		=	"SELECT * FROM `$kwdtable` WHERE `keyword` = '$mykeyword'";
			print_r($SqlQry);
			$Query		=	mysqli_query($this->Connection, $SqlQry);
			if (!$Query) {
				echo	"Error accessing 'keywords' table!";
				die();
			} else {
				$rowcount	=	mysqli_num_rows($Query);
				if ($rowcount != 0) {
					echo	'rows more<br/>';
				} else {
					$AddRc	=	"INSERT INTO `$kwdtable` (`keyword`) VALUES ('$mykeyword')";
					$AddQr	=	mysqli_query($this->Connection, $AddRc);
				}
			}
		}
		
		public function getkwdid($keyword) {
			if ($this->checkkwdid($keyword) == 0) {
				$this->addkeyword($keyword);
			}
			
			return $this->checkkwdid($keyword);
		}

		public function addkeyword($keyword) {
			$kwdtable	=	$this->dbCreds['tables']['keywords'];
			$AddRecord	=	"INSERT INTO `$kwdtable` (`keyword`) VALUES ('$keyword')";
			$AddQuery	=	mysqli_query($this->Connection, $AddRecord);
		}
		
		public function checkkwdid($keyword) {
			$kwdtable	=	$this->dbCreds['tables']['keywords'];
			$tableid	=	0;
			$SqlQry		=	"SELECT * FROM `$kwdtable` WHERE `keyword` = '$keyword'";
			$Query		=	mysqli_query($this->Connection, $SqlQry);
			if (!$Query) {
				echo	"Error accessing 'keywords' table!";
				die();
			} else {
				$Reslt	=	mysqli_fetch_assoc($Query);
				if ($Reslt) {
					$tableid	=	$Reslt['serial'];
				}
			}
			
			return	$tableid;
		}
		
		public function UpdateRecs($tabID, $position) {
			$kwdtable	=	$this->dbCreds['tables']['ranking'];
			$curDate	=	date("Y-m-d");
			$SqlQry		=	"INSERT INTO `$kwdtable` (`date`, `kwdref`, `position`) VALUES ('$curDate', '$tabID', '$position')";
			$Query		=	mysqli_query($this->Connection, $SqlQry);
			if (!$Query) {
				echo	"Error accessing 'ranking' table #!";
				die();
			}
		}
		
		public function ShowRecs($date, $keyword) {
			$kwdtable	=	$this->dbCreds['tables']['ranking'];
			$kwdID		=	$this->checkkwdid($keyword);
			$position	=	0;
			$SqlQry		=	"SELECT * from `$kwdtable` WHERE `date` = '$date' AND `kwdref` = '$kwdID' ORDER by `timestamp` DESC limit 1";
			$Query		=	mysqli_query($this->Connection, $SqlQry);
			if (!$Query) {
				echo	"Error accessing 'ranking' table !<br/>";
				die();
			} else {
				$Reslt	=	mysqli_fetch_assoc($Query);
				if ($Reslt) {
					$position	=	$Reslt['position'];
				}
			}
			
			return	$position;
		}

	}

?>
<?php

	class scrap {
		
		public	$gsrc_url	=	'https://www.google.com/search?num=100&q=';
		public	$cHeadres	=	array(
							'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
							'Accept-Language: en-US,en;q=0.5',
							'Connection: Keep-Alive',
							'Pragma: no-cache',
							'Cache-Control: no-cache'
						);

		function __construct() {
			//	echo	'Just checking!';
		}
		

		function dlPage($href) {
			global	$cHeadres;

			$ch	=	curl_init();
			if($ch){
				curl_setopt($ch, CURLOPT_URL, $href);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $this->cHeadres);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
				$str = curl_exec($ch);
				curl_close($ch);

				$dom = new simple_html_dom();
				$dom->load($str);
				return $dom;
			}
		}

		function loadpage($kwd, $srcterm) {
			
			include_once	"simple_html_dom.php";
			
			$finallink	=	$this->gsrc_url . urlencode($kwd);

			//	Two methods for loading the page
			$maincode	=	file_get_html($finallink);
			//$maincode	=	$this->dlPage($finallink);
			
			//	View page code for debugging
			//	echo	$maincode;

			$counter	=	0;
			$resarray	=	array();
			foreach ($maincode->find('h3[class=r] a') as $post) {
				if (strpos($post->href, $srcterm) !== false) {
					array_push($resarray, [$kwd,$counter,$post->href]);
				}
				$counter++;
			}
			
			if ($resarray) {
					for ($kwdloop = 0; $kwdloop < count($resarray); $kwdloop++) {
						echo	'<tr>';
						echo	'<td>' . urldecode($resarray[$kwdloop][0]) . '</td>';
						echo	'<td>' . $resarray[$kwdloop][1] . '</td>';
						echo	'<td>' . $resarray[$kwdloop][2] . '</td>';
						echo	'</tr>';
					}
			} else {
					echo	'<tr>';
					echo	'<td>' . urldecode($kwd) . '</td>';
					echo	'<td>0</td>';
					echo	'<td>Zero matches found!</td>';
					echo	'</tr>';
			}
		}
	}

?>
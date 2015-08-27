<?php
	//e.g php olx.php "1" "500" "mobile-phones-tablets" -->only one ( 1 ) category
	//or php olx.php "1" "100" --> loops all olx top categories
	
	$categories = 	[					
					'computers',
					'mobile-phones-tablets',
					'clothing-accessories',
					'pets-animals',
					'books-sports-hobbies',
					'consumer-electronics',
					'home-furniture',
					'baby-stuff-toys',
					'cars-automotives',
					'real-estate',
					'services',
					];
	
	if( isset( $argv[1] ) ) $start_page = $argv[1];
	else $start_page = 1;

	if( $start_page < 1 ) $start_page = 1;//cannot be less than 1 for start_page

	if( isset( $argv[2] ) ) $last_page = $argv[2];
	else $last_page = 10;
	
	if( isset( $argv[3] ) ){
		$categories = [];
		$categories[] = $argv[3];
	}
	else $categories[] = "mobile-phones-tablets";
	
	
	foreach( $categories as $olx_category ){				
		echo "first_page: $start_page - last_page: $last_page - olx_category: $olx_category \n";
		echo "starting in 5 secs...\n\n\n";
		sleep(5);
		
		require "vendor/autoload.php";
		$count_already = $count_saved = 0;
		$db_error = true;
		while( $db_error == true ){
			try{
				$db = new PDO('mysql:host=sap.withcenter.com;dbname=sapcms2', "sapcms2", "Wcinc0453224133~h8");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db_error = false;
			}catch( Exception $e ) {
				echo "$e \n\n";
				$db_error = true;
			}
		}

		for( $i =$start_page; $i<=$last_page; $i ++ ) {	
			$url = "http://olx.ph/$olx_category/?page=$i";
			echo "url: $url";
			
			//per page sleep
			$rand_sleep = 10 + rand(30,60);
			sleep( $rand_sleep  );
			
			$body = get_page($url);
			$arr = explode('<ul class="gallerywide clr normal " id="gallerywide">', $body, 2);
			$arr = explode('<div class="pager rel clr">', $arr[1], 2);
			$count = preg_match_all("/href=\"(.*)\"/", $arr[0], $ms);

			$data = [];
			foreach( $ms[0] as $m ){
				if( strpos( $m, "data-statkey" ) !== false ) continue;
				if( strpos( $m, "title=" ) !== false ) continue;
				
				$replaced = str_replace( 'href=', '', $m );
				$replaced = str_replace( '"', '', $replaced );
				$replaced = substr( $replaced, 0, strpos( $replaced, "?p") );
				$data[] = $replaced;
			}
			echo "\n\n";
			save_pages_into_database( $data, $olx_category );
			//save_pages_into_database($ms[1]);
		}	
	}
	function save_pages_into_database($urls, $keyword) {
		global $db, $count_already, $count_saved;
		foreach($urls as $url) {
			//$url = "http://sulit.ph/$url";
			
			//echo "\n\n---URL: $url---\n\n";		
			$db_error = true;
			while( $db_error == true ){
				try{
					$db = new PDO('mysql:host=sap.withcenter.com;dbname=sapcms2', "sapcms2", "Wcinc0453224133~h8");
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db_error = false;
				}catch( Exception $e ) {
					echo "$e \n\n";
					$db_error = true;
				}
			}
			
			$result = $db->query("SELECT idx from page_number_extract WHERE url='$url'");
			$row = $result->fetch(PDO::FETCH_ASSOC);
			if ( $row ) {
				$count_already ++;
				echo " $url\nAlready saved as idx[ $row[idx] ]. No downloading: $count_already\n";
			}
			else {
				$body = get_page($url);
				$body = addslashes($body);
				$stamp = time();
				$q = "INSERT INTO page_number_extract (origin, keyword, stamp, url, content) VALUES ('olx.ph', '$keyword', '$stamp', '$url', '$body')";
				$db->query($q);
				$count_saved ++;
				//per item sleep
				$rand_sleep = 5 + rand(1,15);
				echo " $url\nSaved: $count_saved";
				echo " --> Sleeping for $rand_sleep secs \n";								
				sleep( $rand_sleep );				
			}						
		}
	}
	
	function get_page($url) {
		$client = new GuzzleHttp\Client();	
		$response = $client->get($url, [
			'headers'         => [
				'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
			],
		]);

		// @todo set user-agent. set random time interval.

		$result = $client->get($url);
		$body = $result->getBody();
		return $body;
	}
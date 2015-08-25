<?php
	require "vendor/autoload.php";

	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 120);
	//global $db;
	//$db = Database::load();
	$db = new PDO('mysql:host=sap.withcenter.com;dbname=sapcms2', "sapcms2", "Wcinc0453224133~h8");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$ebay_categories =	[
					"20081"=>"Antiques",
					"550"=>"Art",
					"2984"=>"Baby",
					"267"=>"Books",
					"12576"=>"Business Industrial",
					"625"=>"Cameras Photo",
					"11450"=>"Clothing, Shoes Accessories",
					"11116"=>"Coins Currency",
					"1"=>"Collectables",
					"58058"=>"Computers Tablets",
					"293"=>"Consumer Electronics",
					"14339"=>"Crafts",
					"172008"=>"Deal Vouchers Gift Cards",
					"11232"=>"DVD Movies",
					"45100"=>"Entertainment Memorabilia",
					"26395"=>"Health Beauty",
					"11700"=>"Home Garden",
					"281"=>"Jewellery Watches",
					"15032"=>"Mobile Phones Accessories",
					"11233"=>"Music",
					"173484"=>"Musical Instruments",
					"870"=>"Pottery Glass",
					//"10542"=>"Real Estate",
					"382"=>"Sporting Goods",
					"64482"=>"Sporting Memorabilia",
					"260"=>"Stamps",
					"220"=>"Toys Hobbies",
					"6028"=>"Vehicle Parts Accessories",
					"9800"=>"Vehicles",
					"1249"=>"Video Games",
					"99"=>"Everything Else"
					];
	
	if( isset( $argv[1] ) ) $start_page = $argv[1];
	else $start_page = 1;

	if( $start_page < 1 ) $start_page = 2;//cannot be less than 1 for start_page

	if( isset( $argv[2] ) ) $last_page = $argv[2];
	else $last_page = 10;
	
	//cat number/id
	if( isset( $argv[3] ) ) {
		if( empty( $ebay_categories[ $argv[3] ] ) ){
			echo "Invalid category ID [ $argv[3] ] see:\n";
			print_r( $ebay_categories );
			echo "\nExiting...\n";
			exit;
		}
		$categories = [ $argv[3] => $ebay_categories[ $argv[3] ] ];
	}
	else $categories = [ "10542"=>"Real Estate" ];
	
	foreach( $categories as $k => $v ){
		/*
		//located only in PH
		&LH_SubLocation=1 //only show location chekc box
		&_fsradio2=%26LH_LocatedIn%3D1 //located only in
		&_salic=162 //located in philippines

		&LH_SubLocation=1&_fsradio2=%26LH_LocatedIn%3D1&_salic=162



		//avail in PH ( includes other countries that serve PH )
		&LH_SubLocation=1 //only show location chekc box
		&_fsradio2=%26LH_AvailTo%3D1 //located only in
		&_saact=162 //located in philippines

		&LH_SubLocation=1&_fsradio2=%26LH_AvailTo%3D1&_saact=162
		*/
		
		for( $i =$start_page; $i<=$last_page; $i ++ ) {	
			$url = "http://www.ebay.ph/sch/i.html?&_sacat=$k&_pgn=$i";
			echo $url."\n\n";
			$body = get_page( $url );			
			
			$arr = explode('<w-root id="w1-1">', $body, 2);
			$arr = explode('</w-root>', $arr[1], 2);
			
			$count = preg_match_all("/href=\"(.*?)\"/", $arr[0], $ms);			
			
			//$urls = array_unique( $ms[1] );
			
			$urls = array_unique( $ms[1] );
			
			save_pages_into_database( $urls, $v );
			sleep(5);
		}
	}
	
	function save_pages_into_database( $urls, $category ){	
		//$db = Database::load();
		global $db;
	
		foreach( $urls as $url ){
			$q = "SELECT idx,url from page_number_extract WHERE url='$url'";
			//$res = $db->row( 'page_number_extract', "url = '$url'" );
			$result = $db->query($q);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			if( empty( $row ) ){	
				echo "Inserting: $url\n";				
				$origin = 'ebay.ph';
				$keyword = $category;
				$stamp = time();
				$url = $url;
				$body = get_page( $url );
				$body = addslashes($body);
				
				$q = "INSERT INTO page_number_extract (origin, keyword, stamp, url, content) VALUES ('$origin', '$keyword', '$stamp', '$url', '$body')";
				$db->query($q);
				//$db->insert('page_number_extract', $data);
				$rand_sleep = 10 + rand(1,30);
				sleep( $rand_sleep );
			}
			else{
				echo "Exists: $url - skipping...\n";
			}		
		}
	}
	
	
	function get_page($url) {
		try 
		{
			$client = new GuzzleHttp\Client();	
			$response = $client->get($url, [
				'headers'         => [
					'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
				],
			]);
		}
		catch( Exception $e ) {
			// do nothing
			return null;
		}
		
		$body = $response->getBody()->getContents();
		$body = utf8_decode( $body );
		$body = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
		return $body;	
	}
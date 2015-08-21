<?php
	use sap\src\Database;
	//$db = Database::load();
	
	$ebay_categories =	[
					//"20081"=>"Antiques",
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
					"10542"=>"Real Estate",
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

	if( $start_page < 1 ) $start_page = 1;//cannot be less than 1 for start_page

	if( isset( $argv[2] ) ) $last_page = $argv[2];
	else $last_page = 5;
	
	if( isset( $argv[3] ) ) $categories[] = $argv[3];
	else $categories = [ 11450=>"Clothing, Shoes Accessories" ];
	
	//print_r( $argv );exit;	
	foreach( $categories as $k => $v ){
		/*echo "first_page: $start_page - last_page: $last_page - category: $v \n";
		echo "starting in 5 secs...\n\n\n";
		sleep(5);
		exit;*/
		
		//&LH_SubLocation = 1 //only show location chekc box
		//&_fsradio2=%26LH_LocatedIn%3D1 //located only in
		//&_salic=162 //located in philippines
		
		for( $i =$start_page; $i<=$last_page; $i ++ ) {	
			$url = "http://www.ebay.ph/sch/i.html?&_sacat=$k&_pgn=$i&LH_SubLocation=1&_salic=162&_fsradio2=%26LH_LocatedIn%3D1";
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
		$db = Database::load();
	
		foreach( $urls as $url ){
			$res = $db->row( 'page_number_extract', "url = '$url'" );
			if( empty( $res ) ){	
				$data = [];
				$data['origin'] = 'ebay.ph';
				$data['keyword'] = $category;
				$data['stamp'] = time();
				$data['url'] = $url;
				$data['content'] = get_page( $url );			
				$db->insert('page_number_extract', $data);
				echo "Insert Success: $url\n";
				sleep( 5 );
			}
			else{
				echo "Exists: $url - skipping...\n";
			}			
		}
	}
	
	
	function get_page($url) {
		$client = new GuzzleHttp\Client();	
		try {
			$response = $client->get($url, [
				'headers'         => [
					'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
				],
			]);
		} catch (ClientErrorResponseException $exception) {
			$e = $exception->getResponse()->getBody(true);
			
			print_r( $e );exit;
		}
		
		
		return $response->getBody()->getContents();		
	}
	
	/*function get_page($url) {
		$client = new GuzzleHttp\Client();
		//$jar = new \GuzzleHttp\Cookie\CookieJar;

		// @todo set user-agent. set random time interval.

		$result = $client->get($url
			,
			[
				'cookies' => $jar,
				'headers'=> ['User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36']
			]
		);
		$body = $result->getBody();
		
		return $body;
	}*/
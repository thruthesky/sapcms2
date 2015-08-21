<?php	
	//urls with numbers...
	use sap\src\Database;
	$db = Database::load();
	
	$urls = [];
	/*
	$urls[] = "http://www.ebay.ph/itm/Casio-G-Shock-G-Aviation-Gravity-Defier-GA1000-4B-Twin-Sensor-Digital-Compass/321568935438?hash=item4adf008e0e";
	$urls[] = "http://www.ebay.ph/itm/1-8-meters-Hdmi-Cable-1-4-version/221855784064?hash=item33a7a29c80";
	$urls[] = "http://www.ebay.ph/itm/Video-Connector-Adaptor/371417026482?hash=item567a2e0fb2";
	$urls[] = "http://www.ebay.ph/itm/4-IN-1-USB-CABLE-Charger-P300-only/262011915734?hash=item3d01208dd6";
	$urls[] = "http://www.ebay.ph/itm/DIY-Cebu-Mother-of-Pearl-Capiz-Pendant-Necklace-not-included-12010277-/351486624604?hash=item51d63c435c";
	$urls[] = "http://www.ebay.ph/itm/Seductive-Victoria-Multicolor-Dangling-Earrings-3pairs-5556-/371417129748?hash=item567a2fa314";
	*/
	
	$urls[] = "http://www.ebay.ph/itm/Authentic-18k-Saudi-Gold-Omega-Flat-Necklace-100-Pawnable-/171896289896?hash=item2805d13a68";
	
	//echo get_page( $urls[0] );exit;
	foreach( $urls as $url ){	
		$res = $db->row( 'page_number_extract', "url = '$url'" );
		if( empty( $res ) ){	
			$data = [];
			$data['origin'] = 'ebay.ph';
			//$data['keyword'] = $category;
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
		
		
		$body = $response->getBody()->getContents();
		$body = utf8_decode( $body );
		$body = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body);
		return $body;
	}
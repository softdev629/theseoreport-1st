<?php
	session_start();

	//CONFIGURATION SETTINGS START
	//$root_directory = "/home2/theseoreports/public_html/login/";
	$root_directory = "public_html/login/";

	//DATABASE CREDENTIALS
	$database_name = "theseore_reportsl_projects";
	$database_user = "theseore_myusr32";
	$database_user_password = 'QEV3}ybRWN~b'; 
	$database_host = "localhost";

	//SUPPORTED ENDPOINTS
	$endpoints = [
		'product-purchase',
		'cancellation',
		'login',
		'logout'
	];

	$publicKey = <<<EOD
	-----BEGIN PUBLIC KEY-----
	MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqcJZvV3x8dC3q0Rpsu0M
	Qby7z4k+iwKHpxV+rlSa7+jpr/xQknlH7ZrMmlcONCteaIZtk92g+QTOnchE9rIC
	06TSoaLcpHpaoIpoeALZrgnIwfMMi/G0gRJ5xjuv6sc3QHsQVGf43ClOISPPoJ4t
	91lPX/Gm+PvGHDonMpJZdFZyZRkCqBS/rHur+rwnbn1dcFI6iwzyFrQPMRpHx58W
	vgFDy9VsCKypMmv5X6TF4KRMfZRmB+avBRWzp9tficzF9hQm7aekyYstUMm76jwD
	uC4SYhRy1dsBQ0S8SgcNQR4hBsx5UxERE8uknBW1TtvoyaqMp/HNWZRCNnuDNcfH
	/QIDAQAB
	-----END PUBLIC KEY-----
	
	EOD;

	/*require_once('public_html/login/vendor/firebase/php-jwt');
	require_once('public_html/login/vendor/paragonie/sodium_compat');
	require_once('public_html/login/vendor/oauth2-client');*/
	
	#composer require firebase/php-jwt;
	#composer require paragonie/sodium_compat;
	#composer require league/oauth2-client;
	
	//CONFIGURATION SETTINGS END

	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;

	//CHECKING TO SEE IF REQUESTED ENDPOINT IS VALID
    $endpoint = $_GET['endpoint'] ?? "";
    $payload = file_get_contents('php://input');
    file_put_contents("payload.txt", $payload);

    if(!empty($endpoint) && in_array($endpoint, $endpoints)){
    	//LOGIN & LOGOUT SECTION
    	if(empty($payload)){
    		require_once $root_directory . 'vendor/autoload.php';
			

    		if($endpoint == "login"){
    			$provider = new \League\OAuth2\Client\Provider\Vendasta([
				    'clientId'                => '6e5b6acc-2dc0-46dd-8c19-5b0782199413',
				    'clientSecret'            => 'NChiZPEjZjxa6cZifCqjxf47HUbqE73PIaPvdhI0er',
				    'redirectUri'             => 'https://theseoreports.com/login/dashboard.php'
				]);

				if (!isset($_GET['code'])) {
					$provider->setScopes(["openid profile"]);
				    $authorizationUrl = $provider->getAuthorizationUrl();

				    $_SESSION['oauth2state'] = $provider->getState();

				    if(isset($_GET['accountid'])){
				    	header('Location: ' . $authorizationUrl . "&account_id=" . $_GET['accountid']);
				    }

				    exit;

				// Check given state against previously stored one to mitigate CSRF attack
				} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
				    if (isset($_SESSION['oauth2state'])) {
				        unset($_SESSION['oauth2state']);
				    }

				    exit;
				} else {
				    try {
				        $accessToken = $provider->getAccessToken('authorization_code', ['code' => $_GET['code']]);

				        // We have an access token, which we may use in authenticated requests against the service provider's API.
				        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
				        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
				        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
				        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

				        $resourceOwner = $provider->getResourceOwner($accessToken);

				        var_export($resourceOwner->toArray());
				        
				    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
				        exit($e->getMessage());
				    }
				}
    		}

    		else if($endpoint == "logout"){

    		}
    	}

    	else if(!empty($payload)){
	    	try {
	    		
				$data = json_decode(json_encode(JWT::decode($payload, new Key($publicKey, 'RS256'))), true);
	    		file_put_contents("data.txt", json_encode($data));
	    	} catch (Exception $e){
	    		
	    	}

	    	if(!empty($data) && in_array($data['iss'], ['Vendasta Marketplace', 'Vendasta Marketplace Test'])){
	    		if($endpoint == "product-purchase"){
		        	$iss = $data['iss'] ?? "";
					$iat = $data['iat'] ?? 0;
					$exp = $data['exp'] ?? 0;

					$account_youtube_url = $data['vendasta.com/marketplace/webhook']['account']['youtube_url'] ?? "";
					$account_call_tracking_number_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['call_tracking_number']) ?? "";
					$account_deleted_flag = $data['vendasta.com/marketplace/webhook']['account']['deleted_flag'] ?? false;
					$account_contact_first_name = $data['vendasta.com/marketplace/webhook']['account']['contact_first_name'] ?? "";
					$account_common_name_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['common_name']) ?? "";
					$account_timezone = $data['vendasta.com/marketplace/webhook']['account']['timezone'] ?? "";
					$account_work_number_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['work_number']) ?? "";
					$account_partner_id = $data['vendasta.com/marketplace/webhook']['account']['partner_id'] ?? "";
					$account_id = $data['vendasta.com/marketplace/webhook']['account']['id'] ?? "";
					$account_city = $data['vendasta.com/marketplace/webhook']['account']['city'] ?? "";
					$account_zip = $data['vendasta.com/marketplace/webhook']['account']['zip'] ?? "";
					$account_market_id = $data['vendasta.com/marketplace/webhook']['account']['market_id'] ?? "";
					$account_twitter_url = $data['vendasta.com/marketplace/webhook']['account']['twitter_url'] ?? "";
					$account_state = $data['vendasta.com/marketplace/webhook']['account']['state'] ?? "";
					$account_company_name = $data['vendasta.com/marketplace/webhook']['account']['company_name'] ?? "";
					$account_latitude = $data['vendasta.com/marketplace/webhook']['account']['latitude'] ?? "";
					$account_foursquare_url = $data['vendasta.com/marketplace/webhook']['account']['foursquare_url'] ?? "";
					$account_service_area_business_flag = $data['vendasta.com/marketplace/webhook']['account']['service_area_business_flag'] ?? false;
					$account_email = $data['vendasta.com/marketplace/webhook']['account']['email'] ?? "";
					$account_tax_ids_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['tax_ids']) ?? "";
					$account_website = $data['vendasta.com/marketplace/webhook']['account']['website'] ?? "";
					$account_rss_url = $data['vendasta.com/marketplace/webhook']['account']['rss_url'] ?? "";
					$account_updated = $data['vendasta.com/marketplace/webhook']['account']['updated'] ?? "";
					$account_tags_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['tags']) ?? "";
					$account_deleted = $data['vendasta.com/marketplace/webhook']['account']['deleted'] ?? "";
					$account_address2 = $data['vendasta.com/marketplace/webhook']['account']['address2'] ?? "";
					$account_fax_number = $data['vendasta.com/marketplace/webhook']['account']['fax_number'] ?? "";
					$account_contact_email = $data['vendasta.com/marketplace/webhook']['account']['contact_email'] ?? "";
					$account_address = $data['vendasta.com/marketplace/webhook']['account']['address'] ?? "";
					$account_seo_category_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['seo_category']) ?? "";
					$account_instagram_url = $data['vendasta.com/marketplace/webhook']['account']['instagram_url'] ?? "";
					$account_key_person_json = json_encode($data['vendasta.com/marketplace/webhook']['account']['key_person']) ?? "";
					$account_facebook_url = $data['vendasta.com/marketplace/webhook']['account']['facebook_url'] ?? "";
					$account_pinterest_url = $data['vendasta.com/marketplace/webhook']['account']['pinterest_url'] ?? "";
					$account_contact_last_name = $data['vendasta.com/marketplace/webhook']['account']['contact_last_name'] ?? "";
					$account_created = $data['vendasta.com/marketplace/webhook']['account']['created'] ?? "";
					$account_country = $data['vendasta.com/marketplace/webhook']['account']['country'] ?? "";
					$account_cell_number = $data['vendasta.com/marketplace/webhook']['account']['cell_number'] ?? "";
					$account_linkedin_url = $data['vendasta.com/marketplace/webhook']['account']['linkedin_url'] ?? "";
					$account_longitude = $data['vendasta.com/marketplace/webhook']['account']['longitude'] ?? "";
					$account_sales_person_id = $data['vendasta.com/marketplace/webhook']['account']['sales_person_id'] ?? "";
					$account_googleplus_url = $data['vendasta.com/marketplace/webhook']['account']['googleplus_url'] ?? "";
					$account_customer_identifier = $data['vendasta.com/marketplace/webhook']['account']['customer_identifier'] ?? "";

					$order_form_json = json_encode($data['vendasta.com/marketplace/webhook']['order_form']) ?? "";
					$market_id = $data['vendasta.com/marketplace/webhook']['market_id'] ?? "";
					$app_id = $data['vendasta.com/marketplace/webhook']['app_id'] ?? "";
					$action = $data['vendasta.com/marketplace/webhook']['action'] ?? "";
					$order_form_submission_id = $data['vendasta.com/marketplace/webhook']['order_form_submission_id'] ?? "";
					$activation_id = $data['vendasta.com/marketplace/webhook']['activation_id'] ?? "";
					$deactivation_time = $data['vendasta.com/marketplace/webhook']['deactivation_time'] ?? "";
					$webhook_id = $data['vendasta.com/marketplace/webhook']['webhook_id'] ?? "";
					$variable_price_json = json_encode($data['vendasta.com/marketplace/webhook']['variable_price']) ?? "";
					$activation_time = $data['vendasta.com/marketplace/webhook']['activation_time'] ?? "";
					$partner_id = $data['vendasta.com/marketplace/webhook']['partner_id'] ?? "";

					$statement = get_connection()->prepare("INSERT INTO `vendasta_product_purchase_requests`(`iss`, `iat`, `exp`, `account_youtube_url`, `account_call_tracking_number_json`, `account_deleted_flag`, `account_contact_first_name`, `account_common_name_json`, `account_timezone`, `account_work_number_json`, `account_partner_id`, `account_id`, `account_city`, `account_zip`, `account_market_id`, `account_twitter_url`, `account_state`, `account_company_name`, `account_latitude`, `account_foursquare_url`, `account_service_area_business_flag`, `account_email`, `account_tax_ids_json`, `account_website`, `account_rss_url`, `account_updated`, `account_tags_json`, `account_deleted`, `account_address2`, `account_fax_number`, `account_contact_email`, `account_address`, `account_seo_category_json`, `account_instagram_url`, `account_key_person_json`, `account_facebook_url`, `account_pinterest_url`, `account_contact_last_name`, `account_created`, `account_country`, `account_cell_number`, `account_linkedin_url`, `account_longitude`, `account_sales_person_id`, `account_googleplus_url`, `account_customer_identifier`, `order_form_json`, `market_id`, `app_id`, `action`, `order_form_submission_id`, `activation_id`, `deactivation_time`, `webhook_id`, `variable_price`, `activation_time`, `partner_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

					$statement->execute([$iss, $iat, $exp, $account_youtube_url, $account_call_tracking_number_json, $account_deleted_flag, $account_contact_first_name, $account_common_name_json, $account_timezone, $account_work_number_json, $account_partner_id, $account_id, $account_city, $account_zip, $account_market_id, $account_twitter_url, $account_state, $account_company_name, $account_latitude, $account_foursquare_url, $account_service_area_business_flag, $account_email, $account_tax_ids_json, $account_website, $account_rss_url, $account_updated, $account_tags_json, $account_deleted, $account_address2, $account_fax_number, $account_contact_email, $account_address, $account_seo_category_json, $account_instagram_url, $account_key_person_json, $account_facebook_url, $account_pinterest_url, $account_contact_last_name, $account_created, $account_country, $account_cell_number, $account_linkedin_url, $account_longitude, $account_sales_person_id, $account_googleplus_url, $account_customer_identifier, $order_form_json, $market_id, $app_id, $action, $order_form_submission_id, $activation_id, $deactivation_time, $webhook_id, $variable_price_json, $activation_time, $partner_id]);
		        }

		        else if($endpoint == 'cancellation'){
		        	$iss = $data['iss'] ?? "";
					$iat = $data['iat'] ?? 0;
					$exp = $data['exp'] ?? 0;

					$account_group_id = $data['vendasta.com/marketplace/webhook']['account_group_id'] ?? "";
					$addon_id = $data['vendasta.com/marketplace/webhook']['addon_id'] ?? "";
					$edition_id = $data['vendasta.com/marketplace/webhook']['edition_id'] ?? "";
					$activation_id = $data['vendasta.com/marketplace/webhook']['activation_id'] ?? "";
					$webhook_id = $data['vendasta.com/marketplace/webhook']['webhook_id'] ?? "";
					$action = $data['vendasta.com/marketplace/webhook']['action'] ?? "";
					$activation_time = $data['vendasta.com/marketplace/webhook']['activation_time'] ?? "";
					$cancellation_time = $data['vendasta.com/marketplace/webhook']['cancellation_time'] ?? "";
					$deactivation_time = $data['vendasta.com/marketplace/webhook']['deactivation_time'] ?? "";
					$partner_id = $data['vendasta.com/marketplace/webhook']['partner_id'] ?? "";
					$app_id = $data['vendasta.com/marketplace/webhook']['app_id'] ?? "";
					$vendor_order_id = $data['vendasta.com/marketplace/webhook']['vendor_order_id'] ?? "";
					$cancellation_choices_json = json_encode($data['vendasta.com/marketplace/webhook']['cancellation_choices']) ?? "";
					$cancellation_comment = $data['vendasta.com/marketplace/webhook']['cancellation_comment'] ?? "";

					$statement = get_connection()->prepare("INSERT INTO `vendasta_cancellation_requests`(`account_group_id`, `addon_id`, `edition_id`, `activation_id`, `webhook_id`, `action`, `activation_time`, `cancellation_time`, `deactivation_time`, `partner_id`, `app_id`, `vendor_order_id`, `cancellation_choices_json`, `cancellation_comment`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					
					$statement->execute([$account_group_id, $addon_id, $edition_id, $activation_id, $webhook_id, $action, $activation_time, $cancellation_time, $deactivation_time, $partner_id, $app_id, $vendor_order_id, $cancellation_choices_json, $cancellation_comment]);
		        }
	    	}
	    }
    }

    //FOR GETTING THE DATABASE CONNECTION
	function get_connection(){
		try {
		    $dbh = new PDO("mysql:host=" . $GLOBALS['database_host'] . ";dbname=" . $GLOBALS['database_name'], $GLOBALS['database_user'], $GLOBALS['database_user_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT));
		} catch (PDOException $e) {
		    exit("<center>database connection failure</center>");
		}

		return $dbh;
	}
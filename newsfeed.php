<?php
require_once __DIR__ . '/Facebook/autoload.php';

try {
	
	$fb = new Facebook\Facebook ( [ 
			'app_id' => '242313549478682',
			'app_secret' => 'b4b9216b1bf8dcfce9ba09e529016cc6',
			'default_graph_version' => 'v2.6' 
	] );
	$fb->setDefaultAccessToken ( '242313549478682|VK5mtww9SJBkMaSXLhus4m8Qwec' );
	
	$request = $fb->request ( 'GET', '/weiteraufderleiter/posts', array (
			'fields' => 'created_time,message,link,full_picture,name,description',
			'limit' => 10 
	) );
	$response = $fb->getClient ()->sendRequest ( $request );
	$postsData = $response->getGraphEdge ();
	$messageCount = 0;
	for($i = 0; $i < 10 && $messageCount<3; $i++) {
		$postData = $postsData [$i];
		if (isset ( $postData ['message'] )) {
			$messageCount ++;			
			
			$createdTime = $postData ['created_time'];
			$createdTime->setTimezone ( new DateTimeZone ( 'Europe/Berlin' ) );
			
			echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">';
			echo '<div class="services-box leftReveal news-box">';
// 			echo '<h2 class="mt15 mb20">';
// 			echo 'Effective<br>Communication';
// 			echo '</h2>';
			echo '<p>';

			echo '<h3 class="service-name">';
			echo $postData ['message'];
			echo '</h3>';
			
			echo '<a';
			if (isset ( $postData ['link'] )) {
				echo ' href="';
				echo $postData ['link'];
				echo '" target="_blank"';
			}
			echo '>';
			
			if (isset ( $postData ['name'] )) {
				echo $postData ['name'];
				echo '<br>';
			}
			
			if (isset ( $postData ['full_picture'] )) {
				echo '<img src="';
				echo $postData ['full_picture'];
				echo '" class="img-responsive img-fb-feed">';
			}
						
			if (isset ( $postData ['description'] )) {
				echo $postData ['description'];
			}
			
			
			echo '</a>';
			echo '</p>';
			echo '</div>';
			echo '</div>';
		}
	}
} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage ();
	exit ();
} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage ();
	exit ();
}

?>
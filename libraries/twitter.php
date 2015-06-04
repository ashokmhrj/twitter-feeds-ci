<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'third_party/twitter_lib/twitteroauth.php');

class Twitter {
	public $instance;
	public function __construct(){
		$this->instance = array(
						'consumer_key' => '<consumer-key>',
						'consumer_secret' => '<consumer-secret>',
						'oauth_token' => '<oauth-token>',
						'oauth_token_secret' => '<oauth-token-secret>'
					);
	}

	public function feeds($hashtag = '', $num = 5){
		/*$instance = array(
						'consumer_key' => 'nPFsdxHXe2jInvdIB01WNC9GM',
						'consumer_secret' => '0BWWPv3wSUpxOUDU2sXItPPBw4beavs4etQB40R2EKxozueV5s',
						'oauth_token' => '593642138-K55cDmiPbrdmFB41JuflL325UWmQfm8K4ypzgdFC',
						'oauth_token_secret' => 'DuO4CWOFKfbQoBkJt0l1ZCfz6c9ppKwIyU8UD3reUpU5B'
					);*/
		$url = 'https://api.twitter.com/1.1/search/tweets.json';	// Twitter REST API v1.1 (https://dev.twitter.com/docs/api/1.1)

			$query = array(	'q' => $hashtag,
							'result_type' => 'recent',
							'count' => $num,
						);

			$conn = new TwitterOAuth( $this->instance['consumer_key'], $this->instance['consumer_secret'], $this->instance['oauth_token'], $this->instance['oauth_token_secret'] );

			$content = $conn->get( $url, $query );

			// $content = json_decode( $json );
		
		echo '<ul>';
		
			if ( $content->search_metadata->count > 0 ) {
				foreach( $content->statuses as $status ) {

					// Hyperlink any URLs
					$status->text = preg_replace( '/(http[s]?:\/\/[^\s]*)/i', '<a href="$1">$1</a>', $status->text );	
					// Hyperlink @mentions
					$status->text = preg_replace( '/(^|\s)@([a-z0-9_]+)/i', '$1<a href="https://twitter.com/$2">@$2</a>', $status->text );	
					// Hyperlink #hashes
					$status->text = preg_replace( '/(^|\s)#([a-z0-9_]+)/i', '$1<a href="https://twitter.com/search?q=%23$2&src=hash">#$2</a>', $status->text );	

					echo '<li>';
					echo '<a href="https://twitter.com/' . $status->user->screen_name . '" target="_blank">';
					echo "@{$status->user->screen_name}</a>: " . $status->text;
					echo '</li>';
				}
			} else {
				echo 'No results found.';
			}
		echo "</ul>";

			
	}

}
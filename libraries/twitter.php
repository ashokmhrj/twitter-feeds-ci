<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'third_party/twitter_lib/twitteroauth.php');

class Twitter {
	
	public $instance;
	public $conn;

	public function __construct(){
		$this->instance = array(
						'consumer_key' => '<consumer-key>',
						'consumer_secret' => '<consumer-secret>',
						'oauth_token' => '<oauth-token>',
						'oauth_token_secret' => '<oauth-token-secret>'
					);
		
		$this->conn = new TwitterOAuth( $this->instance['consumer_key'], $this->instance['consumer_secret'], $this->instance['oauth_token'], $this->instance['oauth_token_secret'] );

	}

	public function hashFeeds($hashtag = '',$num = 5 ){
		// Twitter REST API v1.1 (https://dev.twitter.com/docs/api/1.1)
		$url = 'https://api.twitter.com/1.1/search/tweets.json';	

		$query = array(	'q' => $hashtag,
						'result_type' => 'recent',
						'count' => $num,
					);

		$content = $this->conn->get( $url, $query );
		
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

	
	public function tweets($handler = NULL , $num = 5) {
		// Twitter REST API v1.1 (https://dev.twitter.com/docs/api/1.1) 
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$this->conn = new TwitterOAuth( $this->instance['consumer_key'], $this->instance['consumer_secret'], $this->instance['oauth_token'], $this->instance['oauth_token_secret'] );

		$query = array(	'q' => $handler,
						// 'result_type' => 'recent',
						'count' => $num,
					);

		$content = $this->conn->get( $url, $query );
		// var_dump($content);die;
		echo '<ul>';
		
			if ( count($content) > 0 ) {
				
				foreach( $content as $status ) {
					// Hyperlink any URLs
					$status->text = preg_replace( '/(http[s]?:\/\/[^\s]*)/i', '<a href="$1">$1</a>', $status->text );	
					// Hyperlink @mentions
					$status->text = preg_replace( '/(^|\s)@([a-z0-9_]+)/i', '$1<a href="https://twitter.com/$2">@$2</a>', $status->text );	
					// Hyperlink #hashes
					$status->text = preg_replace( '/(^|\s)#([a-z0-9_]+)/i', '$1<a href="https://twitter.com/search?q=%23$2&src=hash">#$2</a>', $status->text );	

					echo '<li>';
					// echo '<a href="https://twitter.com/' . $status->user->screen_name . '" target="_blank">';
					echo $status->text;
					echo '</li>';
				}
			} else {
				echo 'No results found.';
			}
		echo "</ul>";
	}

}
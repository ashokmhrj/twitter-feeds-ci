# twitter-feeds-ci
fetching twitter hastag feeds in codeigniter


# requirement
twitter consumer key
twitter consumer secret
twitter oauth token
twitter oauth token secret


paste the above keys in  library/twitter.php class constructor

then you can 
 in your controller

$this->load->library('twitter');
$this->twitter->feeds('#your-hashtag');

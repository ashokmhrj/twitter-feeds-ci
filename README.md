# twitter-feeds-ci
fetching twitter hastag feeds in codeigniter


# requirement
twitter consumer key
twitter consumer secret
twitter oauth token
twitter oauth token secret


paste the above keys in  library/twitter.php class constructor

# controller
use the following code in your controller

$this->load->library('twitter');
## for hastag feeds
$this->twitter->hashFeeds('#your-hashtag');

## for handlers feeds
$this->twitter->hashFeeds('your-handler-name-wihout @');

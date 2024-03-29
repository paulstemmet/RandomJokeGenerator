
<?php
// Include the PHP SDK for YSP library.

include_once("../lib/Yahoo.inc");
include_once("../lib/JASON.php");

// Define constants to store your API Key (Consumer Key) and
// Shared Secret (Consumer Secret).
define("API_KEY","dj0yJmk9OGE2T01FQUZnaUhWJmQ9WVdrOVIxRmpUVGROTlRnbWNHbzlNVFl3TWpVM09ERTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD00NQ--");
define("SHARED_SECRET","9fff0a8f6692a3adae817596a38c45d100f38ec4");

// The YahooApplication class is used for two-legged authorization, 
// which doesn't need permission from the end user.
$two_legged_app = new YahooApplication(API_KEY,SHARED_SECRET);
if ($two_legged_app == NULL) {
   // Print error message and and then exit the script.
   print ("<br />");
   print ("Error: Cannot get two_legged_app (YahooApplication object)."); 
   exit;
}

// Define queries for Flickr and an RSS news feed
$flickr_query = 
  "select * from flickr.photos.search where text=\"panda\" limit 3";
$news_feed = 
  "select * from rss where url='http://rss.news.yahoo.com/rss/topstories'";








// Call the query and dump the response.
//echo "<h2>Flickr Data</h2>";
//$flickrResponse = $two_legged_app->query($flickr_query);
//echo "<pre>";
//var_dump($flickrResponse);
//echo "</pre>";


$newsResponse = $two_legged_app->query($news_feed);

echo '<h2> News Feed </h2>';
$results=$newsResponse->query->results;
echo "<pre>";
var_dump($results);
echo "</pre>";
foreach($results->item as $r) {
    
    echo '<p>';
    
     echo '<a href="' . $r['url'] . '">' . $r['title'];
    echo '</p>';
    
    
}




if (($flickrResponse==NULL) OR ($newsResponse==NULL)) {
   print ("<p>");
   print ("Warning: flickrResponse or newsResponse is NULL."); 
   print ("Check your API Key (Consumer Key) and Shared Secret (Consumer Secret)");
   print (" Also, make sure your query is valid.");
   print ("</p>");
}

// The YahooSession class is used for three-legged authorization,
// which does require permission from the end user.

$session=YahooSession::requireSession(API_KEY, SHARED_SECRET);
if ($session == NULL) {
   // Print error message and and then exit the script.
   print ("<p>");
   print ("Error: Cannot get session object."); 
   print (" Check your API Key (Consumer Key) and Shared Secret (Consumer Secret)");
   print ("</p>");
   exit;
}

// Define YQL queries for the Social Directory APIs
$profile = "select * from social.profile where guid=me";
$contacts = "select fields.value from social.contacts where guid=me";
$connections = "select * from social.connections where owner_guid=me";
$updates = "select * from social.updates where guid=me";
$status = "select value.status from social.presence where guid=me";

$api_queries = array("Profiles"=>$profile,
   "Contacts"=>$contacts,
   "Connections"=>$connections,
   "Updates"=>$updates,
   "Presence"=>$status);

// Make the calls to YQL and dump the responses.
foreach($api_queries as $api=>$query) {
   echo "<h2>$api Data</h2>";
   $queryResponse = $session->query($query);
   if ($queryResponse == NULL) {
      echo "<p>";
      echo "Error: No query response for $api.";
      echo " Check your permissions. Also, check the syntax of the YQL query.";
      echo "</p>";
   }
   else {
      echo "<pre>";
      var_dump($queryResponse);
      echo "</pre>";
   }
}
?>

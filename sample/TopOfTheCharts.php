
   
<?php

include_once("../GoogleAnalyticsforMobile/php/ga.php"); 
include_once("../GoogleAnalyticsforMobile/php/php1.snippet");
include_once("../shinka-publisher-lib-php/ShinkaBannerAd.php"); 
include_once("../shinka-publisher-lib-php/MxitUser.php");

// Create shinka banner ad object. Can be done at top of page, and re-used to display multiple banners on page.
$ShinkaBannerAd = new ShinkaBannerAd();	
	
// Do a server ad request to populate the BannerAd object with a new banner. This can be done multiple times with the same ShinkaBannerAd object to get new banners for the same user:
$ShinkaBannerAd->doServerAdRequest();
// Get HTML that should be displayed for this banner:
print $ShinkaBannerAd->generateHTMLFromAd();

// execute query
// get list of 15 most popular music releases
// retrieve result as SimpleXML object
//$xml = simplexml_load_file('http://query.yahooapis.com/v1/public/yql?q=SELECT * FROM music.release.popular');
$xml = simplexml_load_file('http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20music.artist.popular');



// iterate over query result set
echo '<h2>Popular Music</h2>';
$results = $xml->results;
foreach ($results->Artist as $r) {
  echo '<p>';
  echo '<a href="' . $r['url'] . '">' . $r['name'] . 
    '</a> <br/>'; 
  echo '</p>';
}  
?>
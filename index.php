
<?php

//Include the Shinka Publisher Library
include_once("shinka-publisher-lib-php/ShinkaBannerAd.php"); 
//include_once("GoogleAnalyticsforMobile/php/ga.php"); 
//include_once("GoogleAnalyticsforMobile/php/php1.snippet"); 


//$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
//echo '<img src="' . $googleAnalyticsImageUrl . '" />';



// Create shinka banner ad object. Can be done at top of page, and re-used to display multiple banners on page.
$ShinkaBannerAd = new ShinkaBannerAd();	
	
// Do a server ad request to populate the BannerAd object with a new banner. This can be done multiple times with the same ShinkaBannerAd object to get new banners for the same user:
$ShinkaBannerAd->doServerAdRequest();
// Get HTML that should be displayed for this banner:
print $ShinkaBannerAd->generateHTMLFromAd();

print '<br/>...Welcome to the Random Joke Generator<br/>';
?>
<img src="./images/image_<?php $random = rand(1,11); echo $random; ?>.jpg" alt="[ Random Image ]" height="128" width="128" />

<?php
print '<br/>Welcome to the Random Joke Generator<br/>';

// Do a server ad request to populate the BannerAd object with a new banner. This can be done multiple times with the same ShinkaBannerAd object to get new banners for the same user:
$ShinkaBannerAd->doServerAdRequest();
// Get HTML that should be displayed for this banner:
print $ShinkaBannerAd->generateHTMLFromAd();

?>




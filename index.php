
<?php

//Include the Shinka Publisher Library
include_once("GoogleAnalyticsforMobile/php/ga.php"); 
include_once("GoogleAnalyticsforMobile/php/php1.snippet");
include_once("shinka-publisher-lib-php/ShinkaBannerAd.php"); 
include_once("shinka-publisher-lib-php/MxitUser.php");



// Create shinka banner ad object. Can be done at top of page, and re-used to display multiple banners on page.
$ShinkaBannerAd = new ShinkaBannerAd();	
	
// Do a server ad request to populate the BannerAd object with a new banner. This can be done multiple times with the same ShinkaBannerAd object to get new banners for the same user:
$ShinkaBannerAd->doServerAdRequest();
// Get HTML that should be displayed for this banner:
print $ShinkaBannerAd->generateHTMLFromAd();


print '<br/>Hi ' . $Username . '<br/>';
print '<br/>...Welcome to the Gimme Portal!<br/> Please select 1 of the options below <br/> <br/><br/><br/><br/>';
?>


<a href="./Content/Jokeoftheday.php">Random Joke Generator </a> <br/>
<a href="./sample/TopOfTheCharts.php">Top Of The Charts</a> <br/>




<?php
/**
This example demonstrates how to use the PHP SDK for YSP 
with YQL to get user updates and the updates of user connections.
*/ 
    
// Include the YOS library.
// Be sure that the path to the PHP SDK is correct before running
// code example.
//require("../lib/Yahoo.inc");

// Display all errors for debugging
ini_set('display_errors',1);
error_reporting(E_ALL);

// Store error messages
$failed_session = "Your application could not be authorized. " .
                  "Please check the following:<br/>" .
                  "<ul><li>Your OAuth keys are correct</li>" .
                  "<li>The path to the PHP SDK is correct</li></ul>" .
                  "<p>If your keys and the path to the PHP SDK are " .
                  "correct, there might have been a server error " .
                  "during authorization.<br/>" .
                  "Please try running your app again.</p>";
$failed_query_updates = "The call to the YQL Web service to get user updates failed.";
$failed_query_conns = "The call to the YQL Web service to get user connections failed.";
$no_user_updates = "There are no user updates.";
$no_user_conns = "The user has no connections.";

// Get Consumer Key and Shared Secret (Consumer Secret)
// by creating a new Open Application from My Projects at
// http://developer.yahoo.com/dashboard/.

// Define your Consumer Key
$consumerKey =  "dj0yJmk9UTBnbU1KR0U2Y3VKJmQ9WVdrOVIxRmpUVGROTlRnbWNHbzlNVFl3TWpVM09ERTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD04Mw--";

// Define your Consumer Secret (Shared Secret)
$consumerSecret = "9fff0a8f6692a3adae817596a38c45d100f38ec4";

// Authorize the app to get user data.
$session = YahooSession::requireSession($consumerKey, $consumerSecret);

// Display error message if the app was not able to be authorized.
if(!$session)
{
   die($failed_session); 
}

// Use the SDK method 'query' from the YahooSession class 
// Limit the results to 5 updates and 5 connections
$user_updates = $session->query("SELECT * FROM social.updates WHERE guid=me LIMIT 5");

// Display error message if the YQL query to get the user's updates fails.
if(!$user_updates)
{
  die($failed_query_updates);
}

// Display message if user has no updates, but do
// not exit program as user might have connections
else if($user_updates->query->count==0)
{
  print("<p>".$no_user_updates."</p>");
}

// Display error message if the YQL query to get the user's connections fails.
$user_connections = $session->query("SELECT * FROM social.connections WHERE owner_guid=me LIMIT 5");
if(!$user_connections)
{
  die($failed_query_conns);
}

// Display message and exit as app's work is done
// if user has no connections
else if($user_connections->query->count==0)
{
  die($no_user_connections);
}

// First extract update info for the user
// and display the profile image as well as
// links to the user profile and each update.
foreach($user_updates as $results)
{
  echo "<p/>";
  $name_displayed = false;
  for($i=0;$i<5;$i++)
  {
    $title = $results->results->update[$i]->title;
    $name = $results->results->update[$i]->profile_nickname;
    $url = $results->results->update[$i]->itemurl;
    $profile = "http://profiles.yahoo.com/u/" . $results->results->update[$i]->profile_guid;
    $profile_img = $results->results->update[$i]->profile_displayImage;
    if(!$name_displayed){ 
      echo "<img src='$profile_img' height='50' width='50' align='absmiddle'/>";
      echo "<b>Your Updates (<a href='$profile'>$name</a>)</b>";
      echo "<br/><ul>";
      $name_displayed = true; 
    }                 
    if(strpos($title,$name)===false)
    {
       echo "<li><a href='$url'>$name $title</a></li>";
    }
    else
    {
      echo "<li><a href='$url'>$title</a></li>";
    }
  }
  echo "</ul><hr />";
}

// Now extract update info for user connections,
// displaying the profile image and links to
// the profile and to each update. 
$connections_results = $user_connections->query->results;
foreach($connections_results->connection as $connection)
{
  $updates = $session->query("select * from social.updates where guid='$connection->guid' limit 5");
  // Display message if connection has no updatees and go to
  // next connection.
  if($updates->query->count==0)
  {
    echo "<p>The user has no updates</p>";
    continue;  
  }
  foreach($updates as $results)
  {
    $name_displayed = false;
    for($i=0;$i<5;$i++)
    {
      $title = $results->results->update[$i]->title;
      $name = $results->results->update[$i]->profile_nickname;
      $url = $results->results->update[$i]->link;
      $profile = "http://profiles.yahoo.com/u/" . $results->results->update[$i]->profile_guid;
      $profile_img = $results->results->update[$i]->profile_displayImage;
      if(!$name_displayed){
       echo "<img src='$profile_img' height='50' width='50' align='absmiddle'/>";
       echo "<b>Updates for <a href='$profile'>$name</a></b>";
       echo "<br/><ul>";
       $name_displayed = true;
      }
      if(strpos($title,$name)===false)
      {
        echo "<li><a href='$url'>$name $title</a></li>";
      }
      else
      {
        echo "<li><a href='$url'>$title</a></li>";
      }
   }
    echo "</ul><hr />";
  }
}
?>   

<?php

/**
 * Created by JetBrains PhpStorm.
 * User: fschneider
 * Date: 08/03/13
 * Time: 09:53
 * To change this template use File | Settings | File Templates.
 */

//1 - Settings
include('conf/credentials.php');
$twitter_client     = 'https://twitter.com/';

//2 - Include @abraham's PHP twitteroauth Library
require_once('vendor/twitteroauth/twitteroauth.php');
require_once('vendor/functions.php');

//3 - Authentication
/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
$connection->decode_json = FALSE;
//4 - Start Querying
$query = 'https://api.twitter.com/1.1/statuses/home_timeline.json'; //Your Twitter API query
$data = json_decode($connection->get($query), true);
include 'rss.php';
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: fschneider
 * Date: 08/03/13
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
 */

//f_dbg($data);

header("Content-Type: application/rss+xml; charset=utf-8");
$rssfeed = '<?xml version="1.0" encoding="UTF-8"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>My Twitter RSS feed</title>';
$rssfeed .= '<link>http://www.amiphi.fr/rss</link>';
$rssfeed .= '<description>This is an example RSS feed</description>';
$rssfeed .= '<language>fr-fr</language>';
$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

foreach ($data as $twit) {
    $rssfeed .= '<item>';

    // cas du retweet
    if ( false === isset($twit['retweeted_status']) ) {
        $rssfeed .= '<title>' . $twit['user']['name'] . ' (@' . $twit['user']['screen_name'] . ')</title>';
    } else {
        $rssfeed .= '<title>' . 'RT by ' . $twit['user']['name'] . ' (@' . $twit['user']['screen_name'] . '): ' .
            $twit['retweeted_status']['user']['name'] . ' (@' . $twit['retweeted_status']['user']['screen_name'] . ')</title>';
        $twit = $twit['retweeted_status'];
    }

    // On recherche des Urls
    if (count($twit['entities']['urls']) > 0 ) {
        foreach($twit['entities']['urls'] as $url) {
            $twit['text'] = str_replace($url['url'], '<a href="'.$url['expanded_url'].'">'.$url['display_url'].'</a>', $twit['text']);
        }
    }
    $rssfeed .= '<description><![CDATA[<p>' . $twit['text'] . '</p>]]></description>';
    $rssfeed .= '<link>' . $twitter_client . $twit['user']['screen_name'] . '</link>';
    $rssfeed .= '<pubDate>' . $twit['created_at'] . '</pubDate>';
    $rssfeed .= '</item>';
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
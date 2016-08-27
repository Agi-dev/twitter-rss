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
$rssfeed = '<rss xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0">' . PHP_EOL;
$rssfeed .= '<channel>' . PHP_EOL;
$rssfeed .= '<title>My Twitter RSS feed</title>' . PHP_EOL;
$rssfeed .= '<link>http://www.amiphi.fr/rss</link>' . PHP_EOL;
$rssfeed .= '<description>Mon flux rss</description>' . PHP_EOL;
$rssfeed .= '<language>fr</language>' . PHP_EOL;
$rssfeed .= '<copyright>Copyright 2012, FeelPiX</copyright>' . PHP_EOL;
$rssfeed .= '<link>http://www.amiphi.fr/rss</link>' . PHP_EOL;

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
            $twit['text'] = str_replace(
                $url['url'],
                '<a href="' . $url['expanded_url'] . '">' . $url['display_url'] . '</a>',
                $twit['text']
            );
        }
    }

    $twit['text'] = '<p>' . $twit['text'] . '</p>' . PHP_EOL;

    // On recherche des images
    if (true === array_key_exists('media', $twit['entities'])
        && count($twit['entities']['media']) > 0
        && $twit['entities']['media'][0]['type'] == 'photo') {
        $twit['text'] .= '<p><img 
            src="'.$twit['entities']['media'][0]['media_url'].'" 
            width="'.$twit['entities']['media'][0]['sizes']['medium']['w'].'" 
            height="'.$twit['entities']['media'][0]['sizes']['medium']['h'].'">
            </p>' . PHP_EOL;
    }

    $rssfeed .= '<description><![CDATA[' . $twit['text'] . ']]></description>' . PHP_EOL;
    $rssfeed .= '<link>' . $twitter_client . $twit['user']['screen_name'] . '</link>' . PHP_EOL;
    $rssfeed .= '<pubDate>' . $twit['created_at'] . '</pubDate>' . PHP_EOL;

    $rssfeed .= '</item>' . PHP_EOL;
}

$rssfeed .= '</channel>' . PHP_EOL;
$rssfeed .= '</rss>' . PHP_EOL;

echo $rssfeed;
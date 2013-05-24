<?php
// @codeCoverageIgnoreStart

/**
 * Show var content
 *
 * @param mixed $v var to watch
 * @param bool  $exit exit(true by default)
 * @param bool  $dump add var type (false by default)
 */
function f_dbg($v, $exit = true, $dump = false)
{
	$calledFrom = debug_backtrace();
	$calledFrom = "\n=== DEBUG FROM ". substr($calledFrom[0]['file'], 1) .' (line ' . $calledFrom[0]['line'].")\n\n";
	if (true === $dump) {
		if ( !isset($_SERVER['PROMPT']) ) {
		  //header('Content-Type: text/html');
		}
		echo $calledFrom;
		var_dump($v);
	} else {
		if ( !isset($_SERVER['PROMPT']) ) {
		  //header('Content-Type: text/plain');
		}
		echo $calledFrom;
		print_r($v);
	}

	echo "\n\n=== FIN DEBUG \n";

	if (true === $exit) {
		exit(-1);
	}
}

// @codeCoverageIgnoreEnd
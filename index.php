<?php

error_reporting ( E_ALL );

function Bytes ( $size )
{
	$filesizename = [" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"];
	return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
}

$UNIX_1 = microtime ( 1 );
$MEMORY_SET = memory_get_usage ();

require 'Aero/AeroBase.php';

class Aero extends Aero\AeroBase {}

spl_autoload_register ( [ Aero::class, 'autoload' ] );

$main = new Aero\Application\Main( __DIR__, 'init', 'start' );

$main -> unit();

$MEMORY_GET = memory_get_usage();    
echo '<p>complecte: ' . ( microtime ( 1 ) - $UNIX_1 ) . '</p>';
echo '<p>memory: ' . bytes ( $MEMORY_GET - $MEMORY_SET ) . '</p>';
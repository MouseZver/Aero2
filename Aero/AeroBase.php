<?php

namespace Aero;

class AeroBase
{
	public static $app = NULL;
	protected static $NAMESPACESMAP = 
	[
		'SQL' => 'Database\SQL'
	];
	
	public static function setPathMap( array $namespace )
	{
		#self::$NAMESPACESMAP[$name] = $path;
		
		self::$NAMESPACESMAP = array_merge ( self::$NAMESPACESMAP, $namespace );
	}
	public static function autoload( string $C )
	{
		if ( isset ( self::$NAMESPACESMAP[$C] ) )	# Преобразование загруженной директории из имени пространства
		{
			$C = self::$NAMESPACESMAP[$C];
		}
		elseif ( file_exists ( __DIR__ . substr ( $C, 4 ) . '.php' ) )
		{
			$C = __DIR__ . substr ( $C, 4 );
		}
		else throw new \Exception( sprintf ( 'Invalid namespace %s ( %s )', __METHOD__, $C ) );
		
		include strtr ( $C, '\\', DIRECTORY_SEPARATOR ) . '.php';
	}
}
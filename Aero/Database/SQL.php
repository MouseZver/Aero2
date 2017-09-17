<?php

class SQL
{
	private const DNS = 'mysql:host=%s;dbname=%s;charset=%s';
	private const HOST = '127.0.0.1';
	private const DBNAME = 'single';
	private const CHARSET = 'utf8';
	private const USER = 'root';
	private const PASSWORD = '';
	protected static $INSTANCE = NULL;
	private static $ATTR = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_EMULATE_PREPARES => FALSE,
	];
	
	protected static function instance(): PDO
	{
		if ( self::$INSTANCE === NULL )
		{
			self::$INSTANCE = new PDO( self::setting(), self::USER, self::PASSWORD, self::$ATTR );
		}
		
		return self::$INSTANCE;
	}
	protected static function setting(): string
	{
		return sprintf ( self::DNS, self::HOST, self::DBNAME, self::CHARSET );
	}
	public static function __callStatic( $method, $args )
	{
		return call_user_func_array ( [ self::instance(), $method ], $args );
	}
	public static function P( $sql, $args = NULL )
	{
		$shtm = self::instance() -> prepare( $sql );
		$shtm -> execute( $args );
		
		return $shtm;
	}
}




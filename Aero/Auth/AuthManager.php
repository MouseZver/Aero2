<?php

namespace Aero\Auth;

use SQL;
use Aero\Auth\Blue\Auth;
use Aero\Application\Main;


class AuthManager extends Auth
{
	protected $instance = NULL;
	public $form = NULL;
	public $isLogged = FALSE;
	public $time;
	public $username;
	
	public function __construct ( Main $Main, string $name )
	{
		$this -> instance = $Main;
		$this -> cookie = 'AuthMe';
		$this -> time = '+ 30 day';
		$this -> username = 'Гость';
		
		$this -> formate( new $name ) -> dropHash();
	}
	protected function isCookie(): bool
	{
		return isset ( $_COOKIE[$this -> cookie] );
	}
	protected function isLogged(): bool
	{
		if ( isset ( $_SESSION['logged'] ) )
		{
			$this -> setSess();
			
			return TRUE;
		}
		
		if ( $this -> isHash )
		{
			$this -> AuthMe();
			
			return TRUE;
		}
		elseif ( $this -> isCookie )
		{
			$this -> delCookie();
		}
		
		return FALSE;
	}
	protected function isHash(): bool
	{
		if ( $this -> isCookie )
		{
			return $this -> hash();
		}
		
		return FALSE;
	}
	protected function dropHash(): AuthManager
	{
		SQL::P( sprintf ( 'UPDATE %s SET hash = NULL WHERE online <= ?', $this -> form -> table ), [ strtotime ( strtr ( $this -> time, '+', '-' ) ) ] );
		
		return $this;
	}
	protected function delCookie()
	{
		setcookie ( $this -> cookie, '', -1, '/' );
	}
}
<?php

namespace Aero\Auth\Blue;

use SQL;
use Aero\Auth\User;

abstract class Auth
{
	abstract protected function isCookie(): bool;
	abstract protected function isLogged(): bool;
	abstract protected function isHash(): bool;
	
	protected function formate( User $User ): Auth
	{
		$this -> form = $User;
		
		return $this;
	}
	public function runable()
	{
		$this -> isCookie = $this -> isCookie();
		$this -> isHash = $this -> isHash();
		$this -> isLogged = $this -> isLogged();
	}
	protected function hash(): bool
	{
		return SQL::P( sprintf ( 'SELECT id FROM %s WHERE hash = ? LIMIT 1', $this -> form -> table ), [ $_COOKIE[$this -> cookie] ] ) -> rowCount() > 0;
	}
	protected function AuthMe()
	{
		if ( isset ( $_SESSION['logged'] ) )
		{
			$account = SQL::P( sprintf ( 'SELECT id, username, status FROM %s WHERE id = ?', $this -> form -> table ), [ $_SESSION['id'] ] ) -> fetch();
		}
		elseif ( $this -> isCookie )
		{
			$account = SQL::P( sprintf ( 'SELECT id, username, status FROM %s WHERE hash = ?', $this -> form -> table ), [ $_COOKIE[$this -> cookie] ] ) -> fetch();
		}
		else
		{
			$this -> delCookie();
			
			return;
		}
		
		$_SESSION['id'] = $account -> id;
		$this -> username = $_SESSION['username'] = $account -> username;
		$this -> status = $_SESSION['status'] = $account -> status;
	}
	protected function setSess()
	{
		if ( $this -> isHash )
		{
			$this -> username = $_SESSION['username'];
			$this -> status = $_SESSION['status'];
		}
		else
		{
			$this -> AuthMe();
		}
	}
}
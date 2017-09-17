<?php

namespace Aero\Page;

use SQL;
use Aero;

class Action extends Controller
{
	private $error = [];
	
	public function actionindex()
	{
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
		{
			$ARGS = [
				Aero::$app -> Auth -> form -> email => FILTER_VALIDATE_EMAIL,
				Aero::$app -> Auth -> form -> pass => FILTER_DEFAULT
			];
			
			$INPUTS = filter_input_array ( INPUT_POST, $ARGS );
			
			if ( $INPUTS[Aero::$app -> Auth -> form -> email] === NULL OR $INPUTS[Aero::$app -> Auth -> form -> pass] === NULL )
			{
				$this -> error['undefined'] = 'Undefined inputs name :(';
			}
			elseif( !$INPUTS[Aero::$app -> Auth -> form -> email] )
			{
				$this -> error['email'] = 'Invalid is email.';
			}
			else
			{
				$account = SQL::P( 'SELECT id, username, password FROM usraccount WHERE email = ?', [ strtolower ( $INPUTS[Aero::$app -> Auth -> form -> email] ) ] ) -> fetch();
				
				if ( !password_verify ( $INPUTS[Aero::$app -> Auth -> form -> pass], $account -> password ?? NULL ) )
				{
					$this -> error['data'] = 'Введенные данные не верны.';
				}
				
				/* Aero::select( [ ':email' => strtolower ( $INPUTS['email'] ) ], function ( Mouse $Mouse )
				{
					$Mouse 
						-> column( 'password' )
						-> from( 'usraccount' )
						-> where( 'email = :email' )
						-> limit( 1 );
				} ); */
			}
			
			if ( count ( $this -> error ) > 0 )
			{
				Aero::$app -> buffer = [ 'MSGERROR' => $this -> error ];
				
				return;
			}
			
			$password_hash = password_hash ( $INPUTS[Aero::$app -> Auth -> form -> pass], PASSWORD_DEFAULT );
			
			$hash = md5 ( $account -> id . $account -> username . $password_hash );
			
			/* Aero::update( [], function ( Mouse $Mouse )
			{
				$Mouse
					-> table( 'usraccount' )
					-> set( 'hash = :hash', 'online = :time' )
					-> where( 'id = ' . $account -> id );
			} ); */
			
			SQL::P( 'UPDATE usraccount SET password = ?, hash = ?, online = ? WHERE id = ' . $account -> id, [ $password_hash, $hash, $_SERVER['REQUEST_TIME'] ] );
			
			setcookie ( Aero::$app -> Auth -> cookie, $hash, strtotime ( Aero::$app -> Auth -> time ), '/' );
			
			Aero::$app -> buffer = [ 'REDIRECT' => '/' ];
		}
	}
}
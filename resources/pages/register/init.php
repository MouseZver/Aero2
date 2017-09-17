<?php

namespace Aero\Page;

use SQL;
use Aero;

class Action extends Controller
{
	public function actionindex()
	{
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
		{
			$ARGS = [
				Aero::$app -> Auth -> form -> name => [ 
					'filter' => FILTER_VALIDATE_REGEXP,
					'options' => [
						'regexp' => '/^[A-Za-z0-9_-]{3,25}$/'
					]
				],
				Aero::$app -> Auth -> form -> email => FILTER_VALIDATE_EMAIL,
				Aero::$app -> Auth -> form -> pass => FILTER_DEFAULT,
				Aero::$app -> Auth -> form -> confirm => FILTER_DEFAULT
			];
			
			$INPUTS = filter_input_array ( INPUT_POST, $ARGS );
			
			if ( $INPUTS[Aero::$app -> Auth -> form -> name] === NULL OR 
				$INPUTS[Aero::$app -> Auth -> form -> email] === NULL OR 
				$INPUTS[Aero::$app -> Auth -> form -> pass] === NULL OR 
				$INPUTS[Aero::$app -> Auth -> form -> confirm] === NULL )
			{
				$this -> error['undefined'] = 'Undefined inputs name :(';
			}
			else
			{
				if ( $INPUTS['username'] === FALSE ) 
					$this -> error['username'] = 'Пожалуйста, введите имя, содержащее от 3-х до 25 латинских символов.';
				
				if ( $INPUTS['email'] === FALSE ) 
					$this -> error['email'] = 'Адрес электронной почты должен быть валидным.';
				
				if ( empty ( $INPUTS['password'] ) )
				{
					$this -> error['password'] = 'Пожалуйста, введите пароль.';
				}
				elseif ( $INPUTS[Aero::$app -> Auth -> form -> pass] != $INPUTS[Aero::$app -> Auth -> form -> confirm] )
				{
					$this -> error['password'] = 'Введенные пароли не совпадают.';
				}
				
				# Объединить запрос в left join =============================================================================================================
				
				if ( !isset ( $this -> error['username'] ) && SQL::P( 'SELECT id FROM usraccount WHERE lower ( username ) = ?', [ strtolower ( $INPUTS[Aero::$app -> Auth -> form -> name] ) ] ) -> rowCount() > 0 )
					$this -> error['username'] = 'Введенное имя уже используется.';
				
				if ( !isset ( $this -> error['email'] ) && SQL::P( 'SELECT id FROM usraccount WHERE email = ?', [ strtolower ( $INPUTS[Aero::$app -> Auth -> form -> email] ) ] ) -> rowCount() > 0 )
				{
					$this -> error['email'] = 'Введенная почта уже используется.';
				}
				elseif ( empty ( $this -> error ) && !$this -> send( $INPUTS[Aero::$app -> Auth -> form -> email], 'Aero register user Account', 'The ' . $INPUTS[Aero::$app -> Auth -> form -> name] . ' registration complecte.' ) )
				{
					$this -> error['email'] = 'Ошибка с введенной почтой';
				}
			}
			
			if ( !empty ( $this -> error ) )
			{
				Aero::$app -> buffer = [ 'MSGERROR' => $this -> error ];
				
				return;
			}
			
			$hash = password_hash ( $INPUTS[Aero::$app -> Auth -> form -> pass], PASSWORD_DEFAULT );
			
			SQL::P( 'INSERT INTO usraccount ( username, email, password, status, datareg, online ) VALUES ( ?,?,?,?,?,? )', 
			[
				$INPUTS[Aero::$app -> Auth -> form -> name],
				$INPUTS[Aero::$app -> Auth -> form -> email],
				$hash,
				1,
				$_SERVER['REQUEST_TIME'],
				$_SERVER['REQUEST_TIME']
			] );
			
			$uid = SQL::lastInsertId();
			
			$sid = md5 ( $uid . $INPUTS[Aero::$app -> Auth -> form -> name] . $hash );
			
			SQL::P( 'UPDATE usraccount SET hash = ? WHERE id = ?', [ $sid, $uid ] );
			
			setcookie ( Aero::$app -> Auth -> cookie, $sid, strtotime ( Aero::$app -> Auth -> time ), '/' );
			
			Aero::$app -> buffer = [ 'REDIRECT' => '/?' . $INPUTS[Aero::$app -> Auth -> form -> name] ];
		}
	}
}
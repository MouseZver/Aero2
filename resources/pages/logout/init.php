<?php

namespace Aero\Page;

use Aero;
use SQL;

class Action extends Controller
{
	public function actionindex()
	{
		if ( Aero::$app -> Auth -> isLogged )
		{
			SQL::P( 'UPDATE usraccount SET hash = NULL WHERE id = ' . $_SESSION['id'] );
			
			setcookie ( Aero::$app -> Auth -> cookie, '', -1, '/' );
			
			session_destroy ();
		}
		
		Aero::$app -> buffer = [ 'REDIRECT' => '/' ];
	}
}
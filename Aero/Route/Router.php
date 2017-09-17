<?php

namespace Aero\Route;

#use Aero\Application\Main;
use Aero\AeroBase AS Aero;
use Aero\Page\Action;

class Router
{
	protected $action;
	public $style;
	
	/* public function __construct ( Main $Main )
	{
		$this -> instance = $Main;
	} */
	public function action( Action $Action )
	{
		$this -> action = $Action;
		
		foreach ( $Action -> list AS $param => $load )
		{
			$ex = explode ( '/', $param );
			
			$map = array_map ( function ( $K, $P )
			{
				switch ( $P )
				{
					case '?':
						return Aero::$app -> page[$K];
					break;
					
					case ':id':
						return is_numeric ( Aero::$app -> page[$K] ) ? Aero::$app -> page[$K] : NULL;
					break;
					
					default:
						return $P;
				}

			}, array_keys ( $ex ), $ex );
			
			if ( $map === Aero::$app -> page )
			{
				$this -> setStyle( $load );
				
				return $load['action'];
			}
		}
	}
	protected function setStyle( array $load )
	{
		$this -> style = ( isset ( $load['style'] ) ? $load['style'] : 'default' );
	}
	public function run()
	{
		if ( method_exists ( $this -> action, $method = 'action' . Aero::$app -> action ) )
		{
			return $this -> action -> $method();
		}
		
		throw new \Exception( 'Invalid Route method: ' . $method );
	}
}
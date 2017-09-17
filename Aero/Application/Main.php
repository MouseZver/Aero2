<?php

namespace Aero\Application;

use Aero;
use Aero\Low\Jsn;
use Aero\Route\Router;
use Aero\Page\Action;
use Aero\Page\Controller;
use Aero\Auth\AuthManager;

class Main
{
	protected $path;
	protected $Directory;
	protected $pageFile;
	public $page = [];
	public $action;
	public $buffer = FALSE;
	public $Router = NULL;
	public $Auth = NULL;
	
	use Jsn;
	
	public function __construct ( string $directory, string $namefile, string $defaultStart )
	{
		Aero::$app = $this;
		
		$this -> Directory = $directory;
		$this -> pageFile = $namefile;
		$this -> pageStart = $defaultStart;
		$this -> pagePath = strtr ( $directory . '/resources/pages/%s/%s', '/', DIRECTORY_SEPARATOR );
		$this -> controllerPath = strtr ( $directory . '/resources/pages/%s/Controller/Controller', '/', DIRECTORY_SEPARATOR );
		
		$this -> path = $this -> urlPath() -> isPath();
	}
	protected function urlPath(): Main
	{
		$this -> page = explode ( '/', trim ( parse_url ( $_SERVER['REQUEST_URI'], 5 ), '/' ) ?: $this -> pageStart );
		
		return $this;
	}
	protected function isPath(): bool
	{
		$file = sprintf ( $this -> pagePath, $this -> page[0], $this -> pageFile );
		
		if ( file_exists ( $file . '.php' ) )
		{
			Aero::setPathMap( [ 
				Action::class => $file, 
				Controller::class => sprintf ( $this -> controllerPath, $this -> page[0] )
			] );
			
			return TRUE;
		}
		
		return FALSE;
	}
	protected function header( AuthManager $Auth )
	{
		session_name ( 'EASYSINGLE_SESSID' );
		session_start ();
		
		( $this -> Auth = $Auth ) -> runable();
		
		ob_start ();
	}
	protected function router( Router $Router )
	{
		register_shutdown_function ( [ $this, 'fluex' ] );
		
		$this -> Router = $Router;
		$this -> action = $Router -> Action( new Action );
		$this -> Router -> run();
	}
	protected function buffer()
	{
		if ( !empty ( $this -> buffer ) )
		{
			echo $this -> json( [ 'ELEMENTS' => $this -> buffer ] );
		}
		else
		{
			echo $this -> json( 
			[ 
				'TITLE' => Aero::$app -> Router -> style,#self::PAGE_TITLE( 1, 1 ), 
				'BODY' => include strtr ( 
					$this -> Directory . '/resources/view/others/' . Aero::$app -> Router -> style . '.php' , 
					'/', DIRECTORY_SEPARATOR )
			] );
		}
	}
	public function unit()
	{
		if ( !$this -> path )
			throw new \Exception( '~~ Code 404 No Folder: ' . $this -> page[0] );
		
		$this -> header( new AuthManager( $this, Aero\Auth\User::class ) );
		$this -> router( new Router );
	}
	public function fluex()
	{
		$contents = ob_get_contents ();
		ob_end_clean ();
		
		if (0)
		{
			echo $contents;
			return;
		}
		if ( isset ( $_GET['HISTORY_API'] ) )
		{
			header ( 'Content-type: application/json' );
			
			$this -> buffer();
			
			return;
		}
		elseif ( isset ( $this -> buffer['REDIRECT'] ) )
		{
			header ( 'Location: ' . $this -> buffer['REDIRECT'] );
			return;
		}
		
		header ( 'Content-type: text/html; charset=UTF-8' );
		
		include strtr ( $this -> Directory . '/resources/view/template.php', '/', DIRECTORY_SEPARATOR );
	}
}





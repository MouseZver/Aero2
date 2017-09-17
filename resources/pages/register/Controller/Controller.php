<?php

namespace Aero\Page;

use Aero\Low\MailSend;

class Controller
{
	public $list = [
		'register' => [ 'action' => 'index', 'style' => 'register' ]
	];
	
	use MailSend;
}
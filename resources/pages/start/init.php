<?php

namespace Aero\Page;

use Aero;

class Action extends Controller
{
	public function actionindex()
	{
		echo 'Aero: Hello ' . Aero::$app -> Auth -> username . ' ;)';
	}
}
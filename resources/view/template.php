<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Aero title</title>
		<script type="text/javascript" src="/public/js/jquery-3.1.0.js"></script>
		<script type="text/javascript" src="/public/js/MouseZver.js"></script>
		<link type="text/css" rel="stylesheet" href="/public/css/style.css">
		<!-- Naruto Shippuuden -->
		<style type="text/css">
		body 
		{
			background: url("/public/images/background/4.jpg") #000 no-repeat center top fixed;
		}
		
		</style>
	</head>
	<body class="BORDER_RED">
		<div id="ACCOUNT-MENU" class="U-MENU">
			<div class="U-MENU-PRIMARY">
				<div class="LIST-NOTICES">
					<div id="NOTICE-4" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
					<div id="NOTICE-3" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
					<div id="NOTICE-2" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
					<div id="NOTICE-1" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
					<div id="NOTICE-1" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
					<div id="NOTICE-1" class="POST" data-user="Mouse">
						<a href="#"><img src="/public/test/img.jpg" width="48" height="48"></a>
						<div class="NOTICE-TEXT">
							<a href="#">Mouse</a> ответил(а) в теме <a href="#">Подстановка в SQL запрос</a>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="U-MENU-SECONDARY U-MENU-PRIMARY">
				<div>
					dfgdf
				</div>
				<div>
					dfgdf
				</div>
			</div> -->
		</div>
		<div id="RAY_TOP_CONTENT">
			<div class="HEADER-CENTER">
				<div id="PRIMARY-NAV">
					<ul>
						<li><a href="#">Пользователи</a></li>
						<? if ( Aero::$app -> Auth -> isLogged ) { ?>
							<li><a id="ENGINE-USER-MENU" href="/u/<?= Aero::$app -> Auth -> username ?>"><b><?= Aero::$app -> Auth -> username ?></b></a></li>
							<li><a id="ENGINE-NOTICE-MENU" href="#">Уведомления (0)</a></li>
							<? if ( /* in_array ( AuthMe::$GROUP_ACCESS, ( Engine::$RAY['PAGE']['panel']['ACCESS'] ?? [] ) ) */0 ) { ?>
							<li><a id="ENGINE-PANEL-MENU" href="/panel">Панель управления</a></li>
							<? } ?>
						<? } ?>
					</ul>
				</div>
				<div id="SECONDARY-NAV">
					<ul>
						<li><a href="#">Search...</a></li>
						<? if ( Aero::$app -> Auth -> isLogged ) { ?>
						<li><a href="/logout">Logout</a></li>
						<? } else { ?>
						<li><a href="/auth">Sign in</a></li>
						<li><a href="/register">Sign up</a></li>
						<? } ?>
					</ul>
				</div>
			</div>
		</div>
		<? require 'others/' . Aero::$app -> Router -> style . '.php' ?>
	</body>
</html>
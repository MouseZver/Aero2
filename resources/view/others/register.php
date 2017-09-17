<div id="WRAPPER_CONTENT_BODY" style="width:390px;">
	<div class="CONTENT_MARGIN">
		<div class="RAY_WRAPPER">
			<div class="WRAPPER CONTENT_RADIUS">
				<div>fhfh</div>
				<div class="RAY_WRAPPER_REGISTER">
					<form id="RAY" action="/register?HISTORY_API" method="POST">
						<div class="REGISTER-ONE-STEP REGISTER-VISIBLE">
							<input type="text" name="<?= Aero::$app -> Auth -> form -> name ?>" placeholder="Username">
							<input type="text" name="<?= Aero::$app -> Auth -> form -> email ?>" placeholder="Email">
							<input type="password" name="<?= Aero::$app -> Auth -> form -> pass ?>" placeholder="Password">
							<input type="password" name="<?= Aero::$app -> Auth -> form -> confirm ?>" placeholder="Retype password">
							<button id="CAPTCHA" class="BTN BTN-ACTION RIGHT" type="button">Next</button>
						</div>
						<div class="REGISTER-TWO-STEP">
							<button class="BTN BTN-ACTION RIGHT" type="submit">Register</button>
							<button id="CAPTCHA" class="BTN BTN-ACTION RIGHT" type="button">back</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="RAY_FOOTER_CONTENT">
			<div class="FOOTER_BAR_LEFT">
				dfgdzsfg
			</div>
			<div class="COPYRIGHT">
				 © 2017
			</div>
		</div>
	</div>
</div>
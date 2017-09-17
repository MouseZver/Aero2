<?php

namespace Aero\Low;

trait MailSend
{
	public function send( string $mail, string $sub, string $message ): bool
	{
		return mail ( $mail, $sub, $message );
	}
}
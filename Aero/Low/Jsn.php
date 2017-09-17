<?php

namespace Aero\Low;

trait Jsn
{
	public function json( array $A ): string
	{
		return json_encode ( $A, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE );
	}
}
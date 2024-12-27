<?php

namespace Vahe\MalCrawler\Traits;

trait HasDecodeUnicode
{
	/**
	 * Декодирует строку, экранированную в Unicode.
	 *
	 * Decodes a Unicode-escaped string.
	 *
	 * @param string $str
	 * @return string
	 */
	protected function decodeUnicode(string $str): string
	{
		return json_decode('"' . $str . '"');
	}
}

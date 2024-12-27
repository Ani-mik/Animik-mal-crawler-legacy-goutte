<?php


namespace Vahe\MalCrawler\Services;

use Vahe\MalCrawler\Traits\hasDecodeUnicode;
use Vahe\MalCrawler\Traits\hasSlugTrait;

abstract class BaseService
{
	use hasSlugTrait, hasDecodeUnicode;
}

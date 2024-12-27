<?php

namespace Vahe\MalCrawler\Traits;

trait HasSlugTrait
{
	/**
	 * Генерирует слуг для жанра (переводит в нижний регистр, заменяет пробелы на дефисы).
	 *
	 * Converts the string to lowercase and replaces spaces/underscores with hyphens.
	 *
	 * @param string $slug
	 * @return string
	 */
	protected function generateSlug(string $slug): string
	{
		return str_replace([' ', '_'], '-', strtolower($slug));
	}
}

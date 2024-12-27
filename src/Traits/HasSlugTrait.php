<?php


namespace Vahe\MalCrawler\Traits;

trait HasSlugTrait
{
	/**
	 * Generate slug for genre (converts to lowercase, replaces spaces with hyphens)
	 *
	 * @param string $slug
	 * @return string
	 */
	protected function generateSlug(string $slug): string
	{
		return str_replace([' ', '_'], '-', strtolower($slug));
	}
}

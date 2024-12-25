<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Base URL
	|--------------------------------------------------------------------------
	|
	| The base URL to access the main resource. By default, this points to the
	| MyAnimeList website. You can override this value using the .env file
	| by setting the MAL_CRAWLER_BASE_URL parameter.
	|
	*/
  'base_url' => env('MAL_CRAWLER_BASE_URL', 'https://myanimelist.net'),

	/*
	|--------------------------------------------------------------------------
	| Genres URL
	|--------------------------------------------------------------------------
	|
	| The path to retrieve anime genres. This is a relative path that will be
	| appended to the base_url. By default, it uses '/anime.php'.
	| To change this, set the MAL_CRAWLER_GENRES_URL parameter in the .env file.
	|
	*/
  'genres_url' => env('MAL_CRAWLER_GENRES_URL', '/anime.php'),

  'genre' => env('MAL_CRAWLER_GENRE_URL', '/anime/genre'),
];

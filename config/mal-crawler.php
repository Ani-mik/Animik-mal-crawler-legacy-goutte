<?php

return [

	/*
	|---------------------------------------------------------------------------
	| Base URL
	|---------------------------------------------------------------------------
	|
	| The base URL to access the main resource. By default, this points to the
	| MyAnimeList website. You can override this value using the .env file
	| by setting the MAL_CRAWLER_BASE_URL parameter.
	|
	*/
  'base_url' => env('MAL_CRAWLER_BASE_URL', 'https://myanimelist.net'),

	/*
	|---------------------------------------------------------------------------
	| Genres URL
	|---------------------------------------------------------------------------
	|
	| The path to retrieve anime genres. This is a relative path that will be
	| appended to the base_url. By default, it uses '/anime.php'.
	| To change this, set the MAL_CRAWLER_GENRES_URL parameter in the .env file.
	|
	*/
  'genres_url' => env('MAL_CRAWLER_GENRES_URL', '/anime.php'),

	/*
	|---------------------------------------------------------------------------
	| Genre URL
	|---------------------------------------------------------------------------
	|
	| The path to retrieve a specific genre by its malId.
	| This is used when we need to crawl genre description.
	|
	*/
  'genre' => env('MAL_CRAWLER_GENRE_URL', '/anime/genre'),

	/*
	|---------------------------------------------------------------------------
	| Studio URL
	|---------------------------------------------------------------------------
	|
	| The path to retrieve a specific studio by its malId.
	| This is used when we need to crawl studio description.
	|
	*/
  'studio_url' => env('MAL_CRAWLER_Studio_URL', '/anime/producer'),

	/*
    |---------------------------------------------------------------------------
    | Season URL
    |---------------------------------------------------------------------------
    |
    | The path to retrieve anime seasons archive. This URL will be used to fetch
    | information about past and upcoming anime seasons. By default, it uses
    | '/anime/season/archive' as the path.
    | You can change this value in the .env file by setting the MAL_CRAWLER_SEASON_URL
    | parameter.
    |
    */
  'season_url' => env('MAL_CRAWLER_SEASON_URL', '/anime/season/archive'),

	/*
	|---------------------------------------------------------------------------
	| Description Not Found Message
	|---------------------------------------------------------------------------
	|
	| This message will be returned if the description of a genre is not found.
	| You can change this message in the .env file.
	|
	*/
  'not_found' => env('MAL_CRAWLER_DESCRIPTION_NOT_FOUND', null),

	/*
	|---------------------------------------------------------------------------
	| No Studio Picture URL
	|---------------------------------------------------------------------------
	|
	| The URL that is used to check if a studio has a picture or not. If the
	| retrieved studio image matches this URL, it means that the studio does not
	| have its own image, and in that case, it will return `null` instead.
	|
	| Default: 'https://cdn.myanimelist.net/images/company_no_picture.png'
	|
	*/
  'no_studio_picture' => env('MAL_CRAWLER_STUDIO_PICTURE', 'https://cdn.myanimelist.net/images/company_no_picture.png'),

];

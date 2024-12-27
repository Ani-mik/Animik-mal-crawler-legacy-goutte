<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Base URL
	|--------------------------------------------------------------------------
	|
	| Базовый URL для доступа к основному ресурсу. По умолчанию, это указывает на
	| MyAnimeList. Вы можете изменить это значение в файле .env, установив параметр
	| MAL_CRAWLER_BASE_URL.
	|
	| The base URL for accessing the main resource. By default, this points to
	| MyAnimeList. You can override this value in the .env file by setting the
	| MAL_CRAWLER_BASE_URL parameter.
	|
	*/
  'base_url' => env('MAL_CRAWLER_BASE_URL', 'https://myanimelist.net'),

	/*
	|--------------------------------------------------------------------------
	| Anime URL
	|--------------------------------------------------------------------------
	|
	| Путь для получения информации о аниме. Этот относительный путь будет добавлен
	| к base_url. По умолчанию используется '/anime'.
	|
	| The path for retrieving anime information. This relative path will be appended
	| to the base_url. By default, it uses '/anime'.
	|
	*/
  'anime_url' => env('MAL_CRAWLER_ANIME_URL', '/anime'),

	/*
	|--------------------------------------------------------------------------
	| Maximum Range for Anime ID
	|--------------------------------------------------------------------------
	|
	| Максимальный ID, который будет использоваться в начальном диапазоне поиска.
	| Вы можете настроить этот параметр в файле .env, установив MAL_CRAWLER_ANIME_RANGE_MAX_FIND.
	|
	| The maximum ID to be used in the initial search range. You can configure this
	| parameter in the .env file by setting MAL_CRAWLER_ANIME_RANGE_MAX_FIND.
	|
	*/
  'anime_range_max_find' => env('MAL_CRAWLER_ANIME_RANGE_MAX_FIND', 10000),

	/*
	|--------------------------------------------------------------------------
	| No Studio Picture URL
	|--------------------------------------------------------------------------
	|
	| URL, который используется для проверки, имеет ли студия изображение. Если полученное
	| изображение студии совпадает с этим URL, значит, у студии нет собственного изображения,
	| и вместо этого будет возвращено `null`.
	|
	| The URL used to check if a studio has an image. If the retrieved studio image
	| matches this URL, it means the studio does not have its own image, and `null`
	| will be returned instead.
	|
	*/
  'no_studio_picture' => env('MAL_CRAWLER_STUDIO_PICTURE', 'https://cdn.myanimelist.net/images/company_no_picture.png'),

	/*
	|--------------------------------------------------------------------------
	| Genres URL
	|--------------------------------------------------------------------------
	|
	| Путь для получения жанров аниме. Этот относительный путь будет добавлен к base_url.
	| По умолчанию используется '/anime.php'.
	|
	| The path for retrieving anime genres. This relative path will be appended to
	| the base_url. By default, it uses '/anime.php'.
	|
	*/
  'genres_url' => env('MAL_CRAWLER_GENRES_URL', '/anime.php'),

	/*
	|--------------------------------------------------------------------------
	| Genre URL
	|--------------------------------------------------------------------------
	|
	| Путь для получения информации о конкретном жанре по его malId.
	|
	| The path for retrieving information about a specific genre by its malId.
	|
	*/
  'genre' => env('MAL_CRAWLER_GENRE_URL', '/anime/genre'),

	/*
	|--------------------------------------------------------------------------
	| Studio URL
	|--------------------------------------------------------------------------
	|
	| Путь для получения информации о конкретной студии по её malId.
	|
	| The path for retrieving information about a specific studio by its malId.
	|
	*/
  'studio_url' => env('MAL_CRAWLER_STUDIO_URL', '/anime/producer'),

	/*
	|--------------------------------------------------------------------------
	| Season URL
	|--------------------------------------------------------------------------
	|
	| Путь для получения архива сезонов аниме. Этот URL будет использован для получения
	| информации о прошедших и будущих сезонах аниме. По умолчанию используется
	| '/anime/season/archive'.
	|
	| The path for retrieving anime season archive. This URL will be used to fetch
	| information about past and upcoming anime seasons. By default, it uses
	| '/anime/season/archive'.
	|
	*/
  'season_url' => env('MAL_CRAWLER_SEASON_URL', '/anime/season/archive'),

	/*
	|--------------------------------------------------------------------------
	| Description Not Found Message
	|--------------------------------------------------------------------------
	|
	| Это сообщение будет возвращено, если описание жанра не найдено.
	|
	| This message will be returned if the description of a genre is not found.
	|
	*/
  'not_found' => env('MAL_CRAWLER_DESCRIPTION_NOT_FOUND', 'Description not found'),

];



# Animik Wiki Crawler

**Animik Wiki Crawler** — это пакет для Laravel, предназначенный для парсинга данных о аниме для экосистемы **Animik**.

## Установка

Для установки используйте Composer:

```bash
composer require animik/mal-crawler
```

После установки, опубликуйте конфигурационные файлы:

```bash
php artisan vendor:publish --provider="Animik\MalCrawler\MalCrawlerServiceProvider" --tag=config
```

Для запуска тестов используйте команду:

```bash
./vendor/bin/phpunit tests
```

./vendor/bin/phpunit tests
./vendor/bin/phpunit tests --filter=CrawlerServiceTest

php artisan vendor:publish --provider="Vahe\MalCrawler\MalCrawlerServiceProvider" --tag=config

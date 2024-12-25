<?php

namespace Vahe\MalCrawler\Tests;

use Orchestra\Testbench\TestCase;
use Vahe\MalCrawler\Providers\MalCrawlerServiceProvider;

/**
 * @doesNotPerformAssertions
 */
class UnitTest extends TestCase
{
	/**
	 * Общий лог-файл для всех тестов.
	 *
	 * @var string
	 */
	protected string $mainLogFile;

	protected function setUp(): void
	{
		parent::setUp();

		$this->mainLogFile = $this->generateLogFilePath();

		$directory = dirname($this->mainLogFile);
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}

		// Создаем пустой лог-файл
		file_put_contents($this->mainLogFile, "Log file created at: " . date('Y-m-d H:i:s') . PHP_EOL);
	}

	/**
	 * Генерация пути для лог-файла с уникальным именем
	 *
	 * @return string
	 */
	protected function generateLogFilePath(): string
	{
		$timestamp = date('Y-m-d_H-i-s');
		return __DIR__ . "/../../storage/Logs/malCrawler_{$timestamp}.log";
	}

	/**
	 * Логирование сообщений в общий лог-файл.
	 *
	 * @param string $message
	 * @return void
	 */
	protected function logMessage(string $message): void
	{
		$logMessage = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
		file_put_contents($this->mainLogFile, $logMessage, FILE_APPEND);
	}

	protected function getPackageProviders($app): array
	{
		return [
		  MalCrawlerServiceProvider::class
		];
	}

	protected function getPackageAliases($app): array
	{
		return [
		  'MalCrawler' => \Vahe\MalCrawler\Facades\MalCrawler::class,
		];
	}

	public function testExample()
	{
		$this->logMessage('Test message');
		$this->assertTrue(true);
	}

	/**
	 * Декодирует и валидирует JSON-ответ.
	 */
	protected function decodeAndValidateJson($response)
	{
		$decodedJson = json_decode($response->getContent(), true);
		$this->assertJson($response->getContent());
		$this->assertNotEmpty($decodedJson);
		return $decodedJson;
	}

	/**
	 * Сохраняет данные в файл в формате JSON.
	 */
	protected function saveResponseToFile($data, $filePath): void
	{
		if (!file_exists($filePath)) {
			$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			file_put_contents($filePath, $json);
		} else {
			$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			file_put_contents($filePath, $json);
		}
	}
}

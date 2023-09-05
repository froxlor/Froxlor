<?php

namespace Froxlor\Backup\Storages;

use Aws\S3\S3Client;
use Froxlor\FileDir;

class S3 extends Storage
{

	private S3Client $s3_client;

	/**
	 * @return bool
	 */
	public function init(): bool
	{
		$raw_credentials = [
			'credentials' => [
				'key' => $this->sData['storage']['username'] ?? '',
				'secret' => $this->sData['storage']['password'] ?? ''
			],
			'endpoint' => $this->sData['storage']['hostname'] ?? '',
			'region' => $this->sData['storage']['region'] ?? '',
			'version' => 'latest',
			'use_path_style_endpoint' => true
		];
		$this->s3_client = new S3Client($raw_credentials);
	}

	/**
	 * Move/Upload file from tmp-source-directory. The file should be moved or deleted afterward.
	 * Must return the (relative) path including filename to the backup.
	 *
	 * @param string $filename
	 * @param string $tmp_source_directory
	 * @return string
	 * @throws \Exception
	 */
	protected function putFile(string $filename, string $tmp_source_directory): string
	{
		$source = FileDir::makeCorrectFile($tmp_source_directory . "/" . $filename);
		$target = FileDir::makeCorrectFile($this->getDestinationDirectory() . "/" . $filename);
		$this->s3_client->putObject([
			'Bucket' => $this->sData['storage']['bucket'],
			'Key' => $target,
			'SourceFile' => $source,
		]);
	}

	/**
	 * @param string $filename
	 * @return bool
	 */
	protected function rmFile(string $filename): bool
	{
		$result = $this->s3_client->deleteObject([
			'Bucket' => $this->sData['storage']['bucket'],
			'Key' => $filename,
		]);

		if ($result['DeleteMarker']) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function shutdown(): bool
	{
		return true;
	}
}

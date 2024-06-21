<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// MinIOの接続情報
$credentials = [
  'key'    => 'portfolio',
  'secret' => 'portfolio',
];

// S3クライアントの設定
$s3 = new S3Client([
  'version'     => 'latest',
  'region'      => 'us-west-2',
  'endpoint'    => 'http://minio:9000',
  'use_path_style_endpoint' => true,
  'credentials' => $credentials,
]);

// ダウンロードするファイルの情報
$fileKey = "uploads/123";

// MinIOからファイルをダウンロード
try {
  $result = $s3->getObject([
    'Bucket' => 'portfolio',
    'Key'    => $fileKey,
  ]);

  // ファイルを出力
  header("Content-Type: {$result['ContentType']}");
  header('Content-Disposition: attachment; filename="' . basename($fileKey) . '"');
  echo $result['Body'] . PHP_EOL;
} catch (S3Exception $e) {
  echo "Error downloading file: " . $e->getMessage() . "\n";
}

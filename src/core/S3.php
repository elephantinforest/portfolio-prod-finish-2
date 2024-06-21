<?php

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3
{
    private $s3;
    private $bucket;

    public function __construct($bucket, $endpoint, $key, $secret, $region = 'us-west-2')
    {
        $this->bucket = $bucket;
        $credentials = [
            'key'    => $key,
            'secret' => $secret,
        ];

        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => $region,
            'endpoint'    => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => $credentials,
        ]);
    }

    public function uploadFile($filePath, $key, $acl = 'public-read')
    {
        try {
            $fileContent = file_get_contents($filePath);

            $result = $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $key,
                'Body'   => $fileContent,
                'ACL'    => $acl,
            ]);

            return "File uploaded successfully. Object URL: " . $result['ObjectURL'] . "\n";
        } catch (S3Exception $e) {
            return "Error uploading file: " . $e->getMessage() . "\n";
        }
    }

    public function downloadFile($fileKey)
    {
        try {
            // S3からファイルを取得
            $result = $this->s3->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $fileKey,
            ]);

            // バイナリデータとMIMEタイプを返す
            $result = [
                'Body' => (string) $result['Body'],
                'ContentType' => $result['ContentType'],
            ];
            // エラーが発生した場合
            if ($result === null) {
                return 'Error: Unable to download file';
            }

            // バイナリデータをBase64エンコード
            $base64Data = base64_encode($result['Body']);

            // MIMEタイプを取得
            $mimeType = $result['ContentType'];

            // Base64エンコードされたデータを含むデータURIを生成
            $dataUri = 'data:' . $mimeType . ';base64,' . $base64Data;

            return $dataUri;
        } catch (Aws\Exception\AwsException $e) {
            // エラー処理
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}

// // 使用例
// $uploader = new MinioUploader(
//     'portfolio',
//     'http://minio:9000',
//     'portfolio',
//     'portfolio'
// );

// // ファイルのアップロード
// $filePath = 'path/to/your/file'; // アップロードするファイルのパス
// $uploadKey = 'uploads/your_file_name'; // アップロード先のキー（ファイル名）
// echo $uploader->uploadFile($filePath, $uploadKey);

// // ファイルのダウンロード
// $downloadKey = 'uploads/123'; // ダウンロードするファイルのキー
// echo $uploader->downloadFile($downloadKey);

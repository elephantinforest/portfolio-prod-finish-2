<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * S3とのやり取りを行うクラス
 */
class S3
{
    /**
     * S3クライアント
     *
     * @var S3Client
     */
    private $s3;

    /**
     * バケット名
     *
     * @var string
     */
    private $bucket;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->bucket = 'portfolio-mononoke-imgs';

        // 環境変数から環境を取得
        $environment = 'deveent';

        // 開発環境の場合
        if ($environment == 'development') {
            $credentials = [
                'key'    => getenv('S3_ACCESS_KEY'),
                'secret' => getenv('S3_SECRET_KEY'),
            ];

            $this->s3 = new S3Client([
                'version'     => 'latest',
                'region'      => 'ap-northeast-1',
                'credentials' => $credentials,
            ]);
        } else {
            // 本番環境の場合
            $credentials = [
                'key'    => 'raziorazio',
                'secret' => 'raziorazio',
            ];

            $this->s3 = new S3Client([
                'version'     => 'latest',
                'region'      => 'ap-northeast-1',
                'use_path_style_endpoint' => true,
                'endpoint'    => 'http://minio:9000',
                'credentials' => $credentials,
            ]);
        }
    }

    /**
     * ファイルをS3にアップロードする
     *
     * @param string $filePath アップロードするファイルのパス
     * @param string $key アップロード先のキー（ファイル名）
     * @param string $acl アクセス制御リスト（デフォルトは'public-read'）
     *
     * @return string アップロード成功時はオブジェクトURL、失敗時はエラーメッセージ
     */
    public function uploadFile(string $filePath, string $key, string $acl = 'public-read'): string
    {
        try {
            // ファイルの内容を取得
            $fileContent = file_get_contents($filePath);

            // S3にファイルをアップロード
            $result = $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $key,
                'Body'   => $fileContent,
                'ACL'    => $acl,
            ]);

            // アップロード成功時のメッセージ
            return "File uploaded successfully. Object URL: " . $result['ObjectURL'] . "\n";
        } catch (S3Exception $e) {
            // エラー発生時のメッセージ
            return "Error uploading file: " . $e->getMessage() . "\n";
        }
    }

    /**
     * S3からファイルを取得する
     *
     * @param string $fileKey ダウンロードするファイルのキー
     *
     * @return string ダウンロード成功時はBase64エンコードされたデータURI、失敗時はnull
     */
    public function downloadFile(string $fileKey): ?string
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
            if (!isset($result)) {
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

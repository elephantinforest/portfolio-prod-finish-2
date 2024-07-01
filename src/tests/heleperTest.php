<?php

use PHPUnit\Framework\TestCase;

// require_once __DIR__ . './../core/heleper.php';
// require_once __DIR__ . './../core/S3.php';

/**
 * @covers summary
 */
class heleperTest extends TestCase
{
    protected $heleper;
    protected $s3;

    protected function setUp(): void
    {
        $this->heleper = new heleper();
        $this->s3 = new S3();
    }


    public function testCreatePath()
    {
        $imagePath = '/var/www/html/src/imgs/_a7bd503d-3993-46c1-a0a4-30657c277ff1.jpg'; // テスト用の画像ファイルのパスに置き換える
        $key ='test2.jpg';
        $imageData = 'Test image data'; // 仮の画像データ

        // 画像ファイルの内容をファイルに書き込む（仮の処理）
        file_put_contents($imagePath, $imageData);
        $s3 = $this->s3;
        $s3->uploadFile($imagePath,$key);
        // 画像ファイルのパス
      $filePath = 'portfolio-mononoke-imgs'.'/'. $key;


        // テスト対象のメソッドを呼び出す
        $result = $this->heleper->createPath($filePath, $s3);

        // 期待される結果を検証する
        $this->assertStringStartsWith('data:text/plain;base64,VGVzdCBpbWFnZSBkYXRh', $result); // MIMEタイプとBase64エンコードされたデータが含まれているかを検証する

        // テストが完了したら、テスト用の画像ファイルを削除する
        unlink($imagePath);
    }

    protected function tearDown(): void
    {
        $this->heleper = null;
    }
}

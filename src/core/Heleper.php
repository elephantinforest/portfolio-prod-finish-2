<?php

class Heleper
{
    /**
     * テストで動作しているチェックするための変数
     *
     * @var boolean
     */
    private $isTest = false;

    /**
     * クライアントサイドにerrorレスポンスの送信
     *
     * @param  string $error エラー内容
     * @return void
     */
    public function handleError(string $error): void
    {
        $response = ['success' => false, 'errors' => $error];
        header('Content-Type: application/json');
        echo json_encode($response);
        if (!$this->isTest) {
            exit();
        }
    }
    /**
     * クライアントサイドにJSONデータの送信
     *
     *
     * @param array<string, mixed> $data  連想配列の配列
     * @return void
     */
    public function sendResponse(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        if (!$this->isTest) {
            exit();
        }
    }
    /**
     * 画像パスからエンコードした画像を生成
     *
     * @param string $path S3などに置いてある画像パス
     * @return string エンコードされた画像ファイル
     */
    public function createPath(string $path): string
    {
        $imagePath = $path;
        $binaryData = file_get_contents($imagePath);
        $base64Data = base64_encode($binaryData);

        // MIMEタイプの取得
        $mimeType = mime_content_type($imagePath);

        // Base64エンコードされたデータを含むデータURIを生成
        $dataUri = 'data:' . $mimeType . ';base64,' . $base64Data;

        return $dataUri;
    }

    /**
     * S3に保存するファイルのパスを自動生成(レジスターディレクトリ)
     *
     * @param string $file ファイルパス
     * @return string registerディレクトリと日時が追加されてユニークな値になったファイルパスの作成
     */
    public function crateRegisterSaveFile(string $file): string
    {
        $upload_dir = 'register/';
        $saveFileName = date('YmdHis') . $file;
        $savePath = $upload_dir . $saveFileName;
        return $savePath;
    }

    /**
     * S3に保存するファイルのパスを自動生成(ロケーションディレクトリ)
     *
     * @param string $file ファイルパス
     * @return string locationディレクトリと日時が追加されてユニークな値になったファイルパスの作成
     */
    public function crateLocationSaveFile(string $file): string
    {
        $upload_dir = 'location/';
        $saveFileName = date('YmdHis') . $file;
        $savePath = $upload_dir . $saveFileName;
        return $savePath;
    }
    /**
     * 変数isTestをテスト環境で動かす為にtrueに変更
     *
     * @return void
     */
    public function isTestTrue(): void
    {
        $this->isTest = true;
    }
    /**
     * ウィンドウサイズが変更した時に合わせて画像サイズの変更
     *
     * @param array $registers{}
     * @param array $size{}
     * @return void
     */
    // public function changeSize(array $registers, array $size)
    // {
    //     $currentWidth = $size['windowWidth'];
    //     $currentHeight = $size['windowHeight'];
    //     foreach ($registers as $num => $value) {
    //         $data = [
    //             'width' => $value['width'],
    //             'height' => $value['height'],
    //             'top_position' => $value['top_position'],
    //         ];
    //         $registerWidth = $value['window_width'];
    //         $registerHeight = $value['window_height'];
    //         $scaleX = $currentWidth / $registerWidth;
    //         $scaleY = $currentHeight / $registerHeight;
    //         foreach ($data as $key => $value) {
    //             if ($key === 'width') {
    //                 $registers[$num][$key] = $value * $scaleX;
    //             } elseif ($key === 'height') {
    //                 $registers[$num][$key] = $value * $scaleY;
    //             } elseif ($key === 'top_position') {
    //                 $registers[$num][$key] = $value * $scaleY;
    //             }
    //         }
    //     }
    //     return $registers;
    // }
}

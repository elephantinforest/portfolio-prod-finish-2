<?php

require '/var/www/html/vendor/autoload.php';

use Gemini\Data\Blob;
use Gemini\Enums\MimeType;

class Google
{
    /**
     * @param string $imagePath 画像ファイルへのパス
     * @return array 成功した場合、JSONデータを表す配列を返します。
     * @psalm-return array<mixed>
     */
    public function getPictureJson(string $imagePath): array
    {
        try {
            $yourApiKey = getenv('API_KEY');
            // Gemini クラスのインスタンスを作成
            $gemini = new Gemini($yourApiKey);

            // インスタンスから client メソッドを呼び出す
            $client = $gemini->client($yourApiKey);

            $result = $client
                ->geminiProVision()
                ->generateContent([
                    'Please convert the following picture into JSON format. The JSON should include:

- `name`: Translated into Japanese.
- `genre`: Translated into Japanese.
- `price`: Translated into Japanese.

If the content is not fully clear, provide the closest possible information.',
                    new Blob(
                        mimeType: MimeType::IMAGE_JPEG,
                        data: base64_encode(
                            file_get_contents($imagePath)
                        )
                    )
                ]);
            $json = $result->text();
            $json = str_replace("`", "", $json);
            $json = str_replace("json", "", $json);
            $array = json_decode($json, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new Exception();
            }
            return $array;
        } catch (Exception $e) {
            throw new Exception('読み取りエラー発生！更新ボタンを押して再度入力フォームを確認してもう一度登録よろしくお願いします。', 0, $e);
        }
    }
}

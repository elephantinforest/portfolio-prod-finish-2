<?php

require '/var/www/html/vendor/autoload.php';

use Gemini\Data\Blob;
use Gemini\Enums\MimeType;

class Google
{
    public function getPictureJson($imagePath)
    {
        try {
            $yourApiKey = getenv('API_KEY');
            $client = Gemini::client($yourApiKey);

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
            return $array;
        } catch (ValueError) {
            throw new PDOException('読み取りエラー発生！入力フォームを確認してもう一度登録よろしくお願いします。');
        }
    }
}

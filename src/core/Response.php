<?php

class Response
{
    protected string $content;
    protected int $statusCode = 200;
    protected string $statusText = 'OK';


    /**
     * ヘッダーと生成されたファイルのレスポンス
     *
     * @return void
     */
    public function send(): void
    {
        if (!headers_sent()) {
            header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->statusText);
        }
        echo $this->content;
    }

    /**
     *
     *  レスポンスするコンテントのセット
     * @param string $content  PHPなどで生成されたファイル
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * ステータスコードのセット（200,404）
     *
     * @param int $statusCode レスポンスするコード
     * @param string $statusText レスポンスする内容
     * @return void
     */
    public function setStatusCode(int $statusCode, string $statusText): void
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }
    /**
     * コンテントの取得
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    /**
     * ステータスコードの取得
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    /**
     * ステータステキストの取得
     *
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->statusText;
    }
}

<?php

class View
{
    /**
     * @var string
     */
    protected string $baseDir;

    /**
     * @param string $baseDir
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * @param string $path
     * @return string
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
     * @param string $path
     * @param mixed $variables
     * @param mixed $layout
     * @return string
     */
    public function render(string $path, mixed $variables, mixed $layout = false): string
    {
        extract($variables);

        ob_start();
        require $this->baseDir . '/' . $path . '.php';
        // @phpmd-ignore-line
        $content = ob_get_clean();

        ob_start();
        require $this->baseDir . '/layout/' . $layout . '.php';
        $layout = ob_get_clean();

        return $layout;
    }

    /**
     * @return string
     */
    public function getBasedir(): string
    {
        return $this->baseDir;
    }
}

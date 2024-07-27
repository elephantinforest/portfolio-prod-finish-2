<?php

class Controller
{
    /**
     *コントローラーで実行するメソッド名
     *
     * @var string
     */
    protected string $actionName;
    /**
     * リクエストクラスオブジェクト
     *
     * @var Request
     */
    protected Request $request;
    /**
     * データベースマネージャクラスオブジェクト
     *
     * @var DatabaseManager
     */
    protected DatabaseManager $databaseManager;
    /**
     * ヘルパークラスオブジェクト
     *
     * @var Heleper
     */
    protected Heleper $Heleper;
    /**
     * ヘルパークラスオブジェクト
     *
     * @var Validation
     */
    protected Validation $validation;
    /**
     * S3クラスオブジェクト
     *
     * @var S3
     */
    protected S3 $s3;

    /**
     * アプリケーションクラスのオブジェクトを引数で受け取り初期化、引数のクラスのメソッドを使用してメンバ変数にクラスオブジェクトを挿入
     *
     * @param Application $application　アプリケーションクラスオブジェクト
     */

     /**
      * コンストラクター
      *
      * @param Application $application
      */
    public function __construct(Application $application)
    {
        $this->request = $application->getrequest();
        $this->databaseManager = $application->getDatabaseManager();
        $this->Heleper = $application->getHeleper();
        $this->validation = $application->getvalidation();
        $this->s3 = $application->getS3();
    }

    /**
     * 親クラスから呼び出されてコンテントをレスポンス
     *
     * @param string $action 親クラスで実行するメソッド名
     * @return string PHPなどで作成したファイルの中身
     */
    public function run(string $action): string
    {
        $this->actionName = $action;
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException();
        }
        $content = $this->$action();
        return $content;
    }

    /**
     *親コントローラークラスから呼び出されてviewファイルを使いクライアントサイドに返すコンテントの作成　引数を使いHTMLファイルの作成
     *
     * @param mixed $variables 呼び出し先から変数を受け取る。配列など
     * @param string|null $template 呼び出すviewファイル名
     * @param string $layout 呼び出すlayoutファイル名
     * @return string 生成されたHTMLファイル
     */
    protected function render(mixed $variables = [], string $template = null, string $layout = 'layout'): string
    {
        $view = new View(__DIR__ . '/../src/views');

        if (is_null($template)) {
            $template = $this->actionName;
        }
        $controllerName = strtolower(substr(get_class($this), 0, -10));
        $path = $controllerName . '/' . $template;
        return $view->render($path, $variables, $layout);
    }
}

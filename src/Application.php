<?php


class Application
{
    protected Request $request;
    protected Router $router;
    protected Response $response;
    protected DatabaseManager $databaseManager;
    protected HttpNotFoundException $httpNotFoundException;
    protected Heleper $Heleper;
    protected Validation $validation;
    protected S3 $s3;

    /**
     *
     *
     * @param array{hostname: string|false, username: string|false, password: string|false, database: string|false} $db
     */
    public function __construct($db)
    {
        $this->httpNotFoundException = new HttpNotFoundException();
        $this->router = new Router();
        $this->response = new Response();
        $this->request = new Request();
        $this->Heleper = new Heleper();
        $this->s3 = new S3();
        $this->validation = new Validation();
        $this->databaseManager = new DatabaseManager();
        $this->databaseManager->connect(
            [
                'hostname' => $db['hostname'],
                'username' => $db['username'],
                'password' => $db['password'],
                'database' => $db['database'],
            ]
        );
    }


    /**
     * アプリケーションの起動
     *
     * @return void
     */
    public function run(): void
    {

        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundException();
            }
            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundException) {
            $this->httpNotFoundException->render404Page($this->response);
        }
        $this->response->send();
    }

    public function getdatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }
    public function getRequest(): Request
    {
        return $this->request;
    }
    public function getHeleper(): Heleper
    {
        return $this->Heleper;
    }
    public function getvalidation(): Validation
    {
        return $this->validation;
    }
    public function getS3(): S3
    {
        return $this->s3;
    }
    /**
     *コントローラーが作成したファイル(HTML)のセット
     *
     * @param string $controllerName コントローラー名
     * @param string $action メソッド名
     * @return void
     */
    private function runAction(string $controllerName, string $action): void
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundException();
        }
        $controller = new  $controllerClass($this);
        $content = $controller->run($action);
        $this->response->setContent($content);
    }
}

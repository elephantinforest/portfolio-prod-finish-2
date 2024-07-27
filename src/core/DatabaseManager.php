<?php

class DatabaseManager
{
    /**
     * 初期化したデータベースモデルの格納
     *
     * @var array{object}
     */
    protected array $models;

    /**
     * 接続されたmysqlオブジェクトを格納
     *
     * @var mysqli
     */
    protected mysqli $mysqli;

    /**
     * mysqlに接続したオブジェクトを変数に格納
     *
     * @param mixed $params
     * @return void
     */
    public function connect(mixed $params): void
    {
        $mysqli = new mysqli($params['hostname'], $params['username'], $params['password'], $params['database']);

        if ($mysqli->connect_error) {
            throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
        }
        $this->mysqli = $mysqli;
    }

    /**
     * モデルネームを受け取りモデルクラスの初期化したものを配列に挿入
     *
     * @param string $modelName register,locationなどのmodel名
     * @return object モデルオブジェクト
     */
    public function get(string $modelName): object
    {
        if (!isset($this->models[$modelName])) {
            $model = new $modelName($this->mysqli);
            $this->models[$modelName] = $model;
        }

        return $this->models[$modelName];
    }

    /**
     * mysqlオブジェクトを渡す
     *
     * @return object 接続済みのmysqlオブジェクト
     */
    public function getMysqli(): object
    {
        return $this->mysqli;
    }

    // public function __destruct()
    // {
    //     $this->mysqli->close();
    // }
}

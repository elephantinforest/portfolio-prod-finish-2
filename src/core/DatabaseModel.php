<?php

/**
 * データベース操作をするクラス
 */
class DatabaseModel
{
    /**
     * データベースに接続したオブジェクト
     *
     * @var Mysqli $mysqli
     */
    protected Mysqli $mysqli;

    /**
     * mysqlオブジェクトを引数でもらいクラスの初期化
     *
     * @param Mysqli $mysqli
     */
    public function __construct(Mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }


    /**
     * クエリをもらいデータベースに挿入する関数
     *
     * @param string $sql 直接書かれたクエリストリング
     * @param array  <int|string|mixed>$params バインドする際に挿入する値
     * @return void
     */
    public function execute(string $sql, array $params = []): void
    {
        try {
            if ($params) {
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param(...$params);
                $stmt->execute();
                $stmt->close();
            }
        } catch (mysqli_sql_exception $e) {
            // データベース接続に関するエラーの場合
            // ブラウザにエラーメッセージを表示する
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * クエリをもらいデータベースから値を取得する関数
     *
     * @param string $sql
     * @param array  <int|string|mixed>$params バインドする際に挿入する値
     * @return array <int|string|mixed> クエリの結果
     * @throws PDOException SQL エラー発生時にスローされる
     */
    public function fetch(string $sql, array $params = []): array
    {
        if ($params) {
            try {
                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param(...$params);
                $stmt->execute();
                $result = $stmt->get_result();
                /* 値を取得します */
                $results = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                return $results;
            } catch (mysqli_sql_exception $e) {
                throw new PDOException($e->getMessage());
            }
        } else {
            throw new PDOException('値が渡されていません。');
        }
    }

    /**
     * 最後に挿入されたレコードの取得
     *
     * @return string 最後に挿入しIDの取得
     */
    public function getInsertId(): string
    {
        try {
            $result = $this->mysqli->query(' SELECT LAST_INSERT_ID()');

            if (!$result) {
                throw new mysqli_sql_exception($this->mysqli->error);
            }
            $insertId =  $result->fetch_all(MYSQLI_ASSOC);
            $result->free_result();
            return $insertId[0]['LAST_INSERT_ID()'];
        } catch (mysqli_sql_exception $e) {
            throw new PDOException($e->getMessage());
        }
    }
}

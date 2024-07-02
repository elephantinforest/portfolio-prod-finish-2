<?php
require_once '/var/www/html/src/migration/tablequery.php';
// データベース接続情報を環境変数から取得
$db = [
    'hostname' => getenv('MYSQL_HOST'),
    'username' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'database' => getenv('MYSQL_DATABASE'),
];
// データベースへの接続
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
   die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  throw new RuntimeException('mysqli接続エラー: ' . $mysqli->connect_error);
}
// テーブルを作成する関数の呼び出し
createTables($mysqli);

// データベース接続を閉じる
$mysqli->close();


// テーブルを作成する関数

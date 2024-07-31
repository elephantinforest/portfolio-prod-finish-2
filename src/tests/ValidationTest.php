<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../core/Validation.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Location.php';

/**
 * @covers summary
 */
class ValidationTest extends TestCase
{
    protected $validation;
    protected $mysqli;
    protected $locations;
    protected $location;



    protected function setUp(): void
    {
        $this->validation = new Validation();
        $this->mysqli = new mysqli('test_db', 'deveroper', 'pass', 'test_db');
        $this->mysqli->begin_transaction();
        $this->location = new Location($this->mysqli);
        $this->locations = [
            [
                'user_id' => 300,
                'location' => 'Tokyo',
                'file_name' => 'tmp.jpg',
                'save_path' => 'sample.jpg',
            ],
            [
                'user_id' => 300,
                'location' => 'サンプルじゃない部屋',
                'file_name' => 'tmptmp.jpg',
                'save_path' => 'samplesample.jpg',
            ],
            [
                'user_id' => 300,
                'location' => 'サンプルじゃない方の部屋',
                'file_name' => 'ore.jpg',
                'save_path' => 'oreore.jpg',
            ]
        ];
        $this->location->insert($this->locations[0]);
        // sleep(1); // 5秒間プログラムを停止
        $this->location->insert($this->locations[1]);
        // sleep(1); // 5秒間プログラムを停止
        $this->location->insert($this->locations[2]);
        // sleep(1); // 5秒間プログラムを停止
    }

    public function testUserValidation()
    {
        // モックの作成
        $stub = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['fetch'])
            ->getMock();

        // fetch メソッドが呼び出された場合の返り値を設定
        $stub->method('fetch')
            ->willReturnCallback(function ($query, $params) {
                // メールアドレスが 'test@example.com' の場合はユーザー情報を返す
                if ($query === "SELECT * FROM users WHERE email =?" && $params === ['s', 'taro@example.com']) {
                    return [['id' => 1, 'email' => 'test@example.com', 'name' => 'Test User']];
                } else {
                    // それ以外の場合は空の配列を返す（ユーザーが見つからない場合）
                    return [];
                }
            });

        $user = [
            'name' => '田中太郎',
            'email' => 'taro@example.com',
            'password' => 'password123',
            'passwordConfirm' => 'password123',
            'usermodel' => $stub
        ];
        $errors = $this->validation->userValidation($user);
        $this->assertEquals('メールアドレスが重複しています', $errors['model']); // 正しいエラーメッセージが返されているか
        $user = [
            'name' => '田中太郎',
            'email' => 'tao@example.com',
            'password' => 'password123',
            'passwordConfirm' => 'password123',
            'usermodel' => $stub
        ];
        $errors = $this->validation->userValidation($user);
        // $this->assertEquals('メールアドレスが重複しています', $errors['model']); // 正しいエラーメッセージが返されているか
        $this->assertEmpty($errors);
    }

    public function testFileValidation()
    {
        $files = [
            'size' => 1500333,
            'error' => 0,
            'name' => 'example.jpg',
            'tmp_name' => '/tmp/tmpfile.txt', // テスト用の一時ファイルを指定
            'savePath' => '/path/to/save/file.txt'
        ];
        $errors = $this->validation->fileValidation($files);
        $errors = array_filter($errors, function ($key) {
            return $key != 'tmpfile' && $key != 'move'; // 'tmpfile' または 'move' でないキーを残す
        }, ARRAY_FILTER_USE_KEY);

        $this->assertEmpty($errors);
    }


    public function testLoginValidation()
    {
        $user = [
            'email' => 'taro@example.com',
            'password' => 'password123'
        ];

        $errors = $this->validation->loginValidation($user);
        $this->assertEmpty($errors);
    }

    public function testLocationValidation()
    {

        $locationModel = $this->location;
        $userId = 300; // ユーザーID
        $location = 'Tokyo'; // ロケーション

        $errors = $this->validation->locationValidation($location, $userId, $locationModel);
        $this->assertNotEmpty($errors);
    }

    public function testValidateRegister()
    {
        $registers = [
            'name' => 'サンプル商品',
            'genre' => 'サンプルジャンル',
            'price' => 1000,
            'other' => 'サンプルメモ'
        ];

        $errors = $this->validation->validateRegister($registers);
        $this->assertEmpty($errors);
    }

    protected function tearDown(): void
    {
        $this->validation = null;
        $this->mysqli->rollback();
        $this->location = null;
        $this->mysqli = null;
        $this->locations = null;
    }
}

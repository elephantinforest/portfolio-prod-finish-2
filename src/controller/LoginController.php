<?php

class LoginController extends Controller
{
    /**
     * ユーザーのログイン処理
     *
     * @return string ユーザー画面を返す
     */
    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id(true);
        }
        // セッション関数のloggedinに値がなければ初期化
        if (!isset($_SESSION['loggedin'])) {
            $_SESSION['loggedin'] = false;
        }
        // ログインしているユーザーの処理
        if ($_SESSION['loggedin']) {
            $userId = $_SESSION['login_user']['id'];
            $locationModel = $this->databaseManager->get('Location');
            $registerModel = $this->databaseManager->get('Register');
            try {
                //ユーザーの保持しているロケーションを取得
                $location = $locationModel->fetchLocation($userId);

                if (empty($location)) {
                    $location = [
                        'location' =>  "ロケーションは登録されていません。",
                        'file_path' => $this->helper->createPath('/var/www/html/src/imgs/_a7bd503d-3993-46c1-a0a4-30657c277ff1.jpg'),
                        'location_id' =>  false,
                    ];
                    $registers = [];
                    return $this->render(
                        [
                            'title' => 'ユーザーのログイン',
                            'user' => $_SESSION['login_user'],
                            'errors' => [],
                            'registers' => $registers,
                            'locations' => $location,
                        ],
                        'user'
                    );
                }
                $s3 = $this->s3;
                $location['file_path'] = $s3->downloadFile($location['file_path']);
                //ユーザーの保持しているレジスターを取得
                $registers = $registerModel->fetchLocationRegister($userId, $location['location_id']);

                // ファイルパスが存在するレジスタに対してのみS3ダウンロードを実行
                $registers = array_map(function ($register) use ($s3) {
                    if (isset($register['file_path'])) {
                        $register['file_path'] = $s3->downloadFile($register['file_path']);
                    }
                    return $register;
                }, $registers);

                $registers = $registers ?: [];
              
                return $this->render(
                    [
                        'title' => 'ユーザーのログイン',
                        'user' => $_SESSION['login_user'],
                        'errors' => [],
                        'registers' => $registers,
                        'locations' => $location,
                    ],
                    'user'
                );
            } catch (Exception $e) {
                $this->helper->handleError($e->getMessage());
                return '';
            }
        } else {
            // POST以外の処理はログイン画面に戻す
            if (!$this->request->isPost()) {
                $errors = [];
                return $this->render(
                    [
                        'title' => 'ユーザーのログイン',
                        'errors' => $errors,
                    ],
                    'index',
                    'less'
                );
            }
            //POSTされた値でログイン処理
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = [
                'email' => $email,
                'password' => $password,
            ];

            //バリデーション処理
            $errors = $this->validation->loginValidation($user);
            $userModel = $this->databaseManager->get('User');
            $isUser = $userModel->fetchUser($email);
            // バリデーションエラーが無くユーザーが存在していたらログイン処理
            if (empty($errors) && $isUser) {
                $checkUser = password_verify($password, $isUser['password']);
                // パスワードが合っている
                if ($checkUser) {
                    $userId = $isUser['id'];
                    $locationModel = $this->databaseManager->get('Location');
                    $location = $locationModel->fetchLocation($userId);
                    // 配列が空ならerror回避のため初期化
                    if (empty($location)) {
                        $initialPath = $this->helper->createPath('/var/www/html/src/imgs/_a7bd503d-3993-46c1-a0a4-30657c277ff1.jpg');
                        $location = [];
                        $location = [
                            'location' =>  "ロケーションは登録されていません。",
                            'file_path' => $initialPath,
                            'location_id' => false,
                        ];
                        // セッション変数に状態を入力
                        $_SESSION['login_user'] = $isUser;
                        $_SESSION['loggedin'] = true;
                        $registers = [];
                        return $this->render(
                            [
                                'title' => 'ユーザーのログイン',
                                'user' => $isUser,
                                'errors' => [],
                                'registers' => $registers,
                                'locations' => $location,
                            ],
                            'user'
                        );
                    }
                    $s3 = $this->s3;
                    $location['file_path'] = $s3->downloadFile($location['file_path']);
                    $registerModel = $this->databaseManager->get('Register');
                    $registers = $registerModel->fetchLocationRegister($userId, $location['location_id']);
                    // 配列が空ならerror回避のため初期化
                    if (empty($registers)) {
                        $registers = [];
                    } else {
                        foreach ($registers as $key => $value) {
                            if (isset($value['file_path'])) {
                                $registers[$key]['file_path'] = $s3->downloadFile($value['file_path']);
                            }
                        }
                    }
                    // セッション変数に状態を入力
                    $_SESSION['login_user'] = $isUser;
                    $_SESSION['loggedin'] = true;
                    return $this->render(
                        [
                            'title' => 'ユーザーのログイン',
                            'user' => $isUser,
                            'errors' => [],
                            'registers' => $registers,
                            'locations' => $location,
                        ],
                        'user'
                    );
                }
                // パスワード合っていない
                else {
                    $errors['login'] = 'パスワードが一致しませんでした。';
                }
            }
            // メールアドレスとパスワードが合っていない
            else {
                $errors['login'] = 'メールアドレスとパスワードが一致しませんでした。ログインならず、、、';
            }
            return $this->render(
                [
                    'title' => 'ユーザーのログイン',
                    'errors' => $errors,
                ],
                'index',
                'less'
            );
        }
    }
}

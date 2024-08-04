<?php

class AcountController extends Controller
{
    /**
     * アカウントを登録する
     *
     * @return mixed
     */
    public function index(): mixed
    {
        //ゲットリクエストだとページを戻す
        if (!$this->request->isPost()) {
            return $this->render(
                [
                    'title' => 'ユーザーの登録',
                    'errors' => [],
                ],
                'index',
                'layout_less'
            );
        }

        //投稿したいデータ取得
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['password-confirm'];
        //モデル取得
        $userModel = $this->databaseManager->get('User');
        $user = [
            'name' =>  $name,
            'email' => $email,
            'password' => $password,
            'passwordConfirm' => $passwordConfirm,
            'usermodel' => $userModel
        ];

        //投稿したデータのバリデーション処理
        $errors = $this->validation->uservalidation($user);
        //バリデーションエラー無かったらユーザーアカウント作成
        if (empty($errors)) {
            try {
                $userModel->insert($_POST['name'], $_POST['email'], password_hash($password, PASSWORD_DEFAULT));
                session_start();
                $_SESSION['login_user'] = $userModel->fetchUser($email);
                $_SESSION['loggedin'] = true;
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
            } catch (Exception $e) {
                $this->helper->handleError($e->getMessage());
                return '';
            }
        }
        //バリデーションエラーあればアカウント作成画面に戻る
        return $this->render([
            'title' => 'ユーザーの登録',
            'errors' => $errors,
            'user' => $user,
        ], 'index', 'layout_less');
    }

    public function guestLogin(): mixed
    {
        $name = "ゲストユーザー";
        session_start();
        $_SESSION['login_user'] =
            [
                'name' =>  $name,
                'id' =>  rand(1000, 9999)
            ];

        $_SESSION['loggedin'] = true;
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
}

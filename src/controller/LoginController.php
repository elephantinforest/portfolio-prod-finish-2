<?php

class LoginController extends Controller
{
    /**
     * ユーザーのログイン処理
     *
     * @return string ユーザー画面を返す
     */
    public function index(): string
    {
        // セッション開始
        $this->startSession();

        // ログイン済みユーザーの処理
        if ($this->isLoggedIn()) {
            return $this->renderLoggedInUser();
        }

        // POST以外の処理はログイン画面に戻す
        if (!$this->request->isPost()) {
            return $this->renderLoginView();
        }

        // POSTされた値でログイン処理
        $email = $_POST['email'];
        $password = $_POST['password'];

        // バリデーション処理
        $errors = $this->validation->loginValidation(['email' => $email, 'password' => $password]);

        // バリデーションエラーがなければデータベースからユーザー情報を取得
        if (empty($errors)) {
            $userModel = $this->databaseManager->get('User');
            $user = $userModel->fetchUser($email);

            // ユーザーが存在すればパスワードを検証
            if ($user && password_verify($password, $user['password'])) {
                // ログイン成功
                $this->setSessionData($user);
                return $this->renderLoggedInUser();
            }

            // パスワードが一致しない
            $errors['login'] = 'パスワードが一致しませんでした。';
        }

        // ログイン失敗
        return $this->renderLoginView($errors);
    }

    /**
     * セッションを開始する
     *
     * @return void
     */
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            session_regenerate_id(true);
        }
    }

    /**
     * ログイン済みかどうか判定する
     *
     * @return bool ログイン済みならtrue
     */
    private function isLoggedIn(): bool
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
    }

    /**
     * ログイン済みユーザーの画面をレンダリングする
     *
     * @return string ユーザー画面
     */
    private function renderLoggedInUser(): string
    {
        $userId = $_SESSION['login_user']['id'];
        $locationModel = $this->databaseManager->get('Location');
        $registerModel = $this->databaseManager->get('Register');

        try {
            // ユーザーのロケーションを取得
            $location = $locationModel->fetchLocation($userId);

            // ロケーションが存在しない場合は初期値を設定
            if (empty($location)) {
                $initialPath = $this->Heleper->createPath('/var/www/html/src/imgs/_a7bd503d-3993-46c1-a0a4-30657c277ff1.jpg');
                $location = [
                    'location' =>  "ロケーションは登録されていません。",
                    'file_path' => $initialPath,
                    'location_id' => false,
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

            // S3から画像をダウンロード
            $s3 = $this->s3;
            $location['file_path'] = $s3->downloadFile($location['file_path']);

            // ユーザーのレジスターを取得
            $registers = $registerModel->fetchLocationRegister($userId, $location['location_id']);

            // レジスターの画像をS3からダウンロード
            foreach ($registers as $key => $value) {
                if (isset($value['file_path'])) {
                    $registers[$key]['file_path'] = $s3->downloadFile($value['file_path']);
                }
            }

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
            $this->Heleper->handleError($e->getMessage());
        }
    }

    /**
     * ログイン画面をレンダリングする
     *
     * @param array $errors エラーメッセージ
     * @return string ログイン画面
     */
    private function renderLoginView(array $errors = []): string
    {
        return $this->render(
            [
                'title' => 'ユーザーのログイン',
                'errors' => $errors,
            ],
            'index',
            'less'
        );
    }

    /**
     * セッションデータを設定する
     *
     * @param array $user ユーザー情報
     * @return void
     */
    private function setSessionData(array $user): void
    {
        $_SESSION['login_user'] = $user;
        $_SESSION['loggedin'] = true;
    }
}


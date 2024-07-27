<?php

/**
 * ログアウト処理
 */
class LogoutController extends Controller
{
    /**
     * ログアウト処理
     *
     * @return string
     */
    public function index(): string
    {
        $errors = [];
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
      // if (!$_SESSION['loggedin']) {
      //   session_destroy();

      //   return $this->render([
      //     'title' => '所持品の登録',
      //     'errors' => [
      //       'message' => "ログインしな!"
      //     ],'index','less'
      //   ]);
      // }

        session_destroy();
        return $this->render(
            [
            'title' => 'ユーザーのログイン',
            // 'user' => $user,
            'errors' => $errors,
            ],
            'index',
            'less'
        );
    }
}

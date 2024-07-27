<?php


class SearchController extends Controller
{

    /**
     * 検索ワードしたワードをインデックスにして表示
     *
     * @return mixed
     */
    public function index(): mixed
    {
        // セッションを開始する
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // ログインしていない場合はログインページにリダイレクト
        if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
            return $this->render([
                'title' => '所持品の登録',
                'errors' => [
                    "ログインしないとはいれないで！しょうもないことすな"
                ],
            ], 'login');
        }

        try {
            // ユーザーIDを取得
            $userId = $_SESSION['login_user']['id'];
            $searchWord = $_GET['search'] ?? '';
            $searchString = '%' . $searchWord . '%';

            // 検索モデルを取得
            $searchModel = $this->databaseManager->get("Search");
            // 検索を実行
            $registers = $searchModel->searchRegisters($userId, $searchString);

            // 画像ファイルをS3からダウンロード
            foreach ($registers as $key => $value) {
                $imagePath = $value['file_path'];
                $s3 = new S3();
                $imagePath = $s3->downloadFile($imagePath);
                $registers[$key]['file_path'] = $imagePath;
            }

            // ユーザー情報と検索結果をビューに渡す
            $user = $_SESSION['login_user'];
            $count = count($registers);
            return $this->render(
                [
                    'title' => 'ユーザーのログイン',
                    'registers' => $registers,
                    'user' => $user,
                    'word' => $searchWord,
                    'count' => $count,
                ],
                'index',
                'layout_less'
            );
        } catch (Exception $e) {
            // エラー処理
            $this->Heleper->handleError($e->getMessage());
            return '';
        }
    }
}

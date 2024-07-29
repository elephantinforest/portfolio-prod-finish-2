<?php

class LocationsController extends Controller
{
    public function index(): void
    {
        /**
         * ロケーションを登録する
         *
         * @return type json
         */
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //ポストされたファイルの取得
        $userId = $_SESSION['login_user']['id'];
        $location = $_POST['location'];
        $files = $_FILES['image'];
        $fileName = basename($files['name']);
        //日付などをつけてユニークはパス名を作る
        $savePath = $this->Heleper->crateLocationSaveFile($fileName);
        $files['savePath'] = $savePath;
        //バリデーション処理
        $locationModel = $this->databaseManager->get('Location');
        $locationErrors = $this->validation->locationValidation($location, $userId, $locationModel);
        $fileErrors = $this->validation->fileValidation($files);
        //エラー無かったらDBに登録してブラウザにJSONを返す
        if (empty($locationErrors) && empty($fileErrors)) {
            try {
                //配列にまとめる
                $locations = [
                    'user_id' => $userId,
                    'location' => $location,
                    'file_name' => $fileName,
                    'save_path' => $savePath,
                ];
                //ロケーションテーブルにレコード作成
                $locationModel->insert($locations);
                //S3にアップロード
                // $this->s3 = new S3(
                //     'portfolio',
                //     'http://minio:9000',
                //     'portfolio',
                //     'portfolio');
                $filePath = $files['tmp_name']; // アップロードするファイルのパス
                $uploadKey = $savePath; // アップロード先のキー（ファイル名)
                $s3 = $this->s3;
                $s3->uploadFile($filePath, $uploadKey);
                //画像ファイルエンコード
                $savePath = $this->s3->downloadFile($savePath);
                //インサートしたロケーションIDの取得
                $locationId = $locationModel->getInsertId();
                //ブラウザに返すJSON
                $data = ['success' => true, 'imageUrl' => $savePath, 'locationValue' => $location, 'locationId' => $locationId];
                $this->Heleper->sendResponse($data);
            } catch (Exception $e) {
                $this->Heleper->handleError($e->getMessage());
            }
        } else {
            // $errors = array_merge($locationErrors, $fileErrors);
            $this->Heleper->handleError('バリデーションerror発生');
        }
    }

    /**
     * 次ボタン、前ボタンを押した時の処理
     *
     * @return mixed
     */
    public function return(): mixed
    {
        /**
         * ユーザーIDに紐づくロケーションを取得する
         *
         * @return type json
         */
        if ($this->request->isPost()) {
            return $this->render([
                'title' => '所持品の登録',
                'errors' => [],
            ]);
        }
        session_start();
        $status = $_SERVER['REDIRECT_URL'];
        $userId = $_SESSION['login_user']['id'];
        $locationId = (int) $_GET['locationId'];
        $locationModel = $this->databaseManager->get('Location');
        $registerModel = $this->databaseManager->get('Register');
        if ($status === '/prev') {
            try {
                $location = $locationModel->prevReturn($locationId, $userId);
                if (empty($location)) {
                    $this->Heleper->handleError('それ以上クリックはできません。');
                    return '';
                }
                $locationId = $location['location_id'];
                $registers = $registerModel->fetchLocationRegister($userId, $locationId);
                if (!empty($registers)) {
                    foreach ($registers as $num => $register) {
                        foreach ($register as $key => $value) {
                            if ($key == 'file_path') {
                                $registers[$num]['file_path'] = $this->s3->downloadFile($value);
                            }
                        }
                    }
                }
                $location['file_path'] = $this->s3->downloadFile($location['file_path']);
                $data = ['success' => true, 'locations' => $location, 'registers' => $registers];
                $this->Heleper->sendResponse($data);
                return '';
            } catch (Exception $e) {
                $this->Heleper->handleError($e->getMessage());
                return '';
            }
        } else {
            try {
                $location = $locationModel->nextReturn($locationId, $userId);
                if (empty($location)) {
                    $this->Heleper->handleError('それ以上クリックはできません。');
                    return '';
                }
                $locationId = $location['location_id'];
                $registers = $registerModel->fetchLocationRegister($userId, $locationId);
                if (!empty($registers)) {
                    foreach ($registers as $num => $register) {
                        foreach ($register as $key => $value) {
                            if ($key == 'file_path') {
                                $registers[$num]['file_path'] = $this->s3->downloadFile($value);
                            }
                        }
                    }
                }
                $location['file_path'] = $this->s3->downloadFile($location['file_path']);
                $data = ['success' => true, 'locations' => $location, 'registers' => $registers];
                $this->Heleper->sendResponse($data);
                return '';
            } catch (Exception $e) {
                $this->Heleper->handleError($e->getMessage());
                return '';
            }
        }
    }
}

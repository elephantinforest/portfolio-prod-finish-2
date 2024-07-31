<?php

class ResizeController extends Controller
{
    /**
     * DBに変更した画像サイズを登録
     *
     * @return mixed
     */
    public function index(): mixed
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!$_SESSION['loggedin']) {
            return $this->render([
                'title' => '所持品の登録',
                'errors' => [
                    "ログインしないとはいれないで！しょうもないことすな"
                ],
            ], 'login');
        }
        $data = $_POST['data'];
        $resizeModel = $this->databaseManager->get('Resize');
        $registerId = $data['registerId'];
        $existID = $resizeModel->existId($registerId);
        if (isset($_POST['test'])) {
            $this->helper->isTestTrue();
        }
        if ($existID) {
            try {
                $resizeModel->update($data);
                $data = [
                    'succes' => true
                ];
                $this->helper->sendResponse($data);
                return '';
            } catch (Exception $e) {
                $this->helper->handleError($e->getMessage());
                return '';
            }
        } else {
            try {
                $resizeModel->insert($data);
                $data = [
                    'succes' => true
                ];
                $this->helper->sendResponse($data);
                return '';
            } catch (Exception $e) {
                $this->helper->handleError($e->getMessage());
                return '';
            }
        }
    }
}

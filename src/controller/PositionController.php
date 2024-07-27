<?php

class PositionController extends Controller
{
    /**
     * ドラッグした画像の座標をDBに登録する処理
     *
     * @return void
     */
    public function index()
    {
        // if ($this->request->isPost()) {
        //     return $this->render([
        //         'title' => '所持品の登録',
        //         'errors' => [],
        //     ]);
        // }
        $x_Position = number_format($_POST['x'], 6, '.', '');
        $y_Position = number_format($_POST['y'], 6, '.', '');
        $registerId = $_POST['register_id'];
        $windowWidth = $_POST['windowWidth'];
        $windowHeight = $_POST['windowHeight'];
        error_reporting(0);

        $registers = [
            'x' => $x_Position,
            'y' => $y_Position,
            'registerId' => $registerId,
        ];
        $windowSize = [
            'registerId' => $registerId,
            'window_width' => $windowWidth,
            'window_height' => $windowHeight,
        ];
        $resizeModel = $this->databaseManager->get('Resize');
        $positionModel = $this->databaseManager->get('Position');
        try {
            $exitRegister = $positionModel->checkRegisterId($registerId);
            if ($exitRegister) {
                $positionModel->updatePosition($registers);
            } else {
                $positionModel->insertPosition($registers);
            }
            $resizeModel->updateWindowSize($windowSize);
            $data = ['success' => true, 'position' => $registers];
            header('Content-Type: application/json;');
            echo json_encode($data);
            if (!isset($_POST['test'])) {
                exit();
            }
        } catch (Exception $e) {
            $this->Heleper->handleError($e->getMessage());
        }
    }
}

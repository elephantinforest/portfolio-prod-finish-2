<?php

class Resize extends DatabaseModel
{
    /**
     * レコードを取得する
     *
     * @param int $registerId レコードID
     * @return array{register_id: int, width: int, height: int}|null 取得したレコード、存在しない場合はnull。
     */
    public function fetchResize(int $registerId): ?array
    {
        $resize = $this->fetch("SELECT register_id, width, height FROM resizes  WHERE register_id = ? ", ['i', $registerId]);
        return empty($resize) ? null : $resize[0];
    }

    /**
     * 新規レコードを挿入する
     *
     * @param array{registerId: int, width: int, height: int, window_width: int, window_height: int} $data 挿入するデータ。
     * @return void
     */
    public function insert(array $data): void
    {
        $this->execute('INSERT INTO resizes (register_id, width, height, window_width, window_height) VALUES (?,?,?,?,?)', ['iiiii', $data['registerId'], $data['width'],  $data['height'], $data['window_width'], $data['window_height']]);
    }

    /**
     * IDが存在するか確認する
     *
     * @param int $registerId レコードID
     * @return bool IDが存在する場合はtrue、存在しない場合はfalse
     */
    public function existId(int $registerId): bool
    {
        $existId = $this->fetch("SELECT register_id FROM resizes  WHERE register_id = ? ", ['i', $registerId]);
        return !empty($existId[0]);
    }

    /**
     * レコードを更新する
     *
     * @param array{registerId: int, width: int, height: int, windowWidth: int, windowHeight: int} $data 更新するデータ。
     * @return void
     */
    public function update(array $data): void
    {
        $this->execute('UPDATE resizes SET  width = ? , height = ? , window_width = ? , window_height = ? WHERE register_id = ?', ['iiiii', (int) $data['width'], (int) $data['height'], (int) $data['windowWidth'], (int)$data['windowHeight'], (int)  $data['registerId'],]);
    }

    /**
     * ウィンドウサイズを更新する
     *
     * @param array{registerId: int, window_width: int, window_height: int} $data 更新するデータ。
     * @return void
     */
    public function updateWindowSize(array $data): void
    {
        $this->execute('UPDATE resizes SET  window_width = ? , window_height = ? WHERE register_id = ?', ['iii', $data['window_width'], $data['window_height'], $data['registerId'],]);
    }

    /**
     * レコードを削除する
     *
     * @param int $registerId レコードID
     * @return void
     */
    public function delete(int $registerId): void
    {
        $this->execute('DELETE  FROM resizes  WHERE register_id = ?', ['i', $registerId]);
    }
}

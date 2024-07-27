<?php
/**
 * ポジションの処理
 */
class Position extends DatabaseModel
{
    /**
     * レジスタIDから位置情報を取得します。
     *
     * @param int $registerId レジスタID
     * @return array{registerId: int, x: int, y: int} 位置情報
     */
    public function fetchPosition(int $registerId): array
    {
        $existPosition = $this->fetch("SELECT * FROM positions WHERE register_id = ?", ['i', $registerId]);
        return [
            'registerId' => $existPosition[0]['register_id'],
            'x' => $existPosition[0]['left_position'],
            'y' => $existPosition[0]['top_position'],
        ];
    }

    /**
     * レジスタの位置情報を挿入します。
     *
     * @param array{registerId: int, x: int, y: int} $registers レジスタ情報
     * @return void
     */
    public function insertPosition(array $registers): void
    {
        $this->execute('INSERT INTO positions (register_id, left_position, top_position) VALUES (?,?,?)', ['idd', $registers['registerId'], $registers['x'],  $registers['y']]);
    }

    /**
     * レジスタIDが存在するか確認します。
     *
     * @param int $registerId レジスタID
     * @return bool レジスタIDが存在する場合はtrue、存在しない場合はfalse
     */
    public function checkRegisterId(int $registerId): bool
    {
        $existPosition = $this->fetch("SELECT COUNT(register_id) FROM positions WHERE register_id = ?", ['i', $registerId]);
        return (bool) $existPosition[0]['COUNT(register_id)'];
    }

    /**
     * レジスタの位置情報を更新します。
     *
     * @param array{registerId: int, x: int, y: int} $registers レジスタ情報
     * @return void
     */
    public function updatePosition(array $registers): void
    {
        $this->execute('UPDATE positions SET left_position = ?, top_position = ? WHERE register_id = ?', ['ddi', $registers['x'], $registers['y'], $registers['registerId']]);
    }

    /**
     * レジスタの位置情報を削除します。
     *
     * @param int $registerId レジスタID
     * @return void
     */
    public function deletePosition(int $registerId): void
    {
        $this->execute('DELETE FROM positions WHERE register_id = ?', ['i', $registerId]);
    }
}

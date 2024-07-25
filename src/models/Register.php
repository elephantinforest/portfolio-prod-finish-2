<?php

class Register extends DatabaseModel
{
    /**
     * ユーザーが所有しているロケーションIDのレジスターアイテムを取得する。
     *
     * @param int $userId ユーザーID
     * @param int $locationId ロケーションID
     *
     * @return array<array{register_id: int, user_id: int, location_id: int, name: string, genre: string, price: string, other: string, file_path: string, left_position: int, top_position: int, width: int, height: int, window_width: int, window_height: int}> レジスターアイテムの配列
     */
    public function fetchLocationRegister(int $userId, int $locationId): array
    {
        return $this->fetch(
            'SELECT r.register_id, r.user_id, r.location_id, r.name, r.genre, r.price, r.other, r.file_path, p.left_position, p.top_position, rs.width, rs.height, rs.window_width, rs.window_height
            FROM registers AS r
            INNER JOIN positions AS p ON r.register_id = p.register_id
            LEFT JOIN resizes AS rs ON r.register_id = rs.register_id
            WHERE user_id = ? AND location_id = ?',
            ['ii', $userId, $locationId]
        );
    }

    /**
     * レジスターIDを使って一つのアイテムを取得する。
     *
     * @param string $registerId レジスターID
     *
     * @return array{register_id: int, user_id: int, location_id: int, name: string, genre: string, price: string, other: string, file_path: string}|null レジスターアイテムの配列、またはアイテムが見つからない場合はnull
     */
    public function fetchRegister(string $registerId): ?array
    {
        $register = $this->fetch(
            'SELECT register_id, user_id, location_id, name, genre, price, other, file_path
            FROM registers
            WHERE register_id = ?',
            ['i', $registerId]
        );

        return empty($register) ? null : $register[0];
    }

    /**
     * レジスターIDを使って更新用のアイテムを取得する。
     *
     * @param string $registerId レジスターID
     *
     * @return array<array{register_id: int, user_id: int, location_id: int, name: string, genre: string, price: string, other: string, file_path: string, location: string}>|null
     *  検索結果が存在する場合は、登録情報を含む配列を返します。
     *  存在しない場合はnullを返します。
     */
    public function fetchUpdateRegister(string $registerId): ?array
    {
        $register = $this->fetch(
            'SELECT register_id, r.user_id, r.location_id, name, genre, price, other, l.location
            FROM registers AS r
            INNER JOIN locations AS l ON r.location_id = l.location_id
            WHERE register_id = ?',
            ['i', $registerId]
        );

        return empty($register) ? null : $register[0];
    }

    /**
     * 新しいレジスターアイテムを挿入する。
     *
     * @param array{user_id: int, location_id: int, name: string, genre: string, price: string, other: string, file_name: string, file_path: string} $registers レジスターアイテムの配列
     *
     * @return void
     */
    public function insert(array $registers): void
    {
        $this->execute(
            'INSERT INTO registers (user_id, location_id, name, genre, price, other, file_name, file_path)
            VALUES (?,?,?,?,?,?,?,?)',
            ['iississs', $registers['user_id'], $registers['location_id'], $registers['name'], $registers['genre'], $registers['price'], $registers['other'], $registers['file_name'], $registers['file_path']]
        );
    }

    /**
     * レジスターアイテムのロケーションを更新する。
     *
     * @param int $locationId 新しいロケーションID
     * @param string $registerId レジスターID
     *
     * @return void
     */
    public function update(int $locationId, string $registerId): void
    {
        $this->execute(
            'UPDATE registers
            SET location_id = ?
            WHERE register_id = ?',
            ['ii', $locationId, $registerId]
        );
    }

    /**
     * レジスターアイテムを更新する。
     *
     * @param array{user_id: int, location_id: int, name: string, genre: string, price: int, other: string, file_name: ?string, file_path: ?string, register_id: int} $register レジスターアイテムの配列
     *
     * @return void
     */
    public function updateRegister(array $register): void
    {
        if (is_null($register['file_name'])) {
            $this->execute(
                'UPDATE registers
                SET name = ?, genre = ?, price = ?, other = ?
                WHERE register_id = ?',
                ['ssisi', $register['name'], $register['genre'], (int) $register['price'], $register['other'], (int) $register['register_id']]
            );
        } else {
            $this->execute(
                'UPDATE registers
                SET name = ?, genre = ?, price = ?, other = ?, file_name = ?, file_path = ?
                WHERE register_id = ?',
                ['ssisssi', $register['name'], $register['genre'], (int) $register['price'], $register['other'], $register['file_name'], $register['file_path'], (int) $register['register_id']]
            );
        }
    }

    /**
     * ユーザーとロケーションに基づいてレジスターアイテムのページネーションを取得する。
     *
     * @param int $userId ユーザーID
     * @param int $locationId ロケーションID
     *
     * @return array<array{register_id: int, name: string}> レジスターアイテムの配列
     */
    public function fetchPagenation(int $userId, int $locationId): array
    {
        return $this->fetch(
            'SELECT register_id, name
            FROM registers
            WHERE user_id = ? AND location_id = ?',
            ['ii', $userId, $locationId]
        );
    }

    /**
     * レジスターアイテムを削除する。
     *
     * @param int $registerId レジスターID
     *
     * @return void
     */
    public function delete(int $registerId): void
    {
        $this->execute(
            'DELETE FROM registers
            WHERE register_id = ?',
            ['i', $registerId]
        );
    }
}

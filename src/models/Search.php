<?php

class Search extends DatabaseModel
{
    /**
     * 指定されたユーザーIDと検索文字列に一致する登録情報を取得します。
     *
     * @param int $id ユーザーID
     * @param string $string 検索文字列
     * @return array<array{register_id: int, user_id: int, location_id: int, name: string, genre: string, price: string, other: string, file_path: string, location: string}>|null
     *  検索結果が存在する場合は、登録情報を含む配列を返します。
     *  存在しない場合はnullを返します。
     */
    public function searchRegisters(int $id, string $string): ?array
    {
        return $this->fetch(
            "SELECT r.register_id, r.user_id, r.location_id, r.name, r.genre, r.price, r.other, r.file_path, l.location
             FROM registers AS r
             INNER JOIN locations AS l ON r.location_id = l.location_id
             WHERE r.user_id = ? AND name LIKE ?",
            ['is', $id, $string]
        );
    }
}

<?php

class Location extends DatabaseModel
{
  /**
   * ユーザーIDと作成日時が最も古いロケーションを取得します。
   *
   * @param int $id ユーザーID
   * @return array<array{location_id: int, file_path: string, location: string}>|null 取得したロケーションの情報,存在しない場合はnull
   */
  public function fetchLocation(int $id): ?array
  {
    $location = $this->fetch("SELECT location_id, file_path, location FROM locations WHERE user_id = ? AND created_at = (SELECT MIN(created_at) FROM locations WHERE user_id = ?)", ['ii', $id, $id]);
    return $location ? $location[0] : null;
  }

  /**
   * ユーザーIDに紐づくすべてのロケーションを取得します。
   *
   * @param string $id ユーザーID
   * @return array<array{location_id: int, file_path: string, location: string}> 取得したロケーションの情報
   */
  public function fetchLocations(string $id): array
  {
    return $this->fetch("SELECT location_id, file_path, location FROM locations WHERE user_id = ?", ['i', $id]);
  }

  /**
   * ロケーションIDに紐づくロケーションを取得します。
   *
   * @param int $locationId ロケーションID
   * @return array{location_id: int, file_path: string, location: string}|null 取得したロケーションの情報、存在しない場合はnull
   */
  public function fetchUpdateLocation(int $locationId): ?array
  {
    $location = $this->fetch("SELECT location_id, file_path, location FROM locations WHERE location_id = ?", ['i', $locationId]);
    return $location ? $location[0] : null;
  }

  /**
   * ロケーション情報を登録します。
   *
   * @param array{user_id: int, location: string, file_name: string, save_path: string} $registers ロケーション情報
   * @return void
   */
  public function insert(array $registers): void
  {
    $this->execute('INSERT INTO locations (user_id, location, file_name, file_path) VALUES (?,?,?,?)', ['isss', $registers['user_id'], $registers['location'], $registers['file_name'], $registers['save_path']]);
  }

  /**
   * ユーザーが登録しているロケーションに重複がないかチェックします。
   *
   * @param int $userId ユーザーID
   * @param string $location ロケーション名
   * @return array<array{location: string}>|null 重複するロケーション情報、存在しない場合はnull
   */
  public function existLocation(int $userId, string $location): ?array
  {
    return $this->fetch('SELECT location FROM locations WHERE user_id =? AND location = ? ', ['is', $userId, $location]);
  }

  /**
   * 前のページのロケーション情報を取得します。
   *
   * @param int $locationId 現在のロケーションID
   * @param int $userId ユーザーID
   * @return array<array{location_id: int, file_path: string, location: string}>|null 取得したロケーションの情報、存在しない場合はnull
   */
  public function prevReturn(int $locationId, int $userId): ?array
  {
    $location = $this->fetch('SELECT * FROM locations WHERE created_at < (SELECT created_at FROM locations WHERE location_id = ?) AND user_id = ? ORDER BY created_at DESC LIMIT 1', ['ii', $locationId, $userId]);
    return $location ? $location[0] : null;
  }

  /**
   * 次のページのロケーション情報を取得します。
   *
   * @param int $locationId 現在のロケーションID
   * @param int $userId ユーザーID
   * @return array<array{location_id: int, file_path: string, location: string}>|null 取得したロケーションの情報、存在しない場合はnull
   */
  public function nextReturn(int $locationId, int $userId): ?array
  {
    $location = $this->fetch('SELECT * FROM locations WHERE created_at > (SELECT created_at FROM locations WHERE location_id = ?) AND user_id = ? ORDER BY created_at LIMIT 1', ['ii', $locationId, $userId]);
    return $location ? $location[0] : null;
  }

  /**
   * ロケーション情報を削除します。
   *
   * @param int $locationId ロケーションID
   * @return void
   */
  public function delete(int $locationId): void
  {
    $this->execute('DELETE FROM locations WHERE location_id = ?', ['s', $locationId]);
  }
}

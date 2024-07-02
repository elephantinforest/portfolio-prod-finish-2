<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/User.php';

class UserTest extends TestCase
{
  protected $user;
  protected $mysqli;


  public function setUp(): void
  {
    $this->mysqli = new mysqli('test_db', 'deveroper', 'pass', 'test_db');
    $this->mysqli->begin_transaction();
    $this->user = new User($this->mysqli);
    $user = [
      'name' => '五条悟',
      'email' => 'satoru@gmail.com',
      'password' => 'oreoreoo',
    ];
    $this->user->insert($user['name'], $user['email'], $user['password']);
  }

  protected function tearDown(): void
  {
    $delete_query = "DELETE FROM users";
    $this->mysqli->query($delete_query);
    $this->mysqli->rollback();
    $this->user = null;
    $this->mysqli = null;
  }

  public function testFetchUser()
  {
    $email = 'satoru@gmail.com';
    $actual = $this->user->fetchUser($email);
    $actual = [
      'name' => $actual['name'],
      'email' => $actual['email'],
      'password' => $actual['password']
    ];
    $expected =  [
        'name' => '五条悟',
        'email' => 'satoru@gmail.com',
        'password' => 'oreoreoo',
      ];
      $this->assertSame($actual, $expected);
  }
  public function testInsert()
  {
    $user = [
      'name' => '両目宿儺',
      'email' => 'sukuna@gmail.com',
      'password' => 'sukuna',
    ];
    $this->user->insert($user['name'], $user['email'], $user['password']);
    $email = 'sukuna@gmail.com';
    $actual = $this->user->fetchUser($email);
    $actual = [
      'name' => $actual['name'],
      'email' => $actual['email'],
      'password' => $actual['password']
    ];
    $expected =  [
      'name' => '両目宿儺',
      'email' => 'sukuna@gmail.com',
      'password' => 'sukuna',
    ];
    $this->assertSame($actual, $expected);
  }
}

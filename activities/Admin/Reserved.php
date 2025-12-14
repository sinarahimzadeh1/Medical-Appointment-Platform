<?php

namespace Admin;

use database\Database;

class Reserved extends Admin
{

  private function unformatNumber($formattedNumber)
  {
    return (int) str_replace(',', '', $formattedNumber);
  }

  private function customFormat($input)
  {
    return number_format((float) $input, 0, '.', ',');
  }

  public function index()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
    require_once(BASE_PATH . '/template/admin/reserved/index.php');
  }

  public function edit($id)
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
    $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
    $reserved = $db->select('SELECT * FROM reservedtimes WHERE id = ?', [$id])->fetch();
    $query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();
    require_once(BASE_PATH . '/template/admin/reserved/edit.php');
  }

  public function create()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
    $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
    $query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();
    require_once(BASE_PATH . '/template/admin/reserved/create.php');
  }

  public function update($request, $id)
  {
    $db = new DataBase();
    $query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();
    $request['price'] = $request['price'] == '0' || $request['price'] == '' ? $this->customFormat($query['Default']) : $request['price'];
    $request['price'] = $this->unformatNumber($request['price']);
    $db->update('reservedtimes', $id, array_keys($request), $request);
    $this->redirect('admin/reserved');
  }

  public function store($request)
  {
    function checkUserReserve($request)
    {
      $db = new DataBase();
      $number = ltrim($request['number'], '0');
      $user = $db->select('SELECT * FROM users WHERE number = ?', [$number])->fetch();
      if ($user != null) {

        unset($request['name']);
        $request['user_id'] = $request['number'];

        unset($request['number']);
        $request['user_id'] = $user['id'];

        $request['price'] = (int) str_replace(',', '', $request['price']);

        $db->insert('reservedtimes', array_keys(array_filter($request)), array_filter($request));
      } else {
        $request['number'] = ltrim($request['number'], '0');
        $db->insert('users', ['username', 'number', 'is_active'], [$request['name'], $request['number'], 1]);
        checkUserReserve($request);
      }
    }

    $db = new DataBase();

    $query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();
    $request['price'] = $request['price'] == '0' || $request['price'] == '' ? customFormat($query['Default']) : $request['price'];

    checkUserReserve($request);

    $this->redirect('admin/reserved');
  }

  public function delete($id)
  {
    $db = new DataBase();
    $reserve = $db->select('SELECT * FROM reservedtimes WHERE id = ?;', [$id])->fetch();
    $db->delete('reservedtimes', $id);
    $this->redirectBack();
  }
}
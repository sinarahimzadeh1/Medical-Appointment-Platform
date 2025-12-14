<?php

namespace Admin;

use database\Database;

class User extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        require_once(BASE_PATH . '/template/admin/users/index.php');
    }

    public function edit($id)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $user = $db->select('SELECT * FROM users WHERE id = ?;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/users/edit.php');
    }

    public function update($request, $id)
    {
        $db = new DataBase();
        $request = ['username' => $request['username'], 'number' => $request['number']];
        $db->update('users', $id, array_keys($request), $request);
        $this->redirect('admin/user');

    }

    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('users', $id);
        $this->redirect('admin/user');
    }

    public function changeActive($id)
    {
        $db = new DataBase();
        $isActive = $db->select("SELECT is_active FROM users WHERE id = ?", [$id])->fetch();
        if ($isActive['is_active'] == 1) {
            $db->update('users', $id, ['is_active'], [0]);
        } else {
            $db->update('users', $id, ['is_active'], [1]);
        }
        $this->redirectBack();
    }

    public function changePermission($id)
    {
        $db = new DataBase();
        $docID = $db->select("SELECT id FROM doctors WHERE id = ?", [$this->adminEnteredID])->fetch();
        $user = $db->select("SELECT permission FROM users WHERE id = ?", [$id])->fetch();
        if ($user['permission'] == "admin") {
            $db->update('users', $id, ['permission'], ["user"]);
            $db->update('users', $id, ['accessedByDoctorId'], [0]);
        } else {
            $db->update('users', $id, ['permission'], ["admin"]);
            $db->update('users', $id, ['accessedByDoctorId'], [$docID['id']]);
        }
        $this->redirectBack();
    }

}
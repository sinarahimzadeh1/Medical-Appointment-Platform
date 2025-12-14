<?php

namespace Admin;

use database\Database;

class Doctor extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
		$doctorCount = $db->select("SELECT COUNT(id) FROM `doctors`;")->fetch();
        require_once(BASE_PATH . '/template/admin/doctors/index.php');
    }

    public function edit($id)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $doctorr = $db->select('SELECT * FROM doctors WHERE id = ?;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/doctors/edit.php');
    }

    public function create()
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        require_once(BASE_PATH . '/template/admin/doctors/create.php');
    }

    public function store($request)
	{
		if (isset($request['number'])) {
			$number = trim($request['number']); 
			if (substr($number, 0, 1) === '0') {
				$number = substr($number, 1); 
			}
			$request['number'] = $number;
		}

		$request['experience'] = str_replace('/', '-', $request['experience']);
		$request['experience'] = substr($request['experience'], 0, 4);

		if (isset($request['profile']) && !empty($request['profile']['type'])) {
			$request['profile'] = $this->saveImage($request['profile'], 'user-image');
			if (!$request['profile']) {
				$request['profile'] = 'public/user-image/profile.jpg';
			}
		} else {
			$request['profile'] = 'public/user-image/profile.jpg';
		}

		$db = new DataBase();
		$db->insert('doctors', array_keys($request), $request);
		$this->redirect('admin/doctor');
	}


    public function update($request, $id)
	{
		$db = new DataBase();

		// حذف صفر از اول شماره
		if (isset($request['number'])) {
			$number = trim($request['number']); 
			if (substr($number, 0, 1) === '0') {
				$number = substr($number, 1); 
			}
			$request['number'] = $number;
		}

		// تبدیل سال تجربه به 4 رقم
		$request['experience'] = substr($request['experience'], 0, 4);

		// آپلود عکس فقط اگر واقعاً عکس جدید باشه و دیفالت نباشه
		if (isset($request['profile']['tmp_name']) && is_uploaded_file($request['profile']['tmp_name'])) {
			$doctor = $db->select('SELECT * FROM doctors WHERE id = ?;', [$id])->fetch();

			if ($doctor['profile'] !== 'public/user-image/profile.jpg') {
				$this->removeImage($doctor['profile']);
			}

			$request['profile'] = $this->saveImage($request['profile'], 'user-image');
		} else {
			unset($request['profile']);
		}

		$db->update('doctors', $id, array_keys($request), $request);
		$this->redirect('admin/doctor');
	}


    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('doctors', $id);
        $this->redirect('admin/doctor');
    }

}
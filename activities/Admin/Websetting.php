<?php

namespace Admin;

use database\Database;

class Websetting extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        require_once(BASE_PATH . '/template/admin/websetting/index.php');
    }


    public function edit()
    {
        $db = new DataBase();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $setting = $db->select('SELECT * FROM websetting;')->fetch();
        require_once(BASE_PATH . '/template/admin/websetting/edit.php');
    }

    public function update($request)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        if ($request['logo']['tmp_name'] != '') {
            $request['logo'] = $this->saveImage($request['logo'], 'setting', 'logo');
        } else {
            unset($request['logo']);
        }
        if ($request['icon']['tmp_name'] != '') {
            $request['icon'] = $this->saveImage($request['icon'], 'setting', 'icon');
        } else {
            unset($request['icon']);
        }
        
		if (isset($request['intro_image_1']) && $request['intro_image_1']['tmp_name'] != '') {
			$request['intro_image_1'] = $this->saveImage($request['intro_image_1'], 'setting', 'intro_image_1');
		} else {
			unset($request['intro_image_1']);
		}

		if (isset($request['intro_image_2']) && $request['intro_image_2']['tmp_name'] != '') {
			$request['intro_image_2'] = $this->saveImage($request['intro_image_2'], 'setting', 'intro_image_2');
		} else {
			unset($request['intro_image_2']);
		}

		if (isset($request['intro_image_3']) && $request['intro_image_3']['tmp_name'] != '') {
			$request['intro_image_3'] = $this->saveImage($request['intro_image_3'], 'setting', 'intro_image_3');
		} else {
			unset($request['intro_image_3']);
		}

        if (!empty($setting)) {
            $db->update('websetting', $setting['id'], array_keys($request), $request);
        } else {
            $db->insert('websetting', array_keys($request), $request);
        }
        
        $this->redirect('admin/websetting');
    }

}
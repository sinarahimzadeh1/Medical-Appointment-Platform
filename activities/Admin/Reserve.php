<?php

namespace Admin;

use database\Database;

class Reserve extends Admin
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
        $reserves = $db->select("SELECT * FROM reservedtimes")->fetchAll();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $workstationTimes = $db->select("SELECT * FROM reserves")->fetchAll();
        $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();

        require_once(BASE_PATH . '/template/admin/reserve/index.php');
    }

    public function create()
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctors = $db->select('SELECT id, name FROM doctors')->fetchAll();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        require_once(BASE_PATH . '/template/admin/reserve/create.php');
    }

    public function store($request)
    {
        $db = new DataBase();

        if (isset($request['time']) && is_array($request['time'])) {
            foreach ($request['time'] as $time) {
                $singleRow = $request;
                $singleRow['time'] = $time; 
                $singleRow['price'] = $this->unformatNumber($singleRow['price']);

                $filteredKeys = array_keys(array_filter($singleRow));
                $filteredValues = array_filter($singleRow);

                $db->insert('reserves', $filteredKeys, $filteredValues);
            }
        } else {
            $request['price'] = $this->customFormat($request['price']);
            $filteredKeys = array_keys(array_filter($request));
            $filteredValues = array_filter($request);

            $db->insert('reserves', $filteredKeys, $filteredValues);
        }


        $this->redirect('admin/reserve');
    }

    public function edit($id)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $doctors = $db->select('SELECT id, name FROM doctors')->fetchAll();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $reserves = $db->select('SELECT * FROM reserves WHERE id = ?;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/reserve/edit.php');
    }

    public function update($request, $id)
    {
        $db = new DataBase();
        $query = $db->select("SHOW COLUMNS FROM reserves LIKE 'price'")->fetch();
        $request['price'] = $request['price'] == '0' || $request['price'] == '' ? customFormat($query['Default']) : $request['price'];
        $request["time"] =  date('g:i', strtotime($request["time"]));;
        $db->update('reserves', $id, array_keys($request), $request);
        $this->redirect('admin/reserve');
    }

    public function delete($id)
    {
        $db = new DataBase();
        $reserve = $db->select('SELECT * FROM reserves WHERE id = ?;', [$id])->fetch();
        $this->removeImage($reserve['image']);
        $db->delete('reserves', $id);
        $this->redirectBack();
    }

    public function changePrice($request)
    {
        $db = new DataBase();
        $sql = $db->select("ALTER TABLE reserves ALTER COLUMN price SET DEFAULT ?", [$this->unformatNumber($request['new-price'])]);
        $this->redirectBack();
    }
}

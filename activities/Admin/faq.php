<?php

namespace Admin;

use database\Database;

class FAQ extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        require_once(BASE_PATH . '/template/admin/faq/index.php');
    }


    public function edit($id)
    {
        $db = new DataBase();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
        $doctorName = $db->select('SELECT name FROM doctors WHERE id = ?', [$id])->fetch();
        $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $faqs = $db->select("SELECT * FROM faq WHERE doctor_id = ?", [$id])->fetchAll();
        require_once(BASE_PATH . '/template/admin/faq/edit.php');
    }

    public function update($request, $id = null)
    {
        $db = new DataBase();

        $asks = $request['ask'];
        $answers = $request['answer'];
        $faq_ids = $request['faq_id'];
        $doctor_id = $request['doctor_id'];

        foreach ($asks as $index => $ask) {
            $answer = $answers[$index];
            $faq_id = $faq_ids[$index];

            if (!empty($faq_id)) {
                $db->update('faq', $faq_id, ['ask', 'answer'], [$ask, $answer]);
            } else {
                $db->insert('faq', ['ask', 'answer', 'doctor_id'], [$ask, $answer, $doctor_id]);
            }
        }

        $this->redirect('admin/faq');
    }


    public function delete($id)
    {
        $db = new DataBase();
        $result = $db->delete('faq', $id);
        $this->redirect('admin/faq');
    }


}
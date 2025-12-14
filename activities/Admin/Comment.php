<?php

namespace Admin;

use database\Database;

class Comment extends Admin
{

  public function index()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();
    require_once(BASE_PATH . '/template/admin/comments/index.php');
  }

  public function changeStatus($id)
  {
    $db = new DataBase();
    $comment = $db->select('SELECT * FROM comments WHERE id = ?;', [$id])->fetch();
    if (empty($comment)) {
      $this->redirectBack();
    }
    if ($comment['status'] == 'seen') {
      $db->update('comments', $id, ['status'], ['approved']);
    } else {
      $db->update('comments', $id, ['status'], ['seen']);
    }
    $this->redirectBack();
  }

  public function pinComment($id)
  {
    $db = new DataBase();
    $comment = $db->select('SELECT * FROM comments WHERE id = ?', [$id])->fetch();
    if (empty($comment)) {
      $this->redirectBack();
    }
    if ($comment['selected'] == 2) {
      $db->update('comments', $id, ['selected'], [1]);
    } else {
      $db->update('comments', $id, ['selected'], [2]);
    }
    $this->redirectBack();
  }

  public function commentDelete($id)
  {
    $db = new DataBase();
    $comment = $db->select('SELECT * FROM comments WHERE id = ?', [$id])->fetch();
    if (empty($comment)) {
      $this->redirectBack();
    }
    $db->delete('comments', $id);
    $this->redirectBack();
  }

}
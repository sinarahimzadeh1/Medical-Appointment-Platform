<?php

namespace Admin;

use database\Database;

class Dashboard extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $data = $db->select(" SELECT week, COUNT(*) AS count FROM reservedtimes WHERE doctor_id = ? GROUP BY week", [$this->adminEnteredID])->fetchAll();
        $setting = $db->select(sql: 'SELECT * FROM websetting')->fetch();
        $reservingTimes = $db->select('SELECT * FROM `reserves` WHERE doctor_id = ?', [$this->adminEnteredID])->fetchAll();
        $lastReservesTime = $db->select('SELECT * FROM `reserves` WHERE doctor_id = ? ORDER BY `reserves`.`id` DESC', [$this->adminEnteredID])->fetch();
        $lastReservedTime = $db->select('SELECT * FROM `reservedtimes` WHERE doctor_id = ? ORDER BY `date` DESC', [$this->adminEnteredID])->fetch();
        $reservedTimes = $db->select('SELECT date FROM `reservedtimes` WHERE doctor_id = ?', [$this->adminEnteredID])->fetchAll();
        $lastFourReservedTimes = $db->select('SELECT reservedtimes.*, users.username AS username, users.number AS number FROM `reservedtimes` JOIN users ON reservedtimes.user_id = users.id WHERE doctor_id = ? ORDER BY `date` DESC LIMIT 4', [$this->adminEnteredID])->fetchAll();
        $doctors = $db->select('SELECT * FROM doctors')->fetchAll();
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$this->adminEnteredID])->fetch();       
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
        $categoryCount = $db->select('SELECT COUNT(*) FROM categories')->fetch();
        $postCount = $db->select('SELECT COUNT(*) FROM posts')->fetch();
        $postsViews = $db->select('SELECT SUM(view) FROM posts')->fetch();
        $commentCount = $db->select('SELECT COUNT(*) FROM comments WHERE doctor_id = ?', [$this->adminEnteredID])->fetch();
        $commentSeenCount = $db->select('SELECT COUNT(*) FROM comments WHERE status = "seen"')->fetch();
        $commentUnseenCount = $db->select('SELECT COUNT(*) FROM comments WHERE status = "unseen"')->fetch();
        $commentApprovedCount = $db->select('SELECT COUNT(*) FROM comments WHERE status = "approved"')->fetch();
        $mostViewedPosts = $db->select('SELECT * FROM posts ORDER BY view DESC LIMIT 0,5')->fetchAll();
        $mostCommentedPosts = $db->select('SELECT posts.id, posts.title, COUNT(comments.post_id) AS comment_count FROM posts LEFT JOIN comments ON posts.id = comments.post_id GROUP BY posts.id ORDER BY comment_count DESC LIMIT 0,5')->fetchAll();
        $lastComments = $db->select('SELECT comments.id, comments.comment, comments.status, users.username FROM comments, users WHERE comments.user_id = users.id ORDER BY comments.created_at DESC LIMIT 0,5')->fetchAll();

        require_once(BASE_PATH . '/template/admin/dashboard/index.php');

    }


}
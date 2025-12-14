<?php

namespace Admin;

use Auth\Auth;
use database\Database;

class Admin
{
	public $currentDomain;
	public $basePath;
	public $adminEnteredID;

	function __construct()
	{
		$auth = new Auth();
		$auth->checkAdmin();
		$db = new DataBase();
		if (isset($_SESSION['userAsseccible'])) {
			$adminEnteredData = $db->select("SELECT name, id, number FROM doctors WHERE id = ?", [$_SESSION['userAsseccible']])->fetch();
			unset($_SESSION['userAsseccible']);
		} else {
			$adminEnteredData = $db->select("SELECT name, id, number FROM doctors WHERE number = ?", [$_SESSION['number']])->fetch();
		}
		$this->adminEnteredID = $adminEnteredData['id'];
		$this->currentDomain = CURRENT_DOMAIN;
		$this->basePath = BASE_PATH;
	}

	protected function redirect($url)
	{
		header('Location: ' . trim($this->currentDomain, '/ ') . '/' . trim($url, '/ '));
		exit;
	}

	protected function redirectBack()
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	protected function saveImage($image, $imagePath, $imageName = null)
	{
		if (!isset($image['type']) || empty($image['type'])) {
			return false;
		}

		$extensionParts = explode('/', $image['type']);
		$mimeType = $extensionParts[1] ?? 'jpeg';

		if ($imageName) {
			$filename = $imageName;
		} else {
			$filename = date("Y-m-d-H-i-s");
		}

		$webpName = $filename . '.webp';
		$imageTemp = $image['tmp_name'];
		$savePath = 'public/' . trim($imagePath, '/') . '/';

		if (!is_dir($savePath)) {
			mkdir($savePath, 0755, true);
		}

		$destination = $savePath . $webpName;

		// باز کردن تصویر بر اساس نوعش
		switch ($mimeType) {
			case 'jpeg':
			case 'jpg':
				$img = imagecreatefromjpeg($imageTemp);
				break;
			case 'png':
				$img = imagecreatefrompng($imageTemp);
				imagepalettetotruecolor($img);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				break;
			case 'gif':
				$img = imagecreatefromgif($imageTemp);
				break;
			default:
				return false;
		}

		if (!$img) {
			return false;
		}

		// فشرده‌سازی با کیفیت بالا
		if (imagewebp($img, $destination, 95)) { // مقدار ۹۵ برای حفظ کیفیت
			imagedestroy($img);
			return $destination;
		} else {
			imagedestroy($img);
			return false;
		}
	}

	protected function removeImage($path)
	{
		$path = trim($path, '/ ');
		if (file_exists($path)) {
			unlink($path);
		}
	}

}
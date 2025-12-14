<?php

namespace Auth;

use database\DataBase;
use App\Home;
use KavehnegarLookup\Kavehnegar;
use cookieManager\CookieManager;

class Auth
{

    protected function redirect($url)
    {
        header('Location: ' . trim(CURRENT_DOMAIN, '/ ') . '/' . trim($url, '/ '));
        exit;
    }

    protected function redirectBack()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    private function hash($password)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashPassword;
    }

    private function random()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function registerStore($request)
    {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        $db = new DataBase();

        $number = ltrim($request['number'], '0');
        $username = trim($request['username']);

        if (empty($number) || empty($username)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'تمامی فیلد ها اجباری میباشند',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        }

        $_SESSION['authCode'] = random_int(10000, 99999);
        $_SESSION['temp_number'] = $number;

        $user = $db->select('SELECT * FROM users WHERE number = ?', [$number])->fetch();
        $doctor = $db->select('SELECT * FROM doctors WHERE number = ?', [$number])->fetch();

        if ($doctor) {
            if ($doctor['name'] != $username) {
                unset($_SESSION['authCode'], $_SESSION['temp_number']);
                flash('auth_error', 'اطلاعات احراز هویت معتبر نمی‌باشد');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'اطلاعات احراز هویت معتبر نمی‌باشد',
                    'redirect' => $redirectUrl,
                    'closeModals' => true
                ]);
                exit;
            }
            $_SESSION['temp_username'] = $doctor['name'];
        } elseif ($user != null) {
            if ($user['is_active'] == 1) {
                $db->update('users', $user['id'], ['is_active'], [0]);
            }
            $_SESSION['temp_username'] = $username;
        } else {
            $db->insert('users', ['number', 'username'], [$number, $username]);
            $temp_username = $db->select("SELECT id FROM users WHERE number = ?", [$number])->fetch();
            $_SESSION['temp_username'] = $username;
        }

        $_SESSION['resendAttempts'] = 0;
        $_SESSION['lastResend'] = time();
        $kavehnegar = new Kavehnegar();
        $result = $kavehnegar->sendKavenegarVerificationSMS(
            $_SESSION['temp_number'],
            $_SESSION['authCode'],
            "verifyDentalProject",
            "API",
            "medicare",
            "",
            false
        );
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'showVerifyForm' => true,
                'phone' => $_SESSION['temp_number']
            ]);
            exit;
        }
    }

    public function resendCode()
    {
        if (!isset($_SESSION['resendAttempts'])) {
            $_SESSION['resendAttempts'] = 0;
        }
        $delay = 120 + ($_SESSION['resendAttempts'] * 60);

        if (isset($_SESSION['lastResend']) && time() - $_SESSION['lastResend'] < $delay) {
            exit;
        }

        $_SESSION['resendAttempts'] += 1;
        $_SESSION['authCode'] = random_int(10000, 99999);
        $_SESSION['lastResend'] = time();

        $kavehnegar = new Kavehnegar();
        $result = $kavehnegar->sendKavenegarVerificationSMS(
            $_SESSION['temp_number'],
            $_SESSION['authCode'],
            "verifyDentalProject",
            "API",
            "medicare",
            "",
            false
        );

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'showVerifyForm' => true,
                'phone' => $_SESSION['temp_number']
            ]);
            exit;
        } else {
            flash('auth_error', 'خطا در ارسال مجدد کد تأیید، لطفاً بعداً تلاش کنید.');
            echo json_encode([
                'status' => 'error',
                'message' => 'خطا در ارسال پیامک. لطفاً بعداً تلاش کنید.'
            ]);
            exit;
        }
    }

    public function authNumber($request)
    {
        $setcookie = new CookieManager();
        $db = new DataBase();
        $user = $db->select("SELECT * FROM users WHERE number = ?", [$_SESSION['temp_number']])->fetch();
        $doctor = $db->select("SELECT * FROM doctors WHERE number = ?", [$_SESSION['temp_number']])->fetch();

        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

        if ($request['code'] != $_SESSION['authCode']) {
            unset($_SESSION['authCode'], $_SESSION['temp_number'], $_SESSION['temp_username']);
            flash('auth_error', 'کد احراز هویت اشتباه است');
            echo json_encode([
                'status' => 'error',
                'message' => 'کد احراز هویت اشتباه است',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        }

        if (!isset($_SESSION['temp_number'])) {
            unset($_SESSION['authCode'], $_SESSION['temp_number'], $_SESSION['temp_username']);
            flash('auth_error', 'اطلاعات احراز هویت معتبر نمی‌باشد');
            echo json_encode([
                'status' => 'error',
                'message' => 'اطلاعات احراز هویت معتبر نمی‌باشد',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        }

        if ($doctor != null) {

            $setcookie->set(doctorCookieID, $doctor['id']);

            $_SESSION['username'] = $doctor['name'];
            $_SESSION['user_id'] = $doctor['id'];
            $_SESSION['number'] = $doctor['number'];
            unset($_SESSION['authCode'], $_SESSION['temp_number'], $_SESSION['temp_username'], $_SESSION['resendAttempts'], $_SESSION['lastResend']);

            flash('auth_success', 'شما با موفقیت وارد شدید');
            echo json_encode([
                'loggedin' => true,
                'status' => 'success',
                'message' => 'شما با موفقیت وارد شدید',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        }

        if ($user != null) {
            if ($user['username'] != $_SESSION['temp_username']) {
                $db->update('users', $user['id'], ['username'], [$_SESSION['temp_username']]);
            }

            if ($user['is_active'] == 0) {
                $db->update('users', $user['id'], ['is_active'], [1]);
            }

            $setcookie->set(userCookieID, $user['id']);

            $_SESSION['username'] = $_SESSION['temp_username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['number'] = $user['number'];

            unset($_SESSION['authCode'], $_SESSION['temp_number'], $_SESSION['temp_username'], $_SESSION['resendAttempts'], $_SESSION['lastResend']);

            flash('auth_success', 'شما با موفقیت وارد شدید');
            echo json_encode([
                'loggedin' => true,
                'status' => 'success',
                'message' => 'شما با موفقیت وارد شدید',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        } else {
            flash('auth_error', value: 'کاربری با این اطلاعات یافت نشد');
            echo json_encode([
                'status' => 'error',
                'message' => 'کاربری با این اطلاعات یافت نشد',
                'redirect' => $redirectUrl,
                'closeModals' => true
            ]);
            exit;
        }
    }

    public function authAbort()
    {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        session_unset();
        flash('auth_error', 'احراز هویت شما به مشکل خورد!');
        echo json_encode([
            'status' => 'success',
            'redirect' => $redirectUrl,
            'closeModals' => true
        ]);
    }

    public function checkLogin(): void
    {
        if (isset($_SESSION['number'])) {
            $db = new DataBase();
            $user = $db->select("SELECT * FROM users WHERE number = ?", [$_SESSION['number']])->fetch();
            $doctor = $db->select('SELECT * FROM doctors WHERE number = ?', [$_SESSION['number']])->fetch();

            if (($user != null && $user['is_active'] != 0) || $doctor != null) {
                echo json_encode([
                    'confirmTime' => true,
                ]);
                exit;
            } else {
                echo json_encode([
                    'needtologin' => true,
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'needtologin' => true,
            ]);
            exit;
        }
    }

    public function checkAdmin()
    {
        if (isset($_SESSION['number'])) {
            $db = new DataBase();
            $admin = $db->select("SELECT * FROM doctors WHERE number = ?", [$_SESSION['number']])->fetch();
            $userPermission = $db->select('SELECT permission, accessedByDoctorId  FROM users WHERE number = ?', [$_SESSION['number']])->fetch();

            if ($admin != null) {
                if (!$admin) {
                    $this->redirect('/');
                }
            } elseif ($userPermission != null) {
                if ($userPermission['permission'] != "admin") {
                    $this->redirect('/');
                } else {
                    $_SESSION['userAsseccible'] = $userPermission['accessedByDoctorId'];
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/');
        }
    }

    public function logout(): void
    {
        $fullUrl = $_SERVER['HTTP_REFERER'] ?? '/';
        $path = str_replace(CURRENT_DOMAIN, '', $fullUrl);
        $path = ltrim($path, '/');

        $deletecookie = new CookieManager();

        if (isset($_SESSION['number']) || isset($_SESSION['username'])) {
            unset($_SESSION['number'], $_SESSION['username']);
            session_unset();
        }

		$deletecookie->delete(doctorCookieID);
        $deletecookie->delete(userCookieID);

        $this->redirect($path);
    }

}

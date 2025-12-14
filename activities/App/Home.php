<?php

namespace App;

use Admin\Doctor;
use database\DataBase;
use KavehnegarLookup\Kavehnegar;

class Home
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

  public function index()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctors = $db->select("SELECT * FROM doctors WHERE id IN (SELECT DISTINCT doctor_id FROM reserves)")->fetchAll();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();
    $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
    $lastPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY created_at DESC LIMIT 0,6')->fetchAll();
    $bodyBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
    $sidebarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
    $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();
    $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();
    $mostLikedPosts = $db->select('SELECT posts.*, posts.rating AS rating, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY posts.rating DESC LIMIT 3;')->fetchAll();
    $posts = $db->select('SELECT  posts.*,  users.username,  categories.name AS category,  COUNT(comments.id) AS comments_count FROM posts LEFT JOIN users ON users.id = posts.user_id LEFT JOIN categories ON categories.id = posts.cat_id LEFT JOIN comments ON comments.post_id = posts.id GROUP BY posts.id ORDER BY id DESC LIMIT 8')->fetchAll();
    $suggestion_score = $db->select("SELECT  d.id AS doctor_id,  d.name AS doctor_name,  IFNULL(r.total_reserves, 0) AS total_reserves,  IFNULL(p.total_rating, 0) AS total_rating,  IFNULL(p.total_posts, 0) AS total_posts,LEAST(ROUND((((IFNULL(r.total_reserves, 0) / (SELECT MAX(rr.total_reserves) FROM ( SELECT doctor_id, COUNT(*) AS total_reserves  FROM reservedtimes  GROUP BY doctor_id ) rr)) * 60) + (((IFNULL(p.total_rating, 0) / IFNULL(p.total_posts, 1)) / 5) * 40) ), 2), 100 ) AS suggestion_score FROM doctors d LEFT JOIN ( SELECT doctor_id, COUNT(*) AS total_reserves  FROM reservedtimes  GROUP BY doctor_id ) r ON d.id = r.doctor_id LEFT JOIN ( SELECT user_id, SUM(rating) AS total_rating, COUNT(*) AS total_posts  FROM posts  GROUP BY user_id ) p ON d.id = p.user_id ORDER BY suggestion_score DESC; ")->fetchAll();
    $faqs = $db->select('SELECT * FROM faq')->fetchAll();

    require_once(BASE_PATH . '/template/app/index.php');
  }

  public function allPosts()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctors = $db->select("SELECT * FROM doctors WHERE id IN (SELECT DISTINCT doctor_id FROM reserves)")->fetchAll();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $posts = $db->select('SELECT  posts.*,  users.username,  categories.name AS category,  COUNT(comments.id) AS comments_count FROM posts LEFT JOIN users ON users.id = posts.user_id LEFT JOIN categories ON categories.id = posts.cat_id LEFT JOIN comments ON comments.post_id = posts.id GROUP BY posts.id ')->fetchAll();
    $comments = $db->select('SELECT comments.*, users.username, posts.title AS post_title, posts.id AS post_id, posts.cat_id, categories.name AS category, post_ratings.rating AS user_rating FROM comments INNER JOIN users ON users.id = comments.user_id INNER JOIN posts ON posts.id = comments.post_id INNER JOIN categories ON categories.id = posts.cat_id LEFT JOIN post_ratings ON post_ratings.post_id = comments.post_id AND post_ratings.user_id = comments.user_id WHERE comments.selected = 1 AND comments.status = "approved"')->fetchAll();

    require_once(BASE_PATH . '/template/app/posts.php');
  }

  public function send()
  {

    $db = new DataBase();
    $doctor_id = $_POST['dataId'] ?? null;
    $_SESSION['dataID'] = $_POST['dataId'];

    if (!$doctor_id) {
      flash('error', 'دکتر مورد نظر وجود ندارد');
      echo json_encode(['error' => 'doctor id missing']);
      exit;
    }
    $reserves = $db->select("SELECT * FROM reserves WHERE doctor_id = ? ORDER BY date ASC", [$doctor_id])->fetchAll();

    if (empty($reserves)) {
      flash('error', 'دکتر مورد نظر وجود ندارد');
      echo json_encode(['error' => 'no reserves']);
      exit;
    }

    $firstReserve = $reserves[0];

    $dateParts = explode('-', $firstReserve['date']);
    $reversedDate = $dateParts[0] . '-' . $dateParts[1] . '-' . $dateParts[2];

    $tomorrow = \Parsidev\Jalali\jdate::forge('now')->reforge('+ 1 day')->format('date');
    $isTomorrow = $firstReserve['date'] === $tomorrow;

    echo json_encode([
      'date' => $reversedDate,
      'formattedDate' => $isTomorrow ? 'فردا' : $reversedDate,
      'time' => $firstReserve['time']
    ]);
    exit;
  }

  public function getDates()
  {
    $db = new DataBase();

    $doctor_id = $_POST['doctor_id'] ?? null;
    if (!$doctor_id) {
      flash('error', 'دکتر مورد نظر وجود ندارد');
      echo 'خطا: آی‌دی پزشک دریافت نشد.';
      exit;
    }

    $reserves = $db->select("SELECT * FROM reserves WHERE doctor_id = ? ORDER BY date ASC", [$doctor_id])->fetchAll();

    $groupedReserves = [];

    foreach ($reserves as $reserve) {
      $date = $reserve['date'];
      if (!isset($groupedReserves[$date])) {
        $groupedReserves[$date] = [];
      }
      $groupedReserves[$date][] = $reserve;
    }
    foreach ($groupedReserves as $date => $reservesForDate): ?>
      <div class='swiper-slide btn btn-primary reserve-date' data-date='<?= $date ?>'>
        <p class='date-text'><?= $date ?></p>
        <span class='fs-7'><?= count($reservesForDate) ?> نوبت</span>
      </div>
    <?php endforeach;
  }

  public function getTime()
  {
    $db = new DataBase();

    if (isset($_GET['ajax']) && isset($_GET['date']) && isset($_GET['doctor_id'])) {
      $date = $_GET['date'];
      $doctor_id = $_GET['doctor_id'];

      $reserves = $db->select("SELECT id, time, price, additional FROM reserves WHERE date = ? AND doctor_id = ? ORDER BY time ASC", [$date, $doctor_id])->fetchAll();

      if (count($reserves) === 0) {
        echo "<div class='text-danger'>نوبتی برای این روز وجود ندارد</div>";
        exit;
      }

      foreach ($reserves as $reserve) {
        $time = $reserve['time'];
        $price = number_format($reserve['price']);
        $id = $reserve['id'];
        $add = $reserve['additional'] != null ? $reserve['additional'] : '';
        if (!empty($add)) {
          $add = "<div class='text-primary mt-2 fs-6'>
                        <span>$add</span>
                        <i class='fa-solid fa-circle-plus'></i>
                    </div>";
        }
        $currecyLogoPath = asset('public\images\Untitled-12.png');
        $clockSvgPath = asset('public\images\clock.svg');
        echo "
                <div class='time-slot-card btn btn-light border-success time-item' data-time='$time' data-id='$id' data-price='$price'>
                    <div class='slot-time text-muted'>
                         $time <img src='$clockSvgPath' alt='ساعت' style='width: 20px; vertical-align: middle; margin-right: 3px;'>
                    </div>
                    <div class='slot-price'>
                        <span>$price</span>
                        <img src='$currecyLogoPath' alt='تومان' style='width: 20px; vertical-align: middle; margin-right: 3px;'>
                    </div> 
                    $add
                </div>
                ";
      }

      exit;
    }
  }

  public function contactUs()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctors = $db->select("SELECT * FROM doctors WHERE id IN (SELECT DISTINCT doctor_id FROM reserves)")->fetchAll();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();
    $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
    $lastPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY created_at DESC LIMIT 0,6')->fetchAll();
    $bodyBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
    $sidebarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
    $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();
    $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();
    $mostLikedPosts = $db->select('SELECT posts.*, posts.rating AS rating, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY posts.rating DESC LIMIT 3;')->fetchAll();
    $suggestion_score = $db->select("SELECT  d.id AS doctor_id,  d.name AS doctor_name,  IFNULL(r.total_reserves, 0) AS total_reserves,  IFNULL(p.total_rating, 0) AS total_rating,  IFNULL(p.total_posts, 0) AS total_posts,LEAST(ROUND((((IFNULL(r.total_reserves, 0) / (SELECT MAX(rr.total_reserves) FROM ( SELECT doctor_id, COUNT(*) AS total_reserves  FROM reservedtimes  GROUP BY doctor_id ) rr)) * 60) + (((IFNULL(p.total_rating, 0) / IFNULL(p.total_posts, 1)) / 5) * 40) ), 2), 100 ) AS suggestion_score FROM doctors d LEFT JOIN ( SELECT doctor_id, COUNT(*) AS total_reserves  FROM reservedtimes  GROUP BY doctor_id ) r ON d.id = r.doctor_id LEFT JOIN ( SELECT user_id, SUM(rating) AS total_rating, COUNT(*) AS total_posts  FROM posts  GROUP BY user_id ) p ON d.id = p.user_id ORDER BY suggestion_score DESC; ")->fetchAll();

    require_once(BASE_PATH . '/template/app/contactUs.php');
  }

  public function blog()
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $doctors = $db->select("SELECT * FROM doctors WHERE id IN (SELECT DISTINCT doctor_id FROM reserves)")->fetchAll();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $topSelectedPosts = $db->select(sql: 'SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();
    $posts = $db->select('SELECT  posts.*,  users.username,  categories.name AS category,  COUNT(comments.id) AS comments_count FROM posts LEFT JOIN users ON users.id = posts.user_id LEFT JOIN categories ON categories.id = posts.cat_id LEFT JOIN comments ON comments.post_id = posts.id GROUP BY posts.id LIMIT 10')->fetchAll();
    $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
    $lastPosts = $db->select('SELECT posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY created_at DESC LIMIT 0,6')->fetchAll();
    $lastPost = $db->select('SELECT posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY created_at DESC LIMIT 1')->fetch();
    $bodyBanner = $db->select('SELECT * FROM banners')->fetchAll();
    $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();
    $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();
    $mostLikedPosts = $db->select('SELECT posts.*, posts.rating AS rating, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY posts.rating DESC LIMIT 3;')->fetchAll();
    $comments = $db->select('SELECT comments.*,  users.username AS user_username,  doctors.name AS doctor_name,  posts.title AS post_title,  posts.id AS post_id,  posts.cat_id,  categories.name AS category,  post_ratings.rating AS user_rating FROM comments LEFT JOIN users ON users.id = comments.user_id LEFT JOIN doctors ON doctors.id = comments.doctor_id INNER JOIN posts ON posts.id = comments.post_id LEFT JOIN categories ON categories.id = posts.cat_id LEFT JOIN post_ratings  ON post_ratings.post_id = comments.post_id  AND post_ratings.user_id = comments.user_id WHERE comments.selected = 1 AND comments.status = "approved"')->fetchAll();
    $categories = $db->select('SELECT id, name FROM categories')->fetchAll();

    require_once(BASE_PATH . '/template/app/blog.php');
  }

  public function getPosts()
  {
    $catId = $_POST['category'] ?? 0;

    if (!$catId) {
      echo "<p>دسته‌بندی نامعتبر است.</p>";
      return;
    }

    $db = new Database();
    $posts = $db->select("SELECT * FROM posts WHERE cat_id = ?", [$catId])->fetchAll();


    if (empty($posts)) {
      echo "<p>هیچ پستی برای این دسته‌بندی پیدا نشد.</p>";
      return;
    }

    foreach ($posts as $post): ?>
      <a href="<?= url('show-post/' . $post['id']) ?>">
        <div class="swiper-slide blog-swiper-slide uniform-card">
          <img loading="lazy" src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>" class="card-img-top"
            style="height: 180px; object-fit: cover; border-radius: 17px;">
          <div class="card-body p-3 text-center">
            <h6 class="fw-bold mt-3 mb-2"><?= $post['title'] ?></h6>
            <p class="text-muted small mb-3">
              <?= mb_strimwidth(strip_tags($post['summary']), 0, 90, "...", "UTF-8"); ?>
            </p>
            <a href="<?= url('show-post/' . $post['id']) ?>" class="btn btn-sm btn-primary text-white rounded-pill px-4">
              مشاهده پست
            </a>
          </div>
        </div>
      </a>
    <?php endforeach;
  }

  public function show($id)
  {
    $db = new DataBase();
    $setting = $db->select('SELECT * FROM websetting')->fetch();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $bodyBanner = $db->select('SELECT * FROM banners')->fetchAll();
    $viewPost = $db->select('SELECT posts.view as view FROM posts WHERE id = ?', [$id])->fetch();
    $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();
    $mostLikedPosts = $db->select('SELECT posts.*, posts.rating AS rating, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY posts.rating DESC LIMIT 3;')->fetchAll();
    $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,1')->fetchAll();
    $post = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE id = ?', [$id])->fetch();
    $commentCount = $db->select("SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = ? AND status = 'approved'", [$id])->fetch();

    $total_result = $db->select(
      'SELECT COUNT(*) AS total 
     FROM comments 
     WHERE post_id = ? AND status = "approved" AND parent_id IS NULL',
      [$id]
    )->fetch();

    $total_rows = $total_result ? (int) $total_result['total'] : 0;

    // 2. محاسبه صفحه فعلی و محدودیت‌ها
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 20;
    $total_pages = $total_rows > 0 ? ceil($total_rows / $limit) : 1;

    if ($page > $total_pages)
      $page = $total_pages;
    if ($page < 1)
      $page = 1;

    $offset = ($page - 1) * $limit;

    // 3. گرفتن کامنت‌های صفحه فعلی
    $sql = "SELECT comments.*,  COALESCE(     (SELECT users.username FROM users WHERE users.id = comments.user_id),     (SELECT doctors.name FROM doctors WHERE doctors.id = comments.doctor_id) ) AS username FROM comments WHERE post_id = ?    AND status = 'approved'    AND parent_id IS NULL ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

    $comments = $db->select($sql, [$id])->fetchAll();

    // 4. گرفتن پاسخ‌های مرتبط فقط برای همین کامنت‌ها
    if (!empty($comments)) {
      $comment_ids = array_column($comments, 'id');

      $placeholders = implode(',', array_fill(0, count($comment_ids), '?'));
      $params = array_merge([$id], $comment_ids);

      $replies_sql = "SELECT comments.*,  COALESCE(     (SELECT users.username FROM users WHERE users.id = comments.user_id),     (SELECT doctors.name FROM doctors WHERE doctors.id = comments.doctor_id) ) AS username FROM comments WHERE post_id = ?   AND status = 'approved'   AND parent_id IN ($placeholders) ORDER BY created_at ASC";

      $replies = $db->select($replies_sql, $params)->fetchAll();

      // گروه‌بندی پاسخ‌ها بر اساس parent_id
      $repliesByParent = [];
      foreach ($replies as $reply) {
        $repliesByParent[$reply['parent_id']][] = $reply;
      }

      // افزودن پاسخ‌ها به هر کامنت
      foreach ($comments as &$comment) {
        $comment['replies'] = $repliesByParent[$comment['id']] ?? [];
      }
      unset($comment);
    } else {
      foreach ($comments as &$comment) {
        $comment['replies'] = [];
      }
      unset($comment);
    }


    if (!$post) {
      flash('post_error', 'پست موردنظر وجود ندارد');
      $this->redirect('blog');
    }

    require_once(BASE_PATH . '/template/app/show.php');
  }

  public function category($id)
  {
    $db = new DataBase();
    $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,1')->fetchAll();
    $popularPosts = $db->select('SELECT  posts.*, posts.rating AS rating, posts.view as view, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();
    $mostLikedPosts = $db->select('SELECT posts.*, posts.rating AS rating, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY posts.rating DESC LIMIT 3;')->fetchAll();
    $categoryPosts = $db->select('SELECT posts.*,(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT name FROM doctors WHERE doctors.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE cat_id = ? ORDER BY created_at DESC LIMIT 0,4', [$id])->fetchAll();
    $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
    $category = $db->select("SELECT * FROM categories WHERE id = ?", [$id])->fetch();
    $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
    $sidebarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
    $bodyBanner = $db->select('SELECT * FROM banners')->fetchAll();
    $setting = $db->select('SELECT * FROM websetting')->fetch();

    require_once(BASE_PATH . '/template/app/category.php');
  }

  public function reserve($request)
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $id = $request['id'] ?? null;


    if (!isset($_SESSION['number'])) {
      echo json_encode([
        'needtologin' => true,
      ]);
      exit;
    }

    if (!isset($_SESSION['dataID'])) {
      echo json_encode([
        'errorDataId' => true,
      ]);
      exit;
    }

    $db = new DataBase();
    $docNumber = $db->select("SELECT number FROM doctors WHERE id = ?", [$_SESSION['dataID']])->fetch();
    $request = $db->select("SELECT * FROM reserves WHERE id = ?", [$id])->fetch();
    $userInfo = $db->select("SELECT id, username, number FROM users WHERE number = ?", [$_SESSION['number']])->fetch();
    if (!$userInfo) {
      $userInfo = $db->select("SELECT id, name as username, number FROM doctors WHERE number = ?", [$_SESSION['number']])->fetch();
    }

    $requestInsert = [
      'doctor_id' => $request['doctor_id'],
      'user_id' => $userInfo['id'],
      'price' => $request['price'],
      'time' => $request['time'],
      'date' => $request['date'],
      'week' => $request['day'],
      'additional' => $request['additional'],
    ];

    $db->insert('reservedtimes', array_keys($requestInsert), $requestInsert);

    $userInfo['username'] = str_replace(' ', '.', $userInfo['username']);
    $request['date'] = str_replace('-', '/', $request['date']);

    if (!in_array(CURRENT_PLAN, ["D", "E"])):
      $kavehnegar = new Kavehnegar();
      $res = $kavehnegar->sendKavenegarVerificationSMS(
        $userInfo['number'],
        $userInfo['username'],
        "verifyTimeDentalProject",
        "API",
        $userInfo['number'],
        $request['date'] . '--' . $request['time'],
        false
      );

      $kavehnegar = new Kavehnegar();
      $res = $kavehnegar->sendKavenegarVerificationSMS(
        $docNumber['number'],
        $userInfo['username'],
        "verifyTimeDentalProject",
        "API",
        $userInfo['number'],
        $request['date'] . '--' . $request['time'],
        false
      );
    endif;

    $db->delete('reserves', $id);

    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : CURRENT_DOMAIN;

    if (!in_array(CURRENT_PLAN, ["D", "E"])) {
      flash('success_reserve', 'نوبت شما با موفقیت رزرو شد. پیامک رزرو بزودی برایتان ارسال میگردد');
    } else {
      flash('success_reserve', 'نوبت شما با موفقیت رزرو شد.');
    }

    echo json_encode([
      'successReserved' => true,
      'redirect' => $redirectUrl,
    ]);
    exit;
  }


  public function commentStore($request, $post_id)
  {
    if (!isset($_SESSION['number']) || $_SESSION['number'] == null) {
      $this->redirectBack();
    }

    $db = new Database();
    $number = $_SESSION['number'];

    // سعی می‌کنیم کاربر عادی رو پیدا کنیم
    $user = $db->select("SELECT id FROM users WHERE number = ?", [$number])->fetch();

    if (!empty($user)) {
      $user_id = $user['id'];
      $db->insert('comments', ['user_id', 'comment', 'post_id'], [$user_id, $request['comment'], $post_id]);
      flash('comment_success', 'کامنت شما ثبت شد و بعد تایید ادمین نمایش داده میشود');
      $this->redirectBack();
    }

    // اگر کاربر نبود، می‌ریم سراغ دکتر
    $doctor = $db->select("SELECT id FROM doctors WHERE number = ?", [$number])->fetch();

    if (!empty($doctor)) {
      $doctor_id = $doctor['id'];
      $db->insert('comments', ['doctor_id', 'comment', 'post_id', 'status'], [$doctor_id, $request['comment'], $post_id, 'approved']);
      flash('comment_success', 'کامنت شما ثبت شد');
      $this->redirectBack();
    }

    // اگر نه کاربر بود نه دکتر، برگرد عقب
    $this->redirectBack();
  }

  public function replyStore($request, $post_id, $comment_id)
  {
    $number = $_SESSION['number'] ?? null;

    if (!$number) {
      return $this->redirectBack();
    }

    $db = new Database();

    // آیا کاربره؟
    $user = $db->select("SELECT id FROM users WHERE number = ?", [$number])->fetch();
    if (!empty($user)) {
      $user_id = $user['id'];
      $db->insert('comments', ['user_id', 'comment', 'post_id', 'parent_id'], [
        $user_id,
        $request['reply'],
        $post_id,
        $comment_id
      ]);
      flash('comment_success', 'کامنت شما ثبت شد و بعد تایید ادمین نمایش داده میشود');
      return $this->redirectBack();
    }

    // آیا دکتره؟
    $doctor = $db->select("SELECT id FROM doctors WHERE number = ?", [$number])->fetch();
    if (!empty($doctor)) {
      $doctor_id = $doctor['id'];
      $db->insert('comments', ['doctor_id', 'comment', 'post_id', 'parent_id', 'status'], [
        $doctor_id,
        $request['reply'],
        $post_id,
        $comment_id,
        'approved'
      ]);
      flash('comment_success', 'کامنت شما ثبت شد');
      return $this->redirectBack();
    }

    // اگه نه کاربره نه دکتر:
    flash('comment_error', 'حساب کاربری معتبر نیست.');
    return $this->redirectBack();
  }



  public function saveRate($id)
  {

    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : CURRENT_DOMAIN;

    if (!isset($_SESSION['username'])) {
      echo json_encode([
        'needtologin' => true,
      ]);
      exit;
    }


    $db = new DataBase();
    if ($userId = $db->select("SELECT users.id FROM users WHERE username = ?", [$_SESSION['username']])->fetch()) {
      $userId = $userId['id'];
    } else {
      $userId = $db->select("SELECT doctors.id FROM doctors WHERE name = ?", [$_SESSION['username']])->fetch();
      $userId = $userId['id'];
    }
    $existingRating = $db->select("SELECT * FROM post_ratings WHERE post_id = ? AND user_id = ?", [$id['post_id'], $userId])->fetch();


    if ($existingRating && isset($_POST['rating'])) {
      $db->update('post_ratings', $existingRating['id'], ['rating'], [$_POST['rating']]);
      $avg = $db->select("SELECT SUM(rating) as avg_rating FROM post_ratings WHERE post_id = ?", [$id['post_id']])->fetch();
      $db->update('posts', $id['post_id'], ['rating'], [$avg['avg_rating']]);
      flash('rating_success', 'امتیاز شما با موفقیت ثبت شد');
      echo json_encode([
        'status' => 'success',
        'message' => 'امتیاز شما با موفقیت ثبت شد',
        'redirect' => $redirectUrl,
        'closeModals' => true
      ]);
      exit;
    }

    if (isset($_POST['rating'])) {
      $rating = (int) $_POST['rating'];

      if ($rating >= 1 && $rating <= 5) {
        $db->insert('post_ratings', ['post_id', 'user_id', 'rating'], [$id['post_id'], $userId, $rating]);

        $avg = $db->select("SELECT SUM(rating) as avg_rating FROM post_ratings WHERE post_id = ?", [$id['post_id']])->fetch();

        $db->update('posts', $id['post_id'], ['rating'], [$avg['avg_rating']]);

        flash('rating_success', 'امتیاز شما با موفقیت ثبت شد');
        echo json_encode([
          'status' => 'error',
          'message' => 'امتیاز شما با موفقیت ثبت شد',
          'redirect' => $redirectUrl,
          'closeModals' => true
        ]);
        exit;
      } else {
        flash('rating_error', 'امتیاز وارد شده معتبر نیست');
        echo json_encode([
          'status' => 'error',
          'message' => 'امتیاز وارد شده معتبر نیست',
          'redirect' => $redirectUrl,
          'closeModals' => true
        ]);
        exit;
      }
    } else {
      flash('rating_error', 'امتیاز ارسال نشده است');
      echo json_encode([
        'status' => 'error',
        'message' => 'امتیاز ارسال نشده است',
        'redirect' => $redirectUrl,
        'closeModals' => true
      ]);
      exit;
    }
  }
}
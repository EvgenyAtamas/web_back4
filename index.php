<?php

header('Content-Type: text/html; charset=UTF-8');

$abilities = array(
  'immortality' => "Бессмертие",
  'levitation' => "Левитация",
  'invisibility"' => "Невидимость");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['check'] = !empty($_COOKIE['check_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    if ($_COOKIE['fio_error'] == "1") {
      $messages[] = '<div class="error">Заполните ФИО</div>';
    }
    else {
      $messages[] = '<div class="error">Укажите корректное ФИО</div>';
    }
    
  }
    if ($errors['email']) {
      setcookie('email_error', '', 100000);
      if ($_COOKIE['email_error'] == "1") {
        $messages[] = '<div class="error">Заполните email</div>';
      }
      else {
        $messages[] = '<div class="error">Укажите корректный email</div>';
    }

    if ($errors['year']) {
      setcookie('year_error', '', 100000);
      if ($_COOKIE['year_error'] == "1") {
        $messages[] = '<div class="error">Заполните год</div>';
      }
      else {
        $messages[] = '<div class="error">Укажите корректный год</div>';
      }
    }
    
    if ($errors['check']) {
      setcookie('check_error', '', 100000);
      if ($_COOKIE['check_error'] == "1") {
        $messages[] = '<div class="error">Вы не приняли соглашение</div>';
      }  
    }
     if ($errors['bio']) {
      setcookie('bio_error', '', 100000);
      $messages[] = '<div class="error">Заполните текстовое поле</div>';
    }


    if ($errors['abilities']) {

      setcookie('abilities_error', '', 100000);

      if ($_COOKIE['abilities_error'] == "1") {
        $messages[] = '<div class="error">Выберите способность</div>';
      }
      else {
        $messages[] = '<div class="error">Выбрана недопустимая способность</div>';
      }
      
    }

  }

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) || !preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['sex_value'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  if (!empty($_COOKIE['abilities_value'])) {
    $abilities_value = json_decode($_COOKIE['abilities_value']);
  }
  $values['abilities'] = array();
  if (is_array($abilities_value)) {
    foreach($abilities_value as $ability) {
      if (!empty($abilities[$ability])) {
        $values['abilities'][$ability] = $ability;
      }
    }
  }
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];
  include('form.php');
}
else {
  $errors = FALSE;
  if (empty($_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $_POST['fio'])) {
      setcookie('fio_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    if (!preg_match('/^[^@]+@[^@.]+\.[^@]+$/', $_POST['email'])) {
      setcookie('email_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    $year = $_POST['year'];
    if (!(is_numeric($year) && intval($year) >= 1900 && intval($year) <= 2020)) {
      setcookie('year_error', '2', time() + 24 * 60 * 60);  
      $errors = TRUE;
    }
    setcookie('year_value', $_POST['year'], time() + 12 * 30 * 24 * 60 * 60);
  }

  setcookie('sex_value', $_POST['sex'], time() + 12 * 30 * 24 * 60 * 60);

  if (empty($_POST['limb'])) {
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['limb'], time() + 12 * 30 * 24 * 60 * 60);
  }
  if (empty($_POST['abilities'])) {
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    $abilities_error = FALSE;
    foreach($_POST['abilities'] as $key) {
      if (empty($abilities[$key])) {
        setcookie('abilities_error', '2', time() + 24 * 60 * 60);
        $errors = TRUE;
        $abilities_error = TRUE;
      }
    }
    if (!$abilities_error) {
      setcookie('abilities_value', json_encode($_POST['abilities']), time() + 12 * 30 * 24 * 60 * 60);
    }
  }

  if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 12 * 30 * 24 * 60 * 60);
  }
  if (!isset($_POST['check'])) {
    setcookie('check_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('check_value', $_POST['check'], time() + 12 * 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('abilities_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('check_error', '', 100000);
  }



$user = 'u20301';
$pass = '1344524';
$db = new PDO('mysql:host=localhost;dbname=u20301', $user, $pass, array(PDO::ATTR_PERSISTENT => true));


try {
  $str = implode(',',$_POST['abilities']);
  $stmt = $db->prepare("INSERT INTO appl SET fio = ?, email = ?, year = ?, sex = ?, limb = ?, bio = ?");
  $stmt -> execute(array($_POST['fio'], $_POST['email'], intval($_POST['year']), intval($_POST['sex']), intval($_POST['limb']), $_POST['bio']));
  $stmt = $db->prepare("INSERT INTO abilities SET abilities = ?");
  $stmt -> execute([$str]);
  }
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}
  setcookie('save', '1');
  header('Location: index.php');
}

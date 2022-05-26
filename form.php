<?php header("Content-Type: text/html; charset=UTF-8");?>
<?php
if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Задание №4</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form action="" method="POST">
    <label>ФИО:
    <div>
      <input name="fio" placeholder="Введите ФИО" 
      <?php if ($errors['fio']) {print 'class="error"';}?> value="<?php print $values['fio'];?>"/>
    </div>
    </label>
    <br/>

    <label>E-mail:
    <br/>
      <input name="email" type="email" placeholder="Введите e-mail" 
      <?php if ($errors['email']) {print 'class="error"';}?> value="<?php print $values['email'];?>"/>
    </label>
    <br/>

    <p>Год рождения:</p>
      <select name="year">
        <?php for($i = 1900; $i < 2022; $i++) {?>
        <option value="<?php print $i; ?>"<?= $i == $values['year'] ? 'selected' : ""?>><?= $i;?></option>
        <?php }?>
        <?php if ($errors['year']) {print 'class="error"';}?>
      </select>
    <br/>

    <p>Пол:</p>
    <label class="radio">
      <input type="radio" name="sex" value="0" 
      <?php if($_COOKIE['sex_value']){ echo 'checked="checked"';}?>/> Мужской 
    </label>

    <label class="radio">
      <input type="radio" checked="checked" name="sex" value="1"
      <?php if($_COOKIE['sex_value']){ echo 'checked="checked"';}?>/> Женский 
    </label>
    <br/>

    <p>Количество конечностей:</p>
      <label class="radio">
      <input type="radio" name="limb" value="1" 
      <?php echo $values['limb'] == "1" ? 'checked="checked"' :""?>/> 1 </label>
      <label class="radio">
      <input type="radio" checked="checked" name="limb" value="2"
      <?php echo $values['limb'] == "2" ? 'checked="checked"' :""?>/> 2 </label>
      <label class="radio">
      <input type="radio" name="limb" value="3"
      <?php echo $values['limb'] == "3" ? 'checked="checked"' :""?>/> 3 </label>
      <label class="radio">
      <input type="radio" name="limb" value="4"
      <?php echo $values['limb'] == "4" ? 'checked="checked"' :""?>/> 4 </label>
      <label class="radio">
      <input type="radio" name="limb" value="5"
      <?php echo $values['limb'] == "5" ? 'checked="checked"' :""?>/> 5 </label>
      <label class="radio">
      <input type="radio" name="limb" value="6"
      <?php echo $values['limb'] == "6" ? 'checked="checked"' :""?>/> 6 </label>
    <br/>

    <p>Сверхспособности:</p>
    <select name="abilities[]" multiple <?php if ($errors['abilities']) {print 'class="error"';}?>>
      <?php 
      foreach ($abilities as $key => $value) {
        $selected = !empty($values['abilities'][$key]) ? "" : 'selected="selected"';
        printf('<option value="%s"%s>%s</option>', $key, $selected, $value);
      }
      ?>
    </select>
    <br/>

    <p>Биография:</p>
    <label>
      <textarea name="bio" rows="8" cols="60" placeholder="Расскажите о себе"
      <?php if ($errors['bio']) {print 'class="error"';}?>><?php print $values['bio'];?></textarea>
    </label>
    </br>

    <label>
      <input type="checkbox" name="check"
      <?php if ($errors['check']) {print 'class="error"';}?> <?= $values['check'] == "on" ? 'checked="checked"' : "";?>/>С контрактом ознакомлен
    </label>
    <br/><br/>
      <input type="submit" value="Отправить"/>
  </form>
</body>
</html>

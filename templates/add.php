<nav class="nav">
  <ul class="nav__list container">
    <?php foreach ($categories as $cat): ?>
    <li class="nav__item">
      <a href="add.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name'];?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<form class="form form--add-lot container form--invalid" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item form__item--invalid">
      <?php $classname = isset($errors['lot-name']) ? "form__item--invalid" : "";
      $value = isset($announce['lot-name']) ? $announce['lot-name'] : ""; ?>
      <label for="lot-name">Наименование</label>
      <input class="<?=$classname;?>" id="lot-name" value="<?=$value;?>" type="text" name="lot-name" placeholder="Введите наименование лота" required>
      <span class="form__error">Введите наименование лота</span>
    </div>
    <div class="form__item">
      <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
      $value = isset($announce['category']) ? $announce['category'] : ""; ?>
      <label for="category">Категория</label>
      <select class="<?=$classname;?>" id="category" value="<?=$value;?>" name="category" required>
        <option>Выберите категорию</option>
        <option>Доски и лыжи</option>
        <option>Крепления</option>
        <option>Ботинки</option>
        <option>Одежда</option>
        <option>Инструменты</option>
        <option>Разное</option>
      </select>
      <span class="form__error">Выберите категорию</span>
    </div>
  </div>
  <div class="form__item form__item--wide">
    <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
    $value = isset($announce['message']) ? $announce['message'] : ""; ?>
    <label for="message">Описание</label>
    <textarea class="<?=$classname;?>" id="message" name="message" placeholder="Напишите описание лота" required><?=$value;?></textarea>
    <span class="form__error">Напишите описание лота</span>
  </div>
  <div class="form__item form__item--file"> <!-- form__item--uploaded -->
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>
  <div class="form__container-three">
    <div class="form__item form__item--small">
      <?php $classname = isset($errors['lot-rate']) ? "form__item--invalid" : "";
      $value = isset($announce['lot-rate']) ? $announce['lot-rate'] : "";?>
      <label for="lot-rate">Начальная цена</label>
      <input class="<?=$classname;?>" id="lot-rate" value="<?=$value;?>" type="number" name="lot-rate" placeholder="0" required>
      <span class="form__error">Введите начальную цену</span>
    </div>
    <div class="form__item form__item--small">
      <?php $classname = isset($errors['lot-step']) ? "form__item--invalid" : "";
      $value = isset($announce['lot-step']) ? $announce['lot-step'] : "";?>
      <label for="lot-step">Шаг ставки</label>
      <input class="<?=$classname;?>" id="lot-step" value="<?=$value;?>" type="number" name="lot-step" placeholder="0" required>
      <span class="form__error">Введите шаг ставки</span>
    </div>
    <div class="form__item">
      <?php $classname = isset($errors['lot-date']) ? "form__item--invalid" : "";
      $value = isset($announce['lot-date']) ? $announce['lot-date'] : "";?>
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date <?=$classname;?>" id="lot-date" value="<?=$value;?>" type="date" name="lot-date" required>
      <span class="form__error">Введите дату завершения торгов</span>
    </div>
  </div>
  <?php if (isset($errors)): ?>
    <div class="form__errors">
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <ul>
        <?php foreach($errors as $err => $val): ?>
        <li><strong><?=$dict[$err];?>:</strong> <?=$val;?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <button type="submit" class="button">Добавить лот</button>
</form>
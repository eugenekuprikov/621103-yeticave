<nav class="nav">
  <ul class="nav__list container">
    <?php foreach ($categories as $cat): ?>
    <li class="nav__item">
      <a href="register.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name'];?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<form class="form container" action="" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>
  <div class="form__item"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?=$values['email'] ?? ''; ?>">
    <span class="form__error">Введите e-mail</span>
  </div>
  <div class="form__item">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" required>
    <span class="form__error">Введите пароль</span>
  </div>
  <div class="form__item">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="name" placeholder="Введите имя" required value="<?=$values['name'] ?? ''; ?>">
    <span class="form__error">Введите имя</span>
  </div>
  <div class="form__item">
    <label for="message">Контактные данные*</label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required value="<?=$values['message'] ?? ''; ?>"></textarea>
    <span class="form__error">Напишите как с вами связаться</span>
  </div>
  <div class="form__item form__item--file form__item--last">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="avatar_img" id="photo2" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
  </div>
  <?php if (isset($errors)): ?>
      <div class="form__errors">
          <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
          <ul>
              <?php foreach ($errors as $error): ?>
                  <li><?=$error;?></li>
              <?php endforeach; ?>
          </ul>
      </div>
  <?php endif; ?>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
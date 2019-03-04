<nav class="nav">
  <ul class="nav__list container">
    <?php foreach ($categories as $cat): ?>
    <li class="nav__item">
      <a href="lot.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name'];?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<form class="form container form--invalid" action="" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Вход</h2>
  <div class="form__item form__item--invalid"> <!-- form__item--invalid -->
    <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; $value = isset($form['email']) ? $form['email'] : ""; ?>
    <label for="email">E-mail*</label>
    <input class="<?=$classname;?>" id="email" value="<?=$value;?>" type="text" name="email" placeholder="Введите e-mail" required>
    <?php if ($classname): ?>
    <span class="form__error"><?=$errors['email'];?><!-- Введите e-mail --></span>
    <?php endif; ?>
  </div>
  <div class="form__item form__item--last">
    <?php $classname = isset($errors['password']) ? "form__item--last" : ""; $value = isset($form['password']) ? $form['password'] : ""; ?>
    <label for="password">Пароль*</label>
    <input class="<?=$classname;?>" id="password" value="<?=$value;?>" type="text" name="password" placeholder="Введите пароль" required>
    <?php if ($classname): ?>
    <span class="form__error"><?=$errors['password'];?><!-- Введите пароль --></span>
    <?php endif; ?>
  </div>
  <button type="submit" class="button">Войти</button>
</form>
<nav class="nav">
  <ul class="nav__list container">
    <?php foreach ($categories as $cat): ?>
    <li class="nav__item">
      <a href="lot.php?cat_id=<?= $cat['id']; ?>"><?=$cat['name'];?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<section class="lot-item container">
  <h2><?=htmlspecialchars($announce['name']);?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$announce['picture_link']; ?>" width="730" height="548" alt="">
      </div>
      <p class="lot-item__category">Категория: <span><?=$announce['category'];?></span></p>
      <p class="lot-item__description"><?=$announce['description'];?></p>
    </div>
    <div class="lot-item__right">
      <?php if (isset($_SESSION['user'])): ?>
      <div class="lot-item__state">
        <div class="lot-item__timer timer">
          10:54
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=$announce['initial_price'];?></span>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?=$announce['step_rate'];?></span>
          </div>
        </div>
        <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
          <p class="lot-item__form-item form__item form__item--invalid">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="12 000">
            <span class="form__error">Введите наименование лота</span>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
      </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span>10</span>)</h3>
        <table class="history__list">
          <?php foreach ($rates as $rate): ?>
          <tr class="history__item">
            <td class="history__name"><?=$rate['user'];?></td>
            <td class="history__price"><?=$rate['summ_rate'];?></td>
            <td class="history__time"><?=$rate['date_rate'];?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>
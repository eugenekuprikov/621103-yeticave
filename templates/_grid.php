<ul class="lots__list">
  <?php foreach ($announce_list as $announce): ?>
    <li class="lots__item lot">
        <div class="lot__image">
            <img src="<?=$announce['picture_link']; ?>" width="350" height="260" alt="">
        </div>
        <div class="lot__info">
            <span class="lot__category"><?=$announce['category_id']; ?></span>
            <h3 class="lot__title"><a class="text-link" href="lot.php?announce_id=<?=$announce['id']; ?>"><?=htmlspecialchars($announce['name']); ?></a></h3>
            <div class="lot__state">
                <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?php echo sum_format($announce['initial_price']); ?></span>
                </div>
                <div class="lot__timer timer">
                    <?php echo time_left(); ?>
                </div>
            </div>
        </div>
    </li>
  <?php endforeach; ?>
</ul>
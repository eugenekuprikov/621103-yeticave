<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php
        $index = 0;
        $num_count = count($categories);
        ?>
        <?php while($index < $num_count): ?>  
        <li class="promo__item promo__item--boards">
            <a class="promo__link" href="pages/all-lots.html"><?=$categories[$index];?></a>
        </li>
        <?php $index++; ?>
        <?php endwhile; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach ($announce_list as $announce): ?>
            <?=include_template('_announce.php', ['announce' => $announce]); ?>
        <?php endforeach; ?>
    </ul>
</section>
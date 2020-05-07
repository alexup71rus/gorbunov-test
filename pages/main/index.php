<?php
include __DIR__ . '/register.php';

\Router::requireHeader('main_theme', [
    'css' => [
        '/assets/css/main.css'
    ],
    'title' => 'Заявка на экскурсионный полёт на Марс',
]);
?>

<noscript>
    <style>
        .typewriter {
            display: block !important;
        }
    </style>
</noscript>

<header>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" async>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(62489518, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/62489518" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <div class="container page-title">
        <h1>Заявка на&nbsp;экскурсионный полёт на&nbsp;Марс</h1>
    </div>
</header>
<section id="form-registration">
    <div class="container">
        <div class="content form-content">
            <noscript>У Вас отключен javascript, некоторые функции сайта могут не работать.</noscript>
            <form action="" id="form">
                <div class="form__container">
                    <div class="js-form__item-container">
                        <label class="js-form__item <?= $arFields['last-name']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Фамилия</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['last-name']['error'] ? 'js-wrong' : '' ?>" type="text" name="last-name" value="<?= $arFields['last-name']['value'] ?>" pattern="[А-ЯЁа-яё -]{0,20}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['last-name']['text_error'] ?></span>
                            </span>
                        </label>
                        <span class="js-form__item js-form__item_chk">
                            <span class="js-form__item__content">
                                <span class="js-form__item__label"></span>
                            </span>
                            <input id="form-item-cln-chk" type="checkbox" value="Y" tabindex="1">
                            <label class="form-item__label-check" for="form-item-cln-chk">
                                ранее менялась
                            </label>
                            <label class="js-form__item js-slide-hide" <?= $arFields['old-last-name']['error'] ? 'js-error' : '' ?>>
                                <span class="js-form__item__label">Старая фамилия</span>
                                <span class="js-form__item__content">
                                    <input class="<?= $arFields['old-last-name']['error'] ? 'js-wrong' : '' ?>" type="text" name="old-last-name"  value="<?= $arFields['old-last-name']['value'] ?>" pattern="[А-ЯЁа-яё -]{0,20}">
                                    <span class="js-field-error"><?= $arFields['old-last-name']['text_error'] ?></span>
                                </span>
                            </label>
                        </span>
                        <label class="js-form__item <?= $arFields['first-name']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Имя</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['first-name']['error'] ? 'js-wrong' : '' ?>" type="text" name="first-name" value="<?= $arFields['first-name']['value'] ?>" pattern="[А-ЯЁа-яё -]{0,20}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['first-name']['text_error'] ?></span>
                            </span>
                        </label>
                        <label class="js-form__item <?= $arFields['patronymic']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Отчество</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['patronymic']['error'] ? 'js-wrong' : '' ?>" type="text" name="patronymic" value="<?= $arFields['patronymic']['value'] ?>" pattern="[А-ЯЁа-яё -]{0,20}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['patronymic']['text_error'] ?></span>
                            </span>
                        </label>
                    </div>
                    <div class="js-form__item-container">
                        <label class="js-form__item <?= $arFields['last-name_lat']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Фамилия латиницей</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['last-name_lat']['error'] ? 'js-wrong' : '' ?>" type="text" name="last-name_lat" value="<?= $arFields['last-name_lat']['value'] ?>" pattern="[A-Za-z -]{0,25}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['last-name_lat']['text_error'] ?></span>
                            </span>
                        </label>
                        <label class="js-form__item <?= $arFields['first-name_lat']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Имя латиницей</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['first-name_lat']['error'] ? 'js-wrong' : '' ?>" type="text" name="first-name_lat" value="<?= $arFields['first-name_lat']['value'] ?>" pattern="[A-Za-z -]{0,25}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['first-name_lat']['text_error'] ?></span>
                            </span>
                        </label>
                    </div>
                    <div class="js-form__item-container">
                        <?php
                        $genderHidden = 'hiddenstart';
                        if (
                            $arFields['patronymic']['value']
                            && !isset($genderTable[ strtolower(substr($arFields['patronymic']['value'], -2)) ])
                        ) {
                            $genderHidden = '';
                        }
                        ?>
                        <label class="js-form__item js-gender <?= $genderHidden ?> <?= $arFields['gender']['error'] ? 'js-error' : '' ?>" for="">
                            <span class="js-form__item__label">Пол</span>
                            <span class="js-form__item__content js-form__item__content_inline">
                                <label>
                                    <input type="radio" name="gender" value="male" <?= $arFields['gender']['value'] !== 'female' ? 'checked' : '' ?> tabindex="1">
                                    <span>Мужской</span>
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="female" <?= $arFields['gender']['value'] === 'female' ? 'checked' : '' ?> tabindex="1">
                                    <span>Женский</span>
                                </label>
                            </span>
                            <span class="js-field-error"><?= $arFields['gender']['text_error'] ?></span>
                        </label>
                    </div>
                    <div class="js-form__item-container">
                        <label class="js-form__item <?= $arFields['birthdate-days']['error'] || $arFields['birthdate-months']['error'] || $arFields['birthdate-years']['error'] ? 'js-error' : '' ?>" for="">
                            <span class="js-form__item__label">Дата рождения</span>
                            <span class="js-form__item__content js-form__item__content_inline">
                                <select class="form-item-birthdate" id="form-item-birthdate-days" name="birthdate-days" tabindex="1" required>
                                    <option value=""></option>

                                    <?php for ($i = 1; $i <= $date['days']; $i++): ?>

                                        <option value="<?= $i < 10 ? '0' . $i : $i ?>" <?= (int) $arFields['birthdate-days']['value'] === $i ? 'selected' : '' ?>><?= $i < 10 ? '0' . $i : $i ?></option>

                                    <?php endfor; ?>

                                </select>
                                <select class="form-item-birthdate" id="form-item-birthdate-months" name="birthdate-months" tabindex="1" required>
                                    <option value=""></option>

                                    <?php foreach ($date['months'] as $k => $month): ?>
                                        <option value="<?= $k ?>" <?= strlen($arFields['birthdate-months']['value']) && (int) $arFields['birthdate-months']['value'] === $k
                                            ? 'selected' : '' ?>><?= $month ?></option>

                                    <?php endforeach; ?>

                                </select>
                                <select class="form-item-birthdate" id="form-item-birthdate-years" name="birthdate-years" tabindex="1" required>
                                    <option value=""></option>

                                    <?php for ($year = $date['years']['from']; $year > $date['years']['to']; $year--): ?>

                                        <option value="<?= $year ?>" <?= (int) $arFields['birthdate-years']['value'] === $year ? 'selected' : '' ?>><?= $year ?></option>

                                    <?php endfor; ?>

                                </select>
                            </span>
                            <span class="js-field-error"><?php
                                if ($arFields['birthdate-days']['text_error']) {
                                    echo $arFields['birthdate-days']['text_error'];
                                } elseif ($arFields['birthdate-months']['text_error']) {
                                    echo $arFields['birthdate-months']['text_error'];
                                } elseif ($arFields['birthdate-years']['text_error']) {
                                    echo $arFields['birthdate-years']['text_error'];
                                }
                            ?></span>
                        </label>
                        <label class="js-form__item <?= $arFields['marital-status']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Семейное положение</span>
                            <span class="js-form__item__content">
                                        <select  id="form-item-marial-status" name="marital-status" tabindex="1" required>
                                            <option value=""></option>

                                            <?php foreach ($maritalStatus as $type): ?>
                                                <?php foreach ($type as $k => $text): ?>

                                                    <option value="<?= $text ?>" <?= $arFields['marital-status']['value'] === $text ? 'selected' : '' ?>><?= $text ?></option>

                                                <?php endforeach; ?>
                                            <?php endforeach; ?>

                                        </select>
                                        <span class="js-field-error"><?= $arFields['marital-status']['text_error'] ?></span>
                                </span>
                        </label>
                        <label class="js-form__item <?= $arFields['education']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Образование</span>
                            <span class="js-form__item__content">
                                    <select name="education" id="" tabindex="1" required>
                                        <option value=""></option>

                                        <?php foreach ($education as $k => $text): ?>

                                            <option value="<?= $k ?>" <?= strlen($arFields['education']['value']) && (int) $arFields['education']['value'] === $k
                                                ? 'selected' : '' ?>><?= $text ?></option>

                                        <?php endforeach; ?>

                                    </select>
                                    <span class="js-field-error"><?= $arFields['education']['text_error'] ?></span>
                                </span>
                        </label>
                    </div>
                    <div class="js-form__item-container">
                        <h3>Контактная информация</h3>
                        <label class="js-form__item <?= $arFields['phone']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Моб. телефон</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['phone']['error'] ? 'js-wrong' : '' ?>" type="tel" name="phone" value="<?=
                                    $arFields['phone']['value'] ?>" placeholder="+7" pattern="[0-9 +-]{11,16}" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['phone']['text_error'] ?></span>
                            </span>
                        </label>
                        <label class="js-form__item <?= $arFields['email']['error'] ? 'js-error' : '' ?>">
                            <span class="js-form__item__label">Электронная почта</span>
                            <span class="js-form__item__content">
                                <input class="<?= $arFields['email']['error'] ? 'js-wrong' : '' ?>" type="email" name="email" value="<?= $arFields['email']['value'] ?>" tabindex="1" required>
                                <span class="js-field-error"><?= $arFields['email']['text_error'] ?></span>
                            </span>
                        </label>
                    </div>
                </div>

                <?php
                $success = ($response['code'] === 2);
                $error = (!$success && $response['code']);
                ?>
                <div class="form__container_footer">
                    <div class="js-form__item__content-footer <?= $arFields['agree']['error'] || $error ? 'js-error' : '' ?> <?= $success ? 'hidden' : '' ?>">
                        <input id="form-item-final-chk" type="checkbox" name="agree" value="Y" tabindex="1" required>
                        <label class="js-form__item-label-agree" for="form-item-final-chk">Ставя эту галочку, я подтверждаю, что поставил её в трезвом уме и твёрдой памяти.</label>
                        <span class="js-field-error" id="error-exeption"><?= $error ? $response['message'] : '' ?></span>
                        <button class="js-form__item__submit" id="js-form-item-final-btn" tabindex="1">Полететь на Марс</button>
                    </div>
                    <div class="js-form__item__content-footer_success <?= $success ? '' : 'hidden' ?>">
                        <div class="form__footer-content">
                            Спасибо! Ваша заявка принята. Мы ответим в течение суток
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="sidebar r-sidebar">
            <div class="content sidebar-content">
                <h2 class="sidebar__title">Почему стабильно солнечное затмение?</h2>
                <p class="typewriter">Эффективный диаметр жизненно вызывает случайный эффективный радиус, а время ожидания ответа составило бы 80 миллиардов лет.</p>
            </div>
        </div>
    </div>
</section>

<script>
    var arGenderTable = JSON.parse('<?= json_encode($genderTable) ?>'),
        arSP = JSON.parse('<?= json_encode($maritalStatus) ?>'),
        arTranslit = JSON.parse('<?= json_encode($translitTable) ?>');
</script>
<?php
\Router::requireFooter('main_theme', [
    'js' => [
        '/assets/js/app.js'
    ]
]);
?>
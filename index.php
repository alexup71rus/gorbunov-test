<?php
$date = [
     'days' => 31,
     'months' => [
             'Январь',
             'Ферваль',
             'Март',
             'Апрель',
             'Май',
             'Июнь',
             'Июль',
             'Август',
             'Сентябрь',
             'Октябрь',
             'Ноябрь',
             'Декабрь',
     ],
    'years' => [
            'date' => date('Y-m-d', strtotime('-18 year')),
            'from' => date('Y', strtotime('-18 year')),
            'to' => date('Y', strtotime('-80 year')),
    ]
];

$maritalStatus = [
    'male' => [
        'Женат',
        'Разведён',
        'Холост',
        'Вдовец',
    ],
    'female' => [
        'Замужем',
        'Разведена',
        'Не замужем',
        'Вдова',
    ],
    'for_all' => [
        'В «гражданском браке»'
    ]
];

$education = [
    'Высшее',
    'Среднее специальное',
    'Среднее',
    'Неоконченное высшее',
];

//var_dump($date);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заявка на экскурсионный полёт на Марс</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
    <body>
        <header>
            <div class="container">
                <h1>Заявка на экскурсионный полёт на Марс</h1>
            </div>
        </header>
        <section id="form-registration">
            <div class="container">
                <div class="content">
                    <noscript>У Вас отключен javascript, некоторые функции сайта могут не работать.</noscript>
                    <form action="" id="form">
                        <div class="form__container">
                            <div class="form__item-container">
                                <label class="form__item">
                                    <span class="form__item__label">Фамилия</span>
                                    <span class="form__item__content">
                                    <input type="text" name="last-name" value="" pattern="[А-Яа-я -]{0,60}" requiredfalse>
                                </span>
                                    <label class="form__item">
                                        <span class="form__item__label"></span>
                                        <span class="form__item__content">
                                        <input id="form-item-cln-chk" type="checkbox" value="Y">
                                        <span class="form__item__label">ранее менялась</span>
                                        <label class="form__item js-slide-hide" for="form-item-cln-chk">
                                            <span class="form__item__label"></span>
                                            <span class="form__item__content">
                                                    <input type="text" value="" pattern="[А-Яа-я -]{0,60}">
                                                </span>
                                        </label>
                                    </span>
                                    </label>
                                </label>
                                <!--<label class="form__item js-slide-hide" for="form-item-cln-chk">
                                    <span class="form__item__label"></span>
                                    <span class="form__item__content">
                                            <input type="text" value="" tabindex="-1">
                                        </span>
                                </label>-->
                                <label class="form__item">
                                    <span class="form__item__label">Имя</span>
                                    <span class="form__item__content">
                                    <input type="text" name="first-name" value="" pattern="[А-Яа-я -]{0,60}" requiredfalse>
                                </span>
                                </label>
                                <label class="form__item">
                                    <span class="form__item__label">Отчество</span>
                                    <span class="form__item__content">
                                    <input type="text" name="sure-name" value="" pattern="[А-Яа-я -]{0,60}" requiredfalse>
                                </span>
                                </label>
                            </div>
                            <div class="form__item-container">
                                <label class="form__item">
                                    <span class="form__item__label">Фамилия латиницей</span>
                                    <span class="form__item__content">
                                    <input type="text" name="last-name_lat" value="" pattern="[A-Za-z -]{0,60}" requiredfalse>
                                </span>
                                </label>
                                <label class="form__item">
                                    <span class="form__item__label">Имя латиницей</span>
                                    <span class="form__item__content">
                                    <input type="text" name="first-name_lat" value="" pattern="[A-Za-z -]{0,60}" requiredfalse>
                                </span>
                                </label>
                            </div>
                            <div class="form__item-container">
                                <label class="form__item" for="">
                                    <span class="form__item__label">Дата рождения</span>
                                    <span class="form__item__content form__item__content_inline">
                                    <select class="form-item-birthdate" id="form-item-birthdate-days" name="birthdate-days">

                                        <?php for ($i = 1; $i < $date['days']; $i++): ?>

                                            <option value="<?= $i ?>"><?= $i ?></option>

                                        <?php endfor; ?>

                                    </select>
                                    <select class="form-item-birthdate" id="form-item-birthdate-months" name="birthdate-months">

                                        <?php foreach ($date['months'] as $month): ?>

                                            <option value="<?= $month ?>"><?= $month ?></option>

                                        <?php endforeach; ?>

                                    </select>
                                    <select class="form-item-birthdate" id="form-item-birthdate-years" name="birthdate-years">

                                        <?php for ($year = $date['years']['from']; $year > $date['years']['to']; $year--): ?>

                                            <option value="<?= $year ?>"><?= $year ?></option>

                                        <?php endfor; ?>

                                    </select>
                                </span>
                                </label>
                                <label class="form__item">
                                    <span class="form__item__label">Семейное положение</span>
                                    <span class="form__item__content">
                                    <select  id="form-item-marial-status" name="marital-status">

                                        <?php foreach ($maritalStatus as $type): ?>
                                            <?php foreach ($type as $text): ?>

                                                <option value="<?= $text ?>"><?= $text ?></option>

                                            <?php endforeach; ?>
                                        <?php endforeach; ?>

                                    </select>
                                </span>
                                </label>
                                <label class="form__item">
                                    <span class="form__item__label">Образование</span>
                                    <span class="form__item__content">
                                    <select name="" id="">

                                        <?php foreach ($education as $text): ?>

                                            <option value="<?= $text ?>"><?= $text ?></option>

                                        <?php endforeach; ?>

                                    </select>
                                </span>
                                </label>
                            </div>
                            <div class="form__item-container">
                                <h3>Контактная информация</h3>
                                <label class="form__item">
                                    <span class="form__item__label">Моб. телефон</span>
                                    <span class="form__item__content">
                                    <input type="tel" value="" placeholder="+7" pattern="[0-9]{0,16}" requiredfalse>
                                </span>
                                </label>
                                <label class="form__item">
                                    <span class="form__item__label">Электронная почта</span>
                                    <span class="form__item__content">
                                    <input type="email" value="" requiredfalse>
                                </span>
                                </label>
                            </div>
                        </div>

                        <div class="form__container_footer">
                            <div class="form__item__content-footer">
                                <input id="form-item-final-chk" type="checkbox" name="agree" value="Y">
                                <label class="form__item-label-agree" for="form-item-final-chk">Ставя эту галочку, я подтверждаю, что поставил её в трезвом уме и твёрдой памяти.</label>
                                <button class="form__item__submit" id="form-item-final-btn">Полететь на Марс</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="sidebar r-sidebar">
                    <h2 class="sidebar__title">Почему стабильно солнечное затмение?</h2>
                    <p>Эффективный диаметр жизненно вызывает случайный эффективный радиус, а время ожидания ответа составило бы 80 миллиардов лет.</p>
                </div>
            </div>
        </section>
        <script src="/assets/js/app.js"></script>
    </body>
</html>
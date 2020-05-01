<?php
require_once realpath(__DIR__ . '/../includes/Settings.php'); // Настрйоки
require_once __DIR__ . "/../includes/helpers.php"; // Функции помощники
require_once __DIR__ . "/../includes/DB.php"; // Работа с базой
require_once __DIR__ . "/../routes/Sitemap.php"; // Карта сайта
require_once __DIR__ . "/../includes/page.php"; // Роутинг страниц

\Router::requireHeader('main_theme', [
    'css' => [
        '/assets/css/admin.css'
    ],
    'title' => 'Заявка на экскурсионный полёт на Марс',
]);


$db = \Includes\DB::getInstance();
$dbConnection = $db->connect();
$tableRegistration = $db->getAllUsers();

?>
<table>
    <thead>
        <tr>
            <td>Дата</td>
            <td>Фамилия</td>
            <td>Старая фамилия</td>
            <td>Имя</td>
            <td>Отчество</td>
            <td>Фамилия латиницей</td>
            <td>Имя латиницей</td>
            <td>Пол</td>
            <td>Дата рождения</td>
            <td>Семейное положение</td>
            <td>Образование</td>
            <td>Моб. телефон</td>
            <td>Электронная почта</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($tableRegistration as $registration)
        {
            ?><tr>
            <td><?= date('d.m.Y', $registration['date']); ?></td>
            <td><?= $registration['last_name']; ?></td>
            <td><?= $registration['old_last_name']; ?></td>
            <td><?= $registration['first_name']; ?></td>
            <td><?= $registration['patronymic']; ?></td>
            <td><?= $registration['last_name_lat']; ?></td>
            <td><?= $registration['first_name_lat']; ?></td>
            <td><?= $registration['gender'] === 'female'? 'Женский' : 'Мужской' ; ?></td>
            <td><?= $registration['birthdate_days']; ?> <?= $registration['birthdate_months']; ?> <?= $registration['birthdate_years']; ?></td>
            <td><?= $registration['marital_status']; ?></td>
            <td><?= $registration['education']; ?></td>
            <td><?= $registration['phone']; ?></td>
            <td><?= $registration['email']; ?></td>
            </tr><?
        }
        ?>
    </tbody>
</table>
<?php
//var_dump($res)

\Router::requireFooter('main_theme', []);


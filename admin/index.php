<?php
require_once realpath(__DIR__ . '/../includes/settings.php'); // Настрйоки
require_once __DIR__ . "/../includes/helpers.php"; // Функции помощники
require_once __DIR__ . "/../includes/db.php"; // Работа с базой
require_once __DIR__ . "/../routes/sitemap.php"; // Карта сайта
require_once __DIR__ . "/../includes/page.php"; // Роутинг страниц
//require_once './includes/Auth.php';

//$auth = new \Includes\Auth();
//$isAuth = $auth->needAuth('admin', '123');


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
    <caption>Регистрации</caption>
    <thead class="t-header">
        <tr>
            <td>Телефон</td>
            <td>Емайл</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Старая фамилия</td>
            <td>Отчество</td>
            <td>Фамилия латиницей</td>
            <td>Имя латинице</td>
            <td>Пол</td>
            <td>Дата рождения</td>
            <td>Семейное положение</td>
            <td>Образование</td>
        </tr>
    </thead>
    <tbody>
        <?php
//        var_dump($tableRegistration);

        foreach ($tableRegistration as $registration)
        {
            ?><tr>
            <td><?= $registration['phone']; ?></td>
            <td><?= $registration['email']; ?></td>
            <td><?= $registration['first_name']; ?></td>
            <td><?= $registration['last_name']; ?></td>
            <td><?= $registration['old_last_name']; ?></td>
            <td><?= $registration['patronymic']; ?></td>
            <td><?= $registration['last_name_lat']; ?></td>
            <td><?= $registration['first_name_lat']; ?></td>
            <td><?= $registration['gender']; ?></td>
            <td><?= $registration['birthdate_days']; ?>.<?= $registration['birthdate_months']; ?>.<?= $registration['birthdate_years']; ?></td>
            <td><?= $registration['marital_status']; ?></td>
            <td><?= $registration['education']; ?></td>
            </tr><?
        }
        ?>
    </tbody>
</table>
<?php
//var_dump($res)

\Router::requireFooter('main_theme', []);


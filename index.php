<?php
require_once "./includes/helpers.php"; // Функции помощники
require_once "./routes/sitemap.php"; // Карта сайта
require_once "./includes/page.php"; // Роутинг страниц

$sitemap = new \Includes\Sitemap();

$page = \Router::render($sitemap->getSitemap());

try {
    if (file_exists('./templates/' . $page . '.php')) {
        include './templates/' . $page . '.php';
    }
} catch (Exception $exception) {
    if (isset($exception->xdebug_message)) {
        echo $exception->xdebug_message;
    } else {
        var_dump($exception);
    }
}


<?php
require_once "./includes/helpers.php"; // Функции помощники
require_once "./routes/sitemap.php"; // Карта сайта
require_once "./includes/page.php"; // Роутинг страниц

$sitemap = new \Includes\Sitemap();

try {
    include \Router::render(true, $sitemap->getSitemap());
} catch (Exception $exception) {
    if (isset($exception->xdebug_message)) {
        echo $exception->xdebug_message;
    } else {
        var_dump($exception);
    }
}


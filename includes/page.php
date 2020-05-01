<?php
require_once realpath(__DIR__ . '/../routes/sitemap.php');


/**
 * Класс Одиночка предоставляет метод `GetInstance`, который ведёт себя как
 * альтернативный конструктор и позволяет клиентам получать один и тот же
 * экземпляр класса при каждом вызове.
 * @param карта сайта
 * @return возвращает страницу в виде строки
 */
class Router
{
    /**
     * Объект одиночки храниться в статичном поле класса.
     */
    private static $instance = null;

    /**
     * Конструктор Одиночки всегда должен быть скрытым, чтобы предотвратить
     * создание объекта через оператор new.
     */
    protected function __construct()
    {
    }

    /**
     * Одиночки не должны быть клонируемыми.
     */
    protected function __clone()
    {
    }

    /**
     * Одиночки не должны быть восстанавливаемыми из строк.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Это статический метод, управляющий доступом к экземпляру одиночки. При
     * первом запуске, он создаёт экземпляр одиночки и помещает его в
     * статическое поле. При последующих запусках, он возвращает клиенту объект,
     * хранящийся в статическом поле.
     *
     * Эта реализация позволяет вам расширять класс Одиночки, сохраняя повсюду
     * только один экземпляр каждого подкласса.
     */
    public static function getInstance($map)
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }

        return self::$instances[$cls];
    }

    /*
     *
     * @param
     * @return возвращает страницу в виде строки
     */
    public function route($map)
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($requestUri, "/");
        if (isset($map[$uri])) {
            return $map[$uri];
        } else {
            header('HTTP/1.1 404 Not Found');
            return '404';
        }
    }

    /*
     * Роутинг страниц. Функция служит для отображения страницы с конкретным названием и содержимым
     * @param карта сайта
     * @return
     */
    public function render($generate = true, $content)
    {
        if ($generate === true && $content) {
            $pageFile = Router::route($content);
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/pages/' . $pageFile .  '/index.php')) {
                return $_SERVER['DOCUMENT_ROOT'] . '/pages/' . $pageFile .  '/index.php';
            } else {
                header('HTTP/1.1 502 Bad Gateway');
                return realpath(__DIR__ . '/../pages/502/index.php');
            }
        } elseif ($generate === false && $content) {
            return $_SERVER['DOCUMENT_ROOT'] . '/pages/' . $content .  '/index.php';
        }
        return false;
    }

    /*
     * Подключает файлы
     * @param string
     * @return bool
     */
    public function requireHeader($template, $requires)
    {
        require realpath(__DIR__ . '/../templates/' . $template . '/header.php');

        return true;
    }

    /*
     * Подключает файлы
     * @param string
     * @return bool
     */
    public function requireFooter($template, $requires)
    {
        require realpath(__DIR__ . '/../templates/' . $template . '/footer.php');

        return true;
    }

    /*
     * Подключает файлы
     * @param string
     * @return bool
     */
    public function addJs(array $filesStrings)
    {
        foreach ($filesStrings as $file) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
                ?><script>
                <?php
                echo \Helper\btw(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file));
                ?>
                </script><?php
            } else {
                return false;
            }
        }

        return true;
    }

    /*
     * Подключает файлы
     * @param string
     * @return bool
     */
    public function addCss(array $filesStrings)
    {
        foreach ($filesStrings as $file) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
                ?><style>
                <?php
                echo \Helper\btw(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file));
                ?>
                </style><?php
            } else {
                return false;
            }
        }

        return true;
    }

    /*
    * Буферизация php файла
    * @param путь к подключаемому файлу
    * @param переменные для шаблона
    * @return возвращает содержимое файла в формате string
    */
    public function requireTemplate(array $filesString)
    {
        // не треба
    }
}
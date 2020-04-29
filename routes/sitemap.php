<?php
namespace Includes;

/**
 * Class Sitemap
 */
class Sitemap
{
    /**
     * Карта статических страниц
     * @var string
     */
    protected $sitemap = [
        '' => 'main',
        'index.php' => 'main',
        'admin' => 'admin',
        'admin/index.php' => 'admin',
    ];

    /**
     * Возвращает карту сайта
     * @return array
     */
    public function getSitemap()
    {
        return $this->sitemap;
    }
}
<?php
namespace Helper;

/*
* Сортирует массив по ключу
* @param массив
* @param ключ по которому будет производиться сортировка
* @param тип сортировки
* @return возвращает обрезанную строку
*/
function arraySortByKey(array $array, $key = 'sort', int $sort = SORT_ASC) {
    usort($array, function($a, $b) use ($key, $sort) {
        if ($sort === SORT_ASC) {
            return $a[$key] <=> $b[$key];
        } elseif ($sort === SORT_DESC) {
            return $a[$key] < $b[$key] ? 1 : -1;
        }
    });
    return $array;
}

/*
* Минификация кода
* @param строка
* @return строка
*/
function btw($b1) {
    $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
//    $b1 = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $b1);
    $b1 = str_replace(array("\r\n", "\r", "\t", '  '), '', $b1);
    return $b1;
}

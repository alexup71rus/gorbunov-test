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

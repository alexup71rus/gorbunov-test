<?php
namespace Helper;

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

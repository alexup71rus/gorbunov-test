<?php
require_once __DIR__ . '/arFields.php';

$translitTable = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
    'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
    'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
    'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh',
    'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'iu', 'я' => 'ia',
    'ъ' => 'ie'
];

$genderTable = [
    'ич' => 'male',
    'на' => 'female',
    'лы' => 'male',
    'зы' => 'female',
    'ва' => 'female',
];

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

/**/

$isAjax = false;

if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'Y') {
    $isAjax = true;
    unset($_REQUEST['ajax']);
}

if (count($_REQUEST)) {
    foreach ($arFields as $itemName => &$itemContent) {
//        if ($itemContent['required'] === false || (isset($_REQUEST[$itemName]) && mb_strlen($_REQUEST[$itemName])) ) {
        if ((isset($_REQUEST[$itemName]) && mb_strlen($_REQUEST[$itemName])) ) {
            $itemContent['value'] = $_REQUEST[$itemName];
            switch ($itemName) {
                case 'last-name':
                    if ( preg_match('/[^\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод кириллицей, дефис и пробел';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 20) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                        break;
                    }
                    break;

                case 'old-last-name':
                    if ( preg_match('/[^\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод кириллицей, дефис и пробел';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 20) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                    }
                    break;

                case 'first-name':
                    if ( preg_match('/[^\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод кириллицей, дефис и пробел';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 20) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                    }
                    break;

                case 'patronymic':
                    if ( preg_match('/[^\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод кириллицей, дефис и пробел';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 20) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                    }
                    break;

                case 'last-name_lat':
                    if ( preg_match('/[\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод только латиницей';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 25) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                    }
                    break;

                case 'first-name_lat':
                    if ( preg_match('/[\w\-]/', $_REQUEST[$itemName]) === 0 )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Допускается ввод только латиницей';
                    } elseif (mb_strlen($_REQUEST[$itemName]) > 25) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Вы превысили максимальное значение поля в 20 символов';
                    }
                    break;

                case 'gender':
                    if ($_REQUEST[$itemName] !== 'male' && $_REQUEST[$itemName] !== 'female') {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    }
                    break;


                case 'birthdate-days':
                    if (
                        !(int) $_REQUEST[$itemName]
                        || (int) $_REQUEST[$itemName] > 31
                        || (int) $_REQUEST[$itemName] < 1
                    )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    }
                    break;

                case 'birthdate-months':
                    if (
                        !isset($date['months'][$_REQUEST[$itemName]])
                    )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    }
                    break;

                case 'birthdate-years':
                    if (
                        $date['years']['from'] < $_REQUEST[$itemName]
                        || $date['years']['to'] > $_REQUEST[$itemName]
                    )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    }
                    break;

                case 'marital-status':
                    if (
                        !isset($_REQUEST['gender'])
                        || !isset( $maritalStatus[$_REQUEST['gender']] )
                    )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    } else {
                        if (isset($_REQUEST['gender']) && isset( $maritalStatus[$_REQUEST['gender']] ) ) {
                            $itemContent['error'] = true;
                            $itemContent['text_error'] = 'Невернвый формат';
                            foreach ($maritalStatus[$_REQUEST['gender']] as $item) {
                                if ($item === $_REQUEST[$itemName]) {
                                    $itemContent['error'] = false;
                                    $itemContent['text_error'] = '';
                                }
                            }
                        }
                    }
                    break;

                case 'education':
                    if (
                        ! isset($education[$_REQUEST[$itemName]])
                    )
                    {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Невернвый формат';
                    }
                    break;

                case 'phone':
                    if (
                        preg_match('/\+7 [\d \-]/', $_REQUEST[$itemName]) === 0
                        || mb_strlen($_REQUEST[$itemName]) > 16
                        || mb_strlen($_REQUEST[$itemName]) < 11
                    ) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Только цифры, до 16 символов';
                    }
                    break;

                case 'email':
                    if (
                        preg_match('/(.*(@).+)/', $_REQUEST[$itemName]) === 0
                    ) {
                        $itemContent['error'] = true;
                        $itemContent['text_error'] = 'Не сможем связаться по этому адресу';
                    }
                    break;
            }
        } else {
            $itemContent['error'] = true;
            $itemContent['text_error'] = 'Поле не заполнено';
        }
    }
//    var_dump($arFields);
}

if ($isAjax) {
    header('Content-Type: application/json');
    die(json_encode($arFields));
}
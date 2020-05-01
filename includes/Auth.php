<?php
namespace Includes;


class Auth
{
    public function needAuth()
    {
        $settings = \Includes\Settings::getInstance();
        $users = $settings->users();
        $needAuth = true;

        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

        if ($has_supplied_credentials) {
            foreach ($users as $name => $user) {
                if ($name == $_SERVER['PHP_AUTH_USER'] && $user['password'] == $_SERVER['PHP_AUTH_PW']) {
                    exit;
                }
            }
        } else {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
//        $_COOKIE
    }

   /* public function auth($login, $pass)
    {
        $settings = \Includes\Settings::getInstance();
        $dataSettings = $settings->users();
        if (isset($dataSettings[$login]) && isset($dataSettings[$login]['password']) && $dataSettings[$login]['password'] === $pass) {
            return true;
        }
        return false;
    }*/
}
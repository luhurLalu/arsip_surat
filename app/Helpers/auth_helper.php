<?php
if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return session()->get('isLoggedIn') === true;
    }
}

if (!function_exists('current_user')) {
    function current_user()
    {
        return [
            'user_id'  => session()->get('user_id'),
            'username' => session()->get('username'),
            'role'     => session()->get('role'),
        ];
    }
}

if (!function_exists('require_login')) {
    function require_login()
    {
        if (!is_logged_in()) {
            redirect()->to('/login')->send();
            exit;
        }
    }
}

<?php
require_once 'data.php';

class Auth {
    public static function login($username, $password) {
        $users = DataStorage::getUsers();

        foreach ($users as $user) {
            if (
                $user['username'] === $username &&
                !empty($user['is_active']) &&
                password_verify($password, $user['password'])
            ) {
                session_start();
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    public static function logout() {
        session_start(); 
        session_destroy();
    }

    public static function isAuthenticated() {
        session_start();
        return isset($_SESSION['user']);
    }

    public static function getUser() {
        session_start();
        return $_SESSION['user'] ?? null;
    }

    public static function isAdmin() {
        session_start();
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public static function requireLogin() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            exit();
        }
    }
}

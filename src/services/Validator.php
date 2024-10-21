<?php

namespace App\Services;

class Validator
{
    public static function password($password)
    {
        $hasSpace = preg_match('/\s/', $password);
        $hasUppercase = preg_match('/[A-Z]/', $password);
        $hasLowercase = preg_match('/[a-z]/', $password);
        $hasSpecial = preg_match('/[@*#&]+/', $password);
        $hasNumber = preg_match('/[0-9]+/', $password);

        if ($hasSpace) {
            return ['success' => false, 'message' => 'Mật khẩu không được chứa khoảng trắng.'];
        }

        if (!$hasSpecial) {
            return ['success' => false, 'message' => 'Mật khẩu phải có ít nhất 1 kí tự đặc biệt.'];
        }

        if (!$hasLowercase || !$hasUppercase || !$hasNumber) {
            return ['success' => false, 'message' => 'Mật khẩu phải có cả chữ hoa, chữ thường và số.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Mật khẩu phải lớn hơn 6 kí tự.'];
        }

        return ['success' => true, 'message' => 'Mật khẩu hợp lệ.'];
    }

    public static function email($email)
    {
        $emailRegex = preg_match('/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}/', $email);
        if (!$emailRegex) {
            return ['success' => false, 'message' => "Địa chỉ email không hợp lệ."];
        }
        return ['success' => true, 'message' => "Địa chỉ email hợp lệ."];
    }

    public static function name($name)
    {
        $nameRegex = preg_match("/^[a-zA-Z]+$/", $name);
        if (!$nameRegex) {
            return ['success' => false, 'message' => 'Tên người dùng chỉ cho phép chữ hoa và chữ thường.'];
        }

        if (strlen($name) < 2 || strlen($name) > 20) {
            return ['success' => false, 'message' => 'Tên người dùng phải lớn hơn 2 kí tự và nhỏ hơn 20 kí tự.'];
        }

        return ['success' => true, 'message' => 'Tên người dùng hợp lệ.'];
    }
}
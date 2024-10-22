<?php

namespace App\Utils;

class Utils {
    public static function generateVerificationCode() {
        return rand(100000, 999999);
    }
}
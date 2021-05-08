<?php

namespace App\Validation;

use App\Models\Users;

class UserRules
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        $model = new Users();
        $user = $model->where('email', $data['email'])->first();

        if (!$user) {
            return false;
        }

        return password_verify($data['password'], $user['password']);
    }
}

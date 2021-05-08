<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $beforeInsert = ['beforeInsert'];

    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        $data = $this->hashPassword($data);

        return $data;
    }

    protected function beforeUpdate(array $data): array
    {
        $data = $this->hashPassword($data);

        return $data;
    }

    private function hashPassword(array $data): array
    {
        if(isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Test\CIUnitTestCase;

class UserModelTest extends CIUnitTestCase
{
    public function testIfPasswordGetsHashed()
    {
        $SUT = new UserModel();

        $hashPassword = $this->getPrivateMethodInvoker($SUT, 'hashPassword');

        $testData = [
            'data' => [
                'password' => '1234',
            ],
        ];
        $hashedData = $hashPassword($testData);

        $this->assertNotEquals($testData['data']['password'], $hashedData['data']['password']);
    }
}

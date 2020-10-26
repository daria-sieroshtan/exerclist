<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @group unit
 */
class UserTest extends TestCase
{
    protected function getSut()
    {
        $user = new User();
        $user->setName('Name');
        $user->setPassword('password');
        return $user;
    }

    /**
     * @dataProvider provideUsers
     */
    public function testShouldReturnIsEqualToUser($result, $user)
    {
        $this->assertEquals($result, $this->getSut()->isEqualTo($user));
    }

    public function provideUsers()
    {
        $stub = $this->createStub(UserInterface::class);

        $userWithDifferentName = new User();
        $userWithDifferentName->setName('Different Name');
        $userWithDifferentName->setPassword('password');

        $userWithDifferentPassword = new User();
        $userWithDifferentPassword->setName('Name');
        $userWithDifferentPassword->setPassword('Different password');

        $user = new User();
        $user->setName('Name');
        $user->setPassword('password');

        return [
            [false, $stub],
            [false, $userWithDifferentName],
            [false, $userWithDifferentPassword],
            [true, $user]
        ];
    }
}

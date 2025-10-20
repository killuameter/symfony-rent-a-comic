<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    // public function testSomething(): void
    // {
    //     $this->assertTrue(true);
    // }
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail('test@test.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setPassword('password')
            ->setMyMoney('88.22');

        $this->assertTrue($user->getEmail()==='test@test.com');
        $this->assertTrue($user->getFirstName()==='John');
        $this->assertTrue($user->getLastName()==='Doe');
        $this->assertTrue($user->getPassword()==='password');
        $this->assertTrue($user->getMyMoney()==='88.22');

    }
    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail('test@test.com')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setPassword('password')
            ->setMyMoney('88.22');

        $this->assertFalse($user->getEmail()==='false@test.com');
        $this->assertFalse($user->getFirstName()==='false');
        $this->assertFalse($user->getLastName()==='false');
        $this->assertFalse($user->getPassword()==='false');
        $this->assertFalse($user->getMyMoney()==='00.00');

    }
    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstName());
        $this->assertEmpty($user->getLastName());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getMyMoney());

    }
}

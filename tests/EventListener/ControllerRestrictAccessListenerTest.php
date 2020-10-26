<?php

namespace App\Tests\EventListener;

use App\Entity\Exercise;
use App\Entity\User;
use App\EventListener\ControllerRestrictAccessListener;
use Doctrine\Common\Annotations\Reader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @group unit
 */
class ControllerRestrictAccessListenerTest extends TestCase
{
    private $user;
    private $anotherUser;

    public function __construct()
    {
        parent::__construct();

        $this->user = new User();
        $this->user->setName('Name');
        $this->user->setPassword('password');

        $this->anotherUser = clone $this->user;
        $this->anotherUser->setName('Another Name');

    }

    protected function getSut()
    {
        return new ControllerRestrictAccessListener($this->createStub(Reader::class), $this->createStub(Security::class));
    }

    public function testShouldRestrictViewAccess()
    {
        $entity = new Exercise();
        $entity->setIsPrivate(true);
        $entity->setUser($this->anotherUser);

        $this->expectException(AccessDeniedException::class);
        $this->getSut()->restrictViewAccess($entity, $this->user);

    }

    public function testShouldRestrictModifyAccess()
    {
        $entity = new Exercise();
        $entity->setUser($this->anotherUser);

        $this->expectException(AccessDeniedException::class);
        $this->getSut()->restrictModifyAccess($entity, $this->user);

    }

    public function testShouldAllowViewAccess()
    {
        $entity = new Exercise();

        $entity->setIsPrivate(false);
        $entity->setUser($this->anotherUser);
        $this->assertNull($this->getSut()->restrictViewAccess($entity, $this->user));

        $entity->setIsPrivate(false);
        $entity->setUser($this->user);
        $this->assertNull($this->getSut()->restrictViewAccess($entity, $this->user));

        $entity->setIsPrivate(true);
        $entity->setUser($this->user);
        $this->assertNull($this->getSut()->restrictViewAccess($entity, $this->user));
    }

    public function testShouldAllowModifyAccess()
    {
        $entity = new Exercise();
        $entity->setUser($this->user);
        $this->assertNull($this->getSut()->restrictModifyAccess($entity, $this->user));

    }
}

<?php

namespace App\Tests\Security;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group unit
 */
class EmailVerifierTest  extends TestCase
{
    protected function getSut($entityManagerMock=null)
    {
        $helperStub = $this->createStub(VerifyEmailHelperInterface::class);
        $helperStub->method('validateEmailConfirmation');

        if($entityManagerMock == null) {
            $entityManagerMock =$this->createStub(EntityManagerInterface::class);
        }

        return new EmailVerifier($helperStub, $this->createStub(MailerInterface::class), $entityManagerMock);
    }

    public function testHandleEmailConfirmation()
    {
        $requestStub = $this->createStub(Request::class);
        $requestStub->method('getUri')->willReturn("null");

        $reflectionClass = new ReflectionClass("App\Entity\User");
        $user = new User();
        $user->setEmail('email');
        $reflectionProperty = $reflectionClass->getProperty("id");
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($user, 1);

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($user);

        $em->expects($this->once())
            ->method('flush');

        $this->getSut($em)->handleEmailConfirmation($requestStub, $user);

        $this->assertTrue($user->isVerified());
        $this->assertEquals(['ROLE_USER', 'ROLE_USER_UNVERIFIED'], $user->getRoles());
    }
}

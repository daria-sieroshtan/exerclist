<?php

namespace App\EventListener;

use App\Annotation\RestrictAccess;
use App\Entity\OwnableEntityInterface;
use App\Entity\User;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ControllerRestrictAccessListener
{
    private $reader;
    private $security;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader, Security $security)
    {
        $this->reader = $reader;
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelController(ControllerArgumentsEvent $event)
    {
        if (!is_array($controllers = $event->getController())) {
            return null;
        }

        list($controller, $methodName) = $controllers;

        $reflectionClass = new \ReflectionClass($controller);
        $classAnnotation = $this->reader
            ->getClassAnnotation($reflectionClass, RestrictAccess::class);

        $reflectionObject = new \ReflectionObject($controller);
        $reflectionMethod = $reflectionObject->getMethod($methodName);
        $methodAnnotation = $this->reader
            ->getMethodAnnotation($reflectionMethod, RestrictAccess::class);

        if (!($classAnnotation || $methodAnnotation)) {
            return null;
        }

        $user = $this->security->getUser();

        $controllerArguments = $event->getArguments();

        foreach ($controllerArguments as $argument) {
            if ($argument instanceof OwnableEntityInterface) {
                $entity = $argument;
                break;
            }
        }

        if (($classAnnotation && $classAnnotation->getWrite()) || ($methodAnnotation && $methodAnnotation->getWrite())) {
            $this->restrictModifyAccess($entity, $user);
        } else {
            $this->restrictViewAccess($entity, $user);
        }
    }

    public function restrictViewAccess(OwnableEntityInterface $entity, UserInterface $user)
    {
        if ($entity->getIsPrivate() && !$entity->getUser()->isEqualTo($user)) {
            throw new AccessDeniedException('Access Denied.');
        }
    }

    public function restrictModifyAccess(OwnableEntityInterface $entity, UserInterface $user)
    {
        if (!$entity->getUser()->isEqualTo($user)) {
            throw new AccessDeniedException('Access Denied.');
        }
    }
}

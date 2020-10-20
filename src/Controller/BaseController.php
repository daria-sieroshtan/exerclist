<?php

namespace App\Controller;

use App\Entity\OwnableEntityInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Contracts\Translation\TranslatorInterface;

//todo: exercise now page

class BaseController extends AbstractController
{

    const ITEMS_PER_PAGE = 10;

    /**
     * @param string $message
     * @return void
     */
    public function addNoticeFlash($message)
    {
        $this->addFlash('notice', $message);
    }

    public function addSuccessFlash($message)
    {
        $this->addFlash('success', $message);
    }

    public function addDangerFlash($message)
    {
        $this->addFlash('danger', $message);
    }

    /**
     * @param $entity
     */
    public function saveEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * @param $entity
     */
    public function removeEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }

    /**
     * @param Request $request
     * @return string|string[]|null
     */
    public function getPreviousUrl(Request $request)
    {
        $redirect = $request->headers->get('referer') ?? $this->generateUrl('home');
        return $redirect;
    }
}

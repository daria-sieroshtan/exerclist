<?php

namespace App\Controller;

use App\Annotation\RestrictAccess;
use App\Entity\TrackTag;
use App\Form\TrackTagType;
use App\Repository\TrackTagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/track-tag")
 */
class TrackTagController extends BaseController
{
    /**
     * @Route("/list/{page}/", defaults={"page"=1}, name="track_tag_index", methods={"GET"})
     */
    public function index(TrackTagRepository $trackTagRepository, UserInterface $user, PaginatorInterface $paginator, $page): Response
    {
        $pagination = $paginator->paginate(
            $trackTagRepository->findListForPagination($user->getId()),
            $page,
            $this::ITEMS_PER_PAGE
        );

        return $this->render('track_tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="track_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $trackTag = new TrackTag();
        $form = $this->createForm(TrackTagType::class, $trackTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackTag = $form->getData();
            $this->saveEntity($trackTag);

            $this->addSuccessFlash(sprintf('Successfully created track tag "%s"', $trackTag->getName()));
            return $this->redirectToRoute('track_tag_index');
        }

        return $this->render('track_tag/new.html.twig', [
            'track_tag' => $trackTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="track_tag_edit", methods={"GET","POST"})
     * @RestrictAccess(write=true)
     */
    public function edit(Request $request, TrackTag $trackTag): Response
    {
        $form = $this->createForm(TrackTagType::class, $trackTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackTag = $form->getData();
            $this->saveEntity($trackTag);

            $this->addSuccessFlash(sprintf('Successfully edited track tag "%s"', $trackTag->getName()));
            return $this->redirectToRoute('track_tag_index');
        }

        return $this->render('track_tag/edit.html.twig', [
            'track_tag' => $trackTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="track_tag_delete")
     * @RestrictAccess(write=true)
     */
    public function delete(TrackTag $trackTag): Response
    {
        $this->removeEntity($trackTag);
        $this->addSuccessFlash('Successfully deleted track tag.');

        return $this->redirectToRoute('track_tag_index');
    }


    /**
     * @Route("/{id}", name="track_tag_show", methods={"GET"})
     * @RestrictAccess
     */
    public function show(TrackTag $trackTag): Response
    {
        return $this->render('track_tag/show.html.twig', [
            'track_tag' => $trackTag,
        ]);
    }
}

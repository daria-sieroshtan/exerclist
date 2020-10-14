<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\TrackRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/track")
 */
class TrackController extends BaseController
{
    /**
     * @Route("/list/{page}/", defaults={"page"=1}, name="track_index", methods={"GET"})
     */
    public function index(TrackRepository $trackRepository, UserInterface $user, PaginatorInterface $paginator, $page): Response
    {
        $pagination = $paginator->paginate(
            $trackRepository->findListForPagination($user->getId()),
            $page,
            $this::ITEMS_PER_PAGE
        );

        return $this->render('track/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="track_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $track = $form->getData();
            $track->setUser($user);
            $this->saveEntity($track);

            $this->addSuccessFlash(sprintf('Successfully created track "%s"', $track->getName()));
            return $this->redirectToRoute('track_index');
        }

        return $this->render('track/new.html.twig', [
            'track' => $track,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="track_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Track $track): Response
    {
        $this->restrictModifyAccess($track);

        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $track = $form->getData();
            $this->saveEntity($track);

            $this->addSuccessFlash(sprintf('Successfully edited track "%s"', $track->getName()));
            return $this->redirectToRoute('track_index');
        }

        return $this->render('track/edit.html.twig', [
            'track' => $track,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="track_delete")
     */
    public function delete(Track $track): Response
    {
        $this->restrictModifyAccess($track);

        $this->removeEntity($track);
        $this->addSuccessFlash('Successfully deleted track.');


        return $this->redirectToRoute('track_index');
    }


    /**
     * @Route("/{id}", name="track_show", methods={"GET"})
     */
    public function show(Track $track): Response
    {
        $this->restrictViewAccess($track);

        return $this->render('track/show.html.twig', [
            'track' => $track,
        ]);
    }
}

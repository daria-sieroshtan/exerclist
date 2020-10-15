<?php

namespace App\Controller;

use App\Annotation\RestrictAccess;
use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/playlist")
 */
class PlaylistController extends BaseController
{
    /**
     * @Route("/list/{page}/", defaults={"page"=1}, name="playlist_index", methods={"GET"})
     */
    public function index(PlaylistRepository $playlistRepository, UserInterface $user, PaginatorInterface $paginator, $page): Response
    {
        $pagination = $paginator->paginate(
            $playlistRepository->findListForPagination($user->getId()),
            $page,
            $this::ITEMS_PER_PAGE
        );

        return $this->render('playlist/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="playlist_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playlist = $form->getData();
            $this->saveEntity($playlist);

            $this->addSuccessFlash(sprintf('Successfully created playlist "%s"', $playlist->getName()));
            return $this->redirectToRoute('playlist_index');
        }

        return $this->render('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="playlist_edit", methods={"GET","POST"})
     * @RestrictAccess(write=true)
     */
    public function edit(Request $request, Playlist $playlist): Response
    {
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playlist = $form->getData();
            $this->saveEntity($playlist);

            $this->addSuccessFlash(sprintf('Successfully edited playlist "%s"', $playlist->getName()));
            return $this->redirectToRoute('playlist_index');
        }

        return $this->render('playlist/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="playlist_delete")
     * @RestrictAccess(write=true)
     */
    public function delete(Playlist $playlist): Response
    {
        $this->removeEntity($playlist);
        $this->addSuccessFlash('Successfully deleted playlist.');

        return $this->redirectToRoute('playlist_index');
    }


    /**
     * @Route("/{id}", name="playlist_show", methods={"GET"})
     * @RestrictAccess
     */
    public function show(Playlist $playlist): Response
    {
        return $this->render('playlist/show.html.twig', [
            'playlist' => $playlist,
        ]);
    }
}

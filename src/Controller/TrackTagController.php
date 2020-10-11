<?php

namespace App\Controller;

use App\Entity\TrackTag;
use App\Form\TrackTagType;
use App\Repository\TrackTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/track-tag")
 */
class TrackTagController extends BaseController
{
    /**
     * @Route("/", name="track_tag_index", methods={"GET"})
     */
    public function index(TrackTagRepository $trackTagRepository): Response
    {
        return $this->render('track_tag/index.html.twig', [
            'track_tags' => $trackTagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="track_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
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
     * @Route("/{id}", name="track_tag_show", methods={"GET"})
     */
    public function show(TrackTag $trackTag): Response
    {
        return $this->render('track_tag/show.html.twig', [
            'track_tag' => $trackTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="track_tag_edit", methods={"GET","POST"})
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
     */
    public function delete(Request $request, TrackTag $trackTag): Response
    {
        $this->removeEntity($trackTag);
        $this->addSuccessFlash('Successfully deleted track tag.');

        return $this->redirectToRoute('track_tag_index');
    }
}

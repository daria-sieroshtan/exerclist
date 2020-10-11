<?php

namespace App\Controller;

use App\Entity\ExerciseTag;
use App\Form\ExerciseTagType;
use App\Repository\ExerciseTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exercise-tag")
 */
class ExerciseTagController extends BaseController
{
    /**
     * @Route("/", name="exercise_tag_index", methods={"GET"})
     */
    public function index(ExerciseTagRepository $exerciseTagRepository): Response
    {
        return $this->render('exercise_tag/index.html.twig', [
            'exercise_tags' => $exerciseTagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="exercise_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exerciseTag = new ExerciseTag();
        $form = $this->createForm(ExerciseTagType::class, $exerciseTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseTag = $form->getData();
            $this->saveEntity($exerciseTag);

            $this->addSuccessFlash(sprintf('Successfully created exercise tag "%s"', $exerciseTag->getName()));
            return $this->redirectToRoute('exercise_tag_index');
        }

        return $this->render('exercise_tag/new.html.twig', [
            'exercise_tag' => $exerciseTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="exercise_tag_show", methods={"GET"})
     */
    public function show(ExerciseTag $exerciseTag): Response
    {
        return $this->render('exercise_tag/show.html.twig', [
            'exercise_tag' => $exerciseTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="exercise_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExerciseTag $exerciseTag): Response
    {
        $form = $this->createForm(ExerciseTagType::class, $exerciseTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseTag = $form->getData();
            $this->saveEntity($exerciseTag);

            $this->addSuccessFlash(sprintf('Successfully edited exercise tag "%s"', $exerciseTag->getName()));
            return $this->redirectToRoute('exercise_tag_index');
        }

        return $this->render('exercise_tag/edit.html.twig', [
            'exercise_tag' => $exerciseTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="exercise_tag_delete")
     */
    public function delete(Request $request, ExerciseTag $exerciseTag): Response
    {
        $this->removeEntity($exerciseTag);
        $this->addSuccessFlash('Successfully deleted exercise tag.');

        return $this->redirectToRoute('exercise_tag_index');
    }
}

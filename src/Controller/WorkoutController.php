<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\WorkoutType;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/workout")
 */
class WorkoutController extends BaseController
{
    /**
     * @Route("/", name="workout_index", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('workout/index.html.twig', [
            'workouts' => $workoutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="workout_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workout = $form->getData();
            $this->saveEntity($workout);

            $this->addSuccessFlash(sprintf('Successfully created workout "%s"', $workout->getName()));
            return $this->redirectToRoute('workout_index');
        }

        return $this->render('workout/new.html.twig', [
            'workout' => $workout,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="workout_show", methods={"GET"})
     */
    public function show(Workout $workout): Response
    {
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="workout_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Workout $workout): Response
    {
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workout = $form->getData();
            $this->saveEntity($workout);

            $this->addSuccessFlash(sprintf('Successfully edited workout "%s"', $workout->getName()));
            return $this->redirectToRoute('workout_index');
        }

        return $this->render('workout/edit.html.twig', [
            'workout' => $workout,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="workout_delete")
     */
    public function delete(Request $request, Workout $workout): Response
    {
        $this->removeEntity($workout);
        $this->addSuccessFlash('Successfully deleted workout.');

        return $this->redirectToRoute('workout_index');
    }
}

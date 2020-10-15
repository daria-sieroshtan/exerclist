<?php

namespace App\Controller;

use App\Annotation\RestrictAccess;
use App\Entity\Workout;
use App\Form\WorkoutType;
use App\Repository\WorkoutRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/workout")
 */
class WorkoutController extends BaseController
{
    /**
     * @Route("/list/{page}/", defaults={"page"=1},name="workout_index", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository, UserInterface $user, PaginatorInterface $paginator, $page): Response
    {
        $pagination = $paginator->paginate(
            $workoutRepository->findListForPagination($user->getId()),
            $page,
            $this::ITEMS_PER_PAGE
        );

        return $this->render('workout/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="workout_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
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
     * @Route("/{id}/edit", name="workout_edit", methods={"GET","POST"})
     * @RestrictAccess(write=true)
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
     * @RestrictAccess(write=true)
     */
    public function delete(Workout $workout): Response
    {
        $this->removeEntity($workout);
        $this->addSuccessFlash('Successfully deleted workout.');

        return $this->redirectToRoute('workout_index');
    }

    /**
     * @Route("/{id}", name="workout_show", methods={"GET"})
     * @RestrictAccess
     */
    public function show(Workout $workout): Response
    {
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }
}

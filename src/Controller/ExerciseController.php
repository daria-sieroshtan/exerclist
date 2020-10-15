<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\ExerciseType;
use App\Repository\ExerciseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Annotation\RestrictAccess;

/**
 * @Route("/exercise")
 */
class ExerciseController extends BaseController
{
    /**
     * @Route("/list/{page}/", defaults={"page"=1}, name="exercise_index", methods={"GET"})
     */
    public function index(ExerciseRepository $exerciseRepository, UserInterface $user, PaginatorInterface $paginator, $page): Response
    {
        $pagination = $paginator->paginate(
            $exerciseRepository->findListForPagination($user->getId()),
            $page,
            $this::ITEMS_PER_PAGE
        );

        return $this->render('exercise/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="exercise_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $this->saveEntity($exercise);

            $this->addSuccessFlash(sprintf('Successfully created exercise "%s"', $exercise->getName()));
            return $this->redirectToRoute('exercise_index');
        }

        return $this->render('exercise/new.html.twig', [
            'exercise' => $exercise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="exercise_edit", methods={"GET","POST"})
     * @RestrictAccess(write=true)
     */
    public function edit(Request $request, Exercise $exercise): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $this->saveEntity($exercise);

            $this->addSuccessFlash(sprintf('Successfully edited exercise "%s"', $exercise->getName()));
            return $this->redirectToRoute('exercise_index');
        }

        return $this->render('exercise/edit.html.twig', [
            'exercise' => $exercise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="exercise_delete")
     * @RestrictAccess(write=true)
     */
    public function delete(Exercise $exercise): Response
    {
        $this->removeEntity($exercise);
        $this->addSuccessFlash('Successfully deleted exercise.');

        return $this->redirectToRoute('exercise_index');
    }


    /**
     * @Route("/{id}", name="exercise_show", methods={"GET"})
     * @RestrictAccess
     */
    public function show(Exercise $exercise): Response
    {
        return $this->render('exercise/show.html.twig', [
            'exercise' => $exercise,
        ]);
    }
}

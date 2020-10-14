<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/password/{id}/",
     *     name="password_change",
     *     )
     * @Template("/user/edit_password.html.twig")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, User $user)
    {
        if ($user != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkPass = $passwordEncoder->isPasswordValid($user, $form->get('oldPassword')->getData());
            if ($checkPass === true) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $this->saveEntity($user);
                $this->addSuccessFlash('Successfully changed password.');
                return $this->redirectToRoute('home');
            } else {
                $this->addDangerFlash('Current password provided is invalid.');
                return $this->redirectToRoute('profile_password_change', ['id' => $user->getId()]);
            }
        }
        return ['form' => $form->createView()] ;
    }

    /**
     * @Route("/edit/{id}/",
     *     name="user_edit",
     *     )
     * @Template("/user/edit.html.twig")
     */
    public function edit(Request $request, User $user)
    {
        if ($user != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $this->saveEntity($user);
                $this->addSuccessFlash('Successfully edited user.');
                return $this->redirectToRoute('home');
        }
        return ['form' => $form->createView()] ;
    }
}

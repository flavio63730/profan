<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     *
     * @throws \Exception
     *
     * @return Response
     *
     * @Route("/", name="app_user_index")
     * @Method({"GET"})
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_user_create")
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $form->createView(),
            'new' => true,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit")
     */
    public function edit(Request $request, int $id, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $password = $user->getPassword();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ( $password !== $user->getPassword() ) {
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $form->createView(),
            'new' => false,
            'historiques' => $user->getHistoriques(),
        ]);
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="app_user_delete")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, User $user)
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller {
    /**
     * @param $id
     * @return Response
     * @Route("/user/{id}", name="get_user")
     */
    public function getUser($id) {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $user = $repository->find($id);
        return $this->render('user.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route()("/form-new-user/", name="form-new-user")
     */
    public function formNewUser() {
        return $this->render("form-new-user.html.twig");
    }

    /**
     * @return Response
     * @param Request $request
     * @Route()("/new-user", name="new-user")
     */
    public function newUser(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setLogin($request->get('login'));
        $user->setPassword($request->get('password'));
        $user->setName($request->get('name'));
        /** @var UploadedFile $avatar */
        $avatar = $request->files->get('user_avatar');
        copy($avatar->getRealPath(),
            __DIR__ . '/../../public/' .
            $avatar->getClientOriginalName());
        $user->setAvatarPath($avatar->getClientOriginalName());
        $em->persist($user);
        $em->flush();

        return new Response('saved new user with id: '.$user->getId());
    }
}
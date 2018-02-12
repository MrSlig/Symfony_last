<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller {

    const MONTH = 60*60*24*30;

    /**
     * @param $id
     * @return Response
     * @Route("/user/{id}", name="get_user")
     */
    public function getUserById($id) {    // check conflicts with build-in getUser method
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

    public function createSession($user_id) {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        /** @var User $user */
        $user = $repository->find($user_id);
        $session = new Session();
        $session->start();

        $token = Functions::getRndStr(32);
        $time = time();

        $session->set('user_id' , $user_id);
        $session->set('token'   , $token);
        $session->set('time'    , $time);

        $this->setAuthRecord($user_id, $token, $time);
        $this->setAuthCookie($user_id);

        $user->setSession($session);
        return $this->render('user.html.twig', [
            'user' => $user,
        ]);
    }

    public function setAuthCookie($user_id) {
        $repository = $this->getDoctrine()
            ->getRepository(Authorization::class);
        /** @var Authorization $auth */
        $auth = $repository->find($user_id);

        $response = new Response();
        $response->headers->setCookie(new Cookie('user_id'  , $auth->login  , MONTH, '/', '', true));
        $response->headers->setCookie(new Cookie('token'    , $auth->token  , MONTH, '/', '', true));
        $response->headers->setCookie(new Cookie('serial'   , $auth->serial , MONTH, '/', '', true));
        $response->headers->setCookie(new Cookie('time'     , $auth->date   , MONTH, '/', '', true));
    }

    public function rmAuthCookie() {
        $response = new Response();
        $response->headers->setCookie(new Cookie('user_id'  , '', 1));
        $response->headers->setCookie(new Cookie('token'    , '', 1));
        $response->headers->setCookie(new Cookie('serial'   , '', 1));
        $response->headers->setCookie(new Cookie('time'     , '', 1));
    }

    public function setAuthRecord($user_id, $token, $time) {
        $serial = Functions::getRndStr(32);
        $em = $this->getDoctrine()->getManager();
        $auth = new Authorization();
        $auth->setUserId($user_id);
        $auth->setToken($token);
        $auth->setSerial($serial);
        $auth->setTime($time);
        $em->persist($auth);
        $em->flush();
    }

    public function ifLogged()  {
        $status = false;
        //TODO
        $login = $token = 1;
        if($login && $token)    {
            //TODO
        } else {
            //TODO
        }
    }

    public function checkAuthCookie() {
        //TODO
    }
}
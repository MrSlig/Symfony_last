<?php

namespace App\Controller;
//use App\Entity\Post;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @param string $name
     * @return Response
     * @Route("/", name="index")
     */
    public function index(string $name = 'Гость') {
//        $response = new Response('<h1>Привет ' . $name . '!</h1>');
//        return $response;
    return $this->render('index.html.twig', [
        'name' => $name,
        'list' => [
            'Вася',
            'Петя',
            'Рома',
            ]
        ]);
    }
}
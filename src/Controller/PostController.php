<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route()("/form-post/", name="form-post")
     */
    public function formPost() {
        return $this->render("form-post.html.twig");
    }

    /**
     * @param $id
     * @return Response
     * @Route("/post/{id}", name="get_post")
     */
    public function getPost($id) {
        $repository = $this->getDoctrine()
            ->getRepository(Post::class);
        $post = $repository->find($id);
        return $this->render('post.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new-post", name="new-post")
     */
    public function newPost(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();
        $post->setTitle($request->get('title'));
        $post->setText($request->get('text'));
        /** @var UploadedFile $image */
//        dump($request->files);
//        die;
        $image = $request->files->get('image_path');
        copy($image->getRealPath(),
            __DIR__ . '/../../public/' .
            $image->getClientOriginalName());
        $post->setImagePath($image->getClientOriginalName());
        $em->persist($post);
        $em->flush();

        return new Response('saved new post with id '.$post->getId());
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/form-2-post/", name="form-2-post")
     */
    public function form2Post(Request $request) {
        $post = new Post();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class, [
                'label' => 'Заголовок ',
            ])
            ->add('text', TextType::class, [
                'label' => 'Текст ',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить пост'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())    {
            /** @var Post $post */
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
//            dump($post);
//            die();

            return $this->redirectToRoute('get_post', [
                'id' => $post->getId(),
            ]);
        }

        return $this->render('new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
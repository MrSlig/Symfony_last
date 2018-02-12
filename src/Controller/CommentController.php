<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller   {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new-comment/{postId}/{subcommentId}", name="new-comment")
     */
    public function newComment(Request $request, $text = 'test', $postId = 101, $subcommentId = 0, $userId = 404)
    {
        $postId = $request->get('postId');
        $subcommentId = $request->get('subcommentId');
        $comment = new Comment();
        $comment->setText($text);
        $comment->setDate(time());
        $comment->setUserId($userId);
        $comment->setPostId($postId);
        $post = $this->getDoctrine()->getRepository(Post::class)->find($postId);
        $comment->setPost($post);
        if($subcommentId) {
            $comment->setSubcommentId($subcommentId);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        dump($comment);
//        return new Response('saved new comment with id: '.$comment->getId());
        return new Response($comment->getId());
    }
}
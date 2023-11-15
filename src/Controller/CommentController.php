<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/create/{id}', name: 'comment_create')]
    public function createComment(Post $post, EntityManagerInterface $manager, Request $request)
    {
        if (!$post){
            return $this->redirectToRoute('app_home');
        }
        $comment =  new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $comment->setPost($post);
            $comment->setAuthor($this->getUser()->getProfile());
            $comment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();

            return$this->redirectToRoute("post_show", [
                "id"=>$comment->getPost()->getId()
            ]);
        }
        return$this->redirectToRoute("post_show", [
            "id"=>$comment->getPost()->getId(),
            "editComm"=>$form
        ]);
    }
    //---------------------------------------------------------------

    #[Route('/comment/delete/{id}', name: 'app_comment_delete')]
    public function deleteComment(Comment $comment ,EntityManagerInterface $entityManager): Response
    {

        if($comment){
            if($comment->getAuthor()== $this->getUser()->getProfile()){
                $entityManager->remove($comment);
                $entityManager->flush();

                return $this->redirectToRoute('post_show',[
                    "id"=>$comment->getPost()->getId()
                ]);            }
        }
        return $this->redirectToRoute('post_show',[
            "id"=>$comment->getPost()->getId()
        ]);
    }
 #[Route('/comment/update/{id}', name: 'app_comment_update')]
    public function updateComment(Comment $comment ,EntityManagerInterface $entityManager, Request $request, CommentRepository $commentRepository): Response
    {
        if($comment){
            if($comment->getAuthor()== $this->getUser()->getProfile()){

                $form = $this->createForm(CommentType::class, $comment);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $comment->setIsEdited(true);
                    $commentRepository->save($comment, true);
                }
                return $this->redirectToRoute('app_home');
            }
        }
        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
        ]);
    }
}

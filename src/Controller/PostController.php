<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Profile;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// TOUT EST A TESTER

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('s', name: 'app_posts')]
    public function indexAllPosts(PostRepository $repository): Response
    {
        $posts = $repository->findAll();
        
        return $this->render('post/index.html.twig', [
            'posts'=>$posts
        ]);
    }

    # ROUTE A METTRE APRES DANS PROFILECONTROLLER ET MERGE AVEC INDEX-MY-REPOSTS
    #[Route('s/{id}', name: 'app_my_posts')]
    public function indexAllMyPostsAndRepublications(Profile $profile): Response
    {
        $posts = $profile->getPosts();

        // ajouter republications

        return $this->render('post/indexMyPosts.html.twig', [
            'posts'=>$posts
        ]);
    }

    #[Route('/new', name: 'new_post', priority: 2)]
    #[Route('/edit/{id}', name: 'edit_post', priority: 2)]
    public function createOrEditPost(Request $request, EntityManagerInterface $manager, Post $post =null): Response
    {
        $edit = false;
        $title = "Create a new post";
        $button = "Add post";

        if ($post) {
            $edit = true;
            $title = "Edit your post";
            $button = "Validate changes";
        }

        if (!$post) {
            $post = new Post();
        }

        $postForm = $this->createForm(PostType::class, $post);
        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setAuthor($this->getUser()->getProfile());
            $post->setIsEdited(false);

            if ($edit) {$post->setIsEdited(true);}

                $manager->persist($post);
                $manager->flush();

            return $this->redirectToRoute('app_posts');
        }

        return $this->render('post/edit.html.twig', [
            'postForm' => $postForm,
            'title' => $title,
            "edit" => $edit,
            'button' => $button
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_post')]
    public function deletePost(Post $post, EntityManagerInterface $manager){

        if($post->getAuthor() == $this->getUser()->getProfile()){
            $manager->remove($post);
            $manager->flush();
        }

        # ajout modal pour valider suppression

        return $this->redirectToRoute('app_posts');

    }

    #[Route('/show/{id}', name: 'post_show')]
    public function show(Post $post, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        return $this->render('post/show.html.twig', [
            'form'=>$form,
            'post'=>$post
        ]);
    }

}

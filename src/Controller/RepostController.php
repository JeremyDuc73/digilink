<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Repost;
use App\Repository\RepostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/repost')]
class RepostController extends AbstractController
{
    # ROUTE A METTRE APRES DANS PROFILECONTROLLER ET MERGE AVEC INDEX-POSTS
    #[Route('s', name: 'app_reposts')]
    public function allReposts(RepostRepository $repository): Response
    {
        $reposts = $repository->findAll();
        return $this->render('repost/index.html.twig', [
            'reposts'=>$reposts
        ]);
    }

    #[Route('/{id}', name: 'repost')]
    public function repost(Post $post): Response
    {
        $alreadyReposted = $this->getUser()->getProfile()->getReposts();
        foreach($alreadyReposted as $reposted){
            if($reposted->getOriginalPost() == $post){
                // mettre flash message pour dire que non
                return $this->redirectToRoute('app_posts'); # redirection vers la page d'accueil ?
            }

            $repost = new Repost();
            $repost->setOriginalPost($post);
            $repost->setCreatedAt(new \DateTimeImmutable());
            $repost->setRepostedBy($this->getUser()->getProfile());

            return $this->redirectToRoute('app_posts'); # redirection vers la page d'accueil ?
        }
        return $this->redirectToRoute('app_posts'); # redirection vers la page d'accueil ?


    }
}

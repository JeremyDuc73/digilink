<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Repost;
use App\Repository\RepostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/repost')]
class RepostController extends AbstractController
{
    # ROUTE A METTRE APRES DANS PROFILECONTROLLER ET MERGE AVEC INDEX-POSTS
    #[Route('s/{id}', name: 'app_my_reposts')]
    public function myReposts(Profile $profile): Response
    {
        $reposts = $profile->getReposts();
        return $this->render('repost/index.html.twig', [
            'reposts'=>$reposts
        ]);
    }

    #[Route('/{id}', name: 'repost')]
    public function repost(Post $post, EntityManagerInterface $manager): Response
    {
        $alreadyReposted = $this->getUser()->getProfile()->getReposts();
        if ($alreadyReposted){
            foreach($alreadyReposted as $reposted){
                        if($reposted->getOriginalPost() == $post){
                            // mettre flash message pour dire que non

                            $this->addFlash(
                                'notice',
                                'You have already reposted this post. once is enough'
                            );

                            return $this->redirectToRoute('app_posts');
                        }
        }



            $repost = new Repost();
            $repost->setOriginalPost($post);
            $repost->setCreatedAt(new \DateTimeImmutable());
            $repost->setRepostedBy($this->getUser()->getProfile());

            $manager->persist($repost);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Reposted in your feed'
            );

            return $this->redirectToRoute('app_posts'); # redirection vers la page d'accueil ?
        }

        return $this->redirectToRoute('app_posts'); # redirection vers la page d'accueil ?


    }
}

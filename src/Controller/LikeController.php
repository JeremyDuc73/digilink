<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    public function index(Post $post, PostLikeRepository $likeRepository, EntityManagerInterface $manager): Response
    {
        $profile = $this->getUser()->getProfile();

        if ($post->isLikedBy($profile)){
            $Postlike = $likeRepository->findOneBy([
                'isLikedBy'=>$profile,
                'post'=>$post
            ]);

            $manager->remove($Postlike);
            $isLiked = false;
        }else{

            $Postlike = new PostLike();
            $Postlike->setPost($post);
            $Postlike->setIsLikedBy($profile);
            $manager->persist($Postlike);
            $isLiked = true;
        }
        $manager->flush();

        $data = [
            'liked' => $isLiked,
            'count' => $likeRepository->count(['post'=>$post])
        ];

        return $this->json($data, 200);
    }

}

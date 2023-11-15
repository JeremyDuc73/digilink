<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Report;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReportController extends AbstractController
{
    #[Route('/report/post/{id}', name: 'app_report_post')]
    public function reportPost(Post $post, EntityManagerInterface $manager): Response
    {
        if ($this->getUser() != null){
            $report = new Report();
                    $report->setAuthor($this->getUser()->getProfile());
                    $report->setPost($post);
                    $manager->persist($report);
                    $manager->flush();
        }


        return $this->redirectToRoute("app_posts");
    }

    #[Route("/report/comment/{id}",name: 'app_report_comment')]
    public function reportComment(Comment $comment, EntityManagerInterface $manager):Response{

        if ($this->getUser() != null){
            $report = new Report();
            $report->setAuthor($this->getUser()->getProfile());
            $report->setComment($comment);
            $manager->persist($report);
            $manager->flush();
        }

        return $this->redirectToRoute("app_posts");
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Profiler\Profile;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    

    #[Route('/blockuser/{id}', name: 'app_profile_blockuser')]
    public function blockUser(Profile $profile){
        $curUser = $this->getUser()->getProfile();
        if ($profile != $curUser){
            $curUser->addBlackList($profile);
            return $this->redirectToRoute("app_home");
        }
        return $this->redirectToRoute("app_home");
    }


}

<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(Profile $profile): Response
    {
        return $this->render('profile/index.html.twig', [
            "profile"=>$profile,
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

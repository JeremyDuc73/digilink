<?php

namespace App\Controller;

use App\Entity\Link;
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
        $blackList = $profile->getBlackList();
        return $this->render('profile/index.html.twig', [
            "profile"=>$profile,
            "blackList"=>$blackList
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'app_profile_edit')]
    public function edit(Profile $profile, EntityManagerInterface $manager, Request $request): Response
    {
        if (!$this->getUser() === $profile->getOfUser()) {return $this->redirectToRoute('app_home');}

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profile->setDescription($profile->getDescription());
            $profile->setGrade($profile->getGrade());
            $profile->setPhoneNumber($profile->getPhoneNumber());

            $links = $form->getData()->getLink();

            foreach ($links as $link) {
                $newLink = new Link();
                $newLink ->setLinkName($link->getLinkName());
                $newLink ->setUrl($link->getUrl());
                $newLink ->setProfile($profile);
            }


            $manager->flush();
            return $this->redirectToRoute('app_profile', ['id'=>$profile->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/blockuser/{id}', name: 'app_profile_blockuser')]
    public function blockUser(Profile $profile, EntityManagerInterface $manager){
        $curUser = $this->getUser()->getProfile();
        if ($profile != $curUser){
            $curUser->addBlackList($profile);
            $manager->persist($profile);
            $manager->flush();
            return $this->redirectToRoute("app_profile", [
                'id'=>$curUser->getId()
            ]);
        }
        return $this->redirectToRoute("app_profile", [
            'id'=>$curUser->getId()
        ]);
    }


    #[Route('/unblockuser/{id}', name: 'app_profile_unblockuser')]
    public function unblockUser(Profile $profile, EntityManagerInterface $manager){
        $curUser = $this->getUser()->getProfile();

        if  ($curUser->hasBlocked($profile)){
            $curUser->removeBlackList($profile);
            $manager->persist($curUser);
            $manager->flush();
        }

        return $this->redirectToRoute("app_profile", [
            'id'=>$curUser->getId()
        ]);    }



}

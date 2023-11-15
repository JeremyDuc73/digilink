<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/image')]
class ImageController extends AbstractController
{

    #[Route('/profile/add', name: 'app_image_add_profile')]
    public function addImage(Request $request, EntityManagerInterface $manager): Response
    {

        $routeName = $request->attributes->get("_route");

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            if ($routeName == "app_image_add_profile") {

                $oldImage = $this->getUser()->getProfile()->getImage();
                if ($oldImage) {
                    $manager->remove($oldImage);

                }

                $image->setProfile($this->getUser()->getProfile());
            }

            $manager->persist($image);
            $manager->flush();


        }

        if ($routeName == "app_image_profile_add") {
            return $this->redirectToRoute('app_profile',["id"=>$this->getUser()->getProfile()]);
        }

        return $this->render("image/index.html.twig", [
            "imageForm" => $form->createView()
        ]);


    }
}
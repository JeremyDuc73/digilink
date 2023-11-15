<?php

namespace App\Controller;

use App\Entity\KeyActivation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeyActivationController extends AbstractController
{

    #[Route('/key/activation', name: 'app_key_activation')]
    public function index(EntityManagerInterface $entityManager ): Response
    {
        function getRandomStr($n) {
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomStr = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($str) - 1);
                $randomStr .= $str[$index];
            }

            return $randomStr;
        }
        $n=25;
        $key=getRandomStr($n);
        $keyActivation= new KeyActivation();
        $keyActivation->setKey($key);
        $entityManager->persist($keyActivation);
        $entityManager->flush();
        return $this->redirectToRoute("app_register",['key'=>$key]);
    }
}

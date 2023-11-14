<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/link')]
class LinkController extends AbstractController
{
    #[Route('/', name: 'app_link_index')]
    public function index(LinkRepository $linkRepository): Response
    {
        return $this->render('link/index.html.twig', [
            "links"=>$linkRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_link_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($link);
            $manager->flush();

            return $this->redirectToRoute('app_link_index');
        }

        return $this->render('link/create.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_link_edit')]
    public function edit(Request $request, Link $link, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('app_link_index');
        }

        return $this->redirectToRoute('app_link_index');
    }

    #[Route('/delete/{id}', name: 'app_link_delete')]
    public function delete(Link $link, EntityManagerInterface $manager): Response
    {

        if (!$link) {return $this->redirectToRoute('app_link_index');}

        $manager->remove($link);
        $manager->flush();

        return $this->redirectToRoute('app_link_name_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\LinkName;
use App\Form\LinkNameType;
use App\Repository\LinkNameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('//admin/link/name')]
class LinkNameController extends AbstractController
{
    #[Route('/', name: 'app_link_name_index')]
    public function index(LinkNameRepository $linkNameRepository): Response
    {
        return $this->render('link_name/index.html.twig', [
            "linksName"=>$linkNameRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_linkname_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $linkName = new LinkName();
        $form = $this->createForm(LinkNameType::class, $linkName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($linkName);
            $manager->flush();

            return $this->redirectToRoute('app_link_name_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('link_name/create.html.twig', [
            'linkName' => $linkName,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_linkname_edit')]
    public function edit(Request $request, LinkName $linkName, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(LinkNameType::class, $linkName);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('app_link_name_index');
        }

        return $this->render('link_name/edit.html.twig', [
            'linkName' => $linkName,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_linkname_delete')]
    public function delete(LinkName $linkName, EntityManagerInterface $manager): Response
    {

        if (!$linkName) {return $this->redirectToRoute('app_link_name_index');}

        $manager->remove($linkName);
        $manager->flush();

        return $this->redirectToRoute('app_link_name_index', [], Response::HTTP_SEE_OTHER);
    }
}

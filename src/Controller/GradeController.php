<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/grade')]
class GradeController extends AbstractController
{
    #[Route('/', name: 'app_grade_index')]
    public function index(GradeRepository $gradeRepository): Response
    {
        return $this->render('grade/index.html.twig', [
            "grades"=>$gradeRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($grade);
            $manager->flush();

            return $this->redirectToRoute('app_grade_index');
        }

        return $this->render('grade/create.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_grade_edit')]
    public function edit(Request $request, Grade $grade, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('app_grade_index');
        }

        return $this->render('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_grade_delete')]
    public function delete(Grade $grade, EntityManagerInterface $manager): Response
    {

        if (!$grade) {return $this->redirectToRoute('app_grade_index');}

        $manager->remove($grade);
        $manager->flush();

        return $this->redirectToRoute('app_grade_index');
    }
}

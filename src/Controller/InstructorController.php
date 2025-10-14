<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Form\InstructorType;
use App\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/instructor')]
final class InstructorController extends AbstractController
{
    #[Route(name: 'app_instructor_index', methods: ['GET'])]
    public function index(InstructorRepository $instructorRepository): Response
    {
        return $this->render('instructor/index.html.twig', [
            'instructors' => $instructorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_instructor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $instructor = new Instructor();
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($instructor);
            $entityManager->flush();

            return $this->redirectToRoute('app_instructor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructor/new.html.twig', [
            'instructor' => $instructor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instructor_show', methods: ['GET'])]
    public function show(Instructor $instructor): Response
    {
        return $this->render('instructor/show.html.twig', [
            'instructor' => $instructor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_instructor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instructor $instructor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_instructor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructor/edit.html.twig', [
            'instructor' => $instructor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instructor_delete', methods: ['POST'])]
    public function delete(Request $request, Instructor $instructor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instructor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($instructor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_instructor_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Event\LetterSentEvent;
use App\Form\LetterFormType;
use App\Repository\LetterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LetterController extends AbstractController
{
    #[Route('/', name: 'app_letter')]
    public function index(LetterRepository $letterRepository): Response
    {
        $letters = $letterRepository->findAll();

        return $this->render('letter/index.html.twig', [
            'letters' => $letters,
        ]);
    }

    #[Route('/send', name: 'app_send_letter')]
    public function send(
        Request $request,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ): Response
    {
        $letter = new Letter();
        $form = $this->createForm(LetterFormType::class, $letter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($letter);
            $entityManager->flush();

            $eventDispatcher->dispatch(new LetterSentEvent($letter), LetterSentEvent::NAME);

            return $this->redirectToRoute('app_letter');
        }

        return $this->render('letter/form.html.twig', [
            'letterForm' => $form->createView(),
        ]);
    }
}

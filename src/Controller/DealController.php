<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Form\DealType;
use App\Repository\CategoryRepository;
use App\Repository\DealRepository;
use App\Service\RandomSlogan;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    #[Route('/deal/list', name: 'deal_list', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, RandomSlogan $randomSlogan): Response
    {
        return $this->render('deal/index.html.twig', [
            'controller_name' => 'DealController',
            'categories' => $categoryRepository->findAll(),
            'slogan' => $randomSlogan->getSlogan(),
        ]);
    }

    #[Route('/deal/show/{id}', name: 'deal_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Deal $deal): Response
    {
        return $this->render('deal/show.html.twig', [
            'controller_name' => 'DealController',
        ]);
    }

    #[Route('/deal/toggle/{id}', name: 'deal_toggle', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function toggleEnableAction(Deal $deal, DealRepository $dealRepository): Response
    {
        $deal->setEnabled(!$deal->isEnabled());
        $dealRepository->add($deal, true);
        return $this->redirectToRoute('deal_list');
    }

    #[Route('/deal/add', name: 'deal_add', methods: ['GET', 'POST'])]
    public function add(Request $request, DealRepository $dealRepository, LoggerInterface $logger): Response
    {
        $deal = new Deal();
        $form = $this->createForm(DealType::class, $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deal->setEnabled(false);
            $dealRepository->add($deal, true);
            $this->addFlash('success', 'Deal added');
            $logger->info("Deal {$deal->getId()} added");
            return $this->redirectToRoute('deal_list');
        }

        return $this->render('deal/add.html.twig', [
            'controller_name' => 'DealController',
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Deal;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    #[Route('/deal/list', name: 'deal_list', methods: ['GET'])]
    public function index(ManagerRegistry $registry): Response
    {
        $categories = $registry->getRepository(Category::class)->findAll();

        return $this->render('deal/index.html.twig', [
            'controller_name' => 'DealController',
            'categories' => $categories,
        ]);
    }

    #[Route('/deal/show/{id}', name: 'deal_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('deal/show.html.twig', [
            'controller_name' => 'DealController',
        ]);
    }

    #[Route('/deal/toggle/{id}', name: 'deal_toggle', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function toggleEnableAction(int $id, ManagerRegistry $registry): Response
    {
        $deal = $registry->getRepository(Deal::class)->find($id);
        if (!$deal) {
            throw $this->createNotFoundException('Deal not found');
        }
        $deal->setEnabled(!$deal->isEnabled());
        $registry->getManager()->flush();
        return $this->redirectToRoute('deal_list');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    #[Route('/deal/list', name: 'deal_list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('deal/index.html.twig', [
            'controller_name' => 'DealController',
        ]);
    }

    #[Route('/deal/show/{id}', name: 'deal_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('deal/show.html.twig', [
            'controller_name' => 'DealController',
        ]);
    }
}

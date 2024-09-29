<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitLaitierController extends AbstractController
{
    #[Route('/produit/laitier', name: 'app_produit_laitier')]
    public function index(): Response
    {
        
        return $this->render('produit_laitier/index.html.twig', [
            'controller_name' => 'ProduitLaitierController',
        ]);
    }
}

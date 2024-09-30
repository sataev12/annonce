<?php

namespace App\Controller;

use App\Entity\ProduitLaitier;
use App\Form\ProduitLaitieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitLaitierController extends AbstractController
{
    #[Route('/produit/laitier', name: 'app_produit_laitier')]
    public function index(): Response
    {


        return $this->render('produit_laitier/index.html.twig', [
            'controller_name' => 'ProduitLaitierController',
        ]);
    }

    #[Route('/addProduit', name: 'add_fromage')]
    public function addFromage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fromageAdd = new ProduitLaitier();

        $form = $this->createForm(ProduitLaitieType::class, $fromageAdd);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $fromageAdd = $form->getData();
            // Persister les données dans la base de données
            $entityManager->persist($fromageAdd);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_laitier');
        }

        return $this->render('produit_laitier/ajoutFromage.html.twig', [
            'form' => $form,
        ]);
    }

}

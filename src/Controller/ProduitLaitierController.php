<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\ProduitLaitier;
use App\Form\ProduitLaitieType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProduitLaitierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitLaitierController extends AbstractController
{
    #[Route('/produit/laitier', name: 'app_produit_laitier')]
    public function index(ProduitLaitierRepository $produitLaitierRepository): Response
    {
        $fromages = $produitLaitierRepository->findBy([], ['id' => 'DESC']);
        
        
        return $this->render('produit_laitier/index.html.twig', [
            'fromages' => $fromages,
        ]);
    }

    #[Route('/addProduit', name: 'add_fromage')]
    public function addFromage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fromage = new ProduitLaitier();
        $form = $this->createForm(ProduitLaitieType::class, $fromage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fromage);
            $produit = $form->getData();
            $imageFile = $form->get('image')->getData();
            // Récupère les fichiers d'image téléchargés à partir du formulaire.
            // Vérifie si un fichier a été téléchargé
            if ($imageFile) {
                
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Sécuriser le nom du fichier pour éviter les problèmes
                $safeFilename = uniqid() . '.' . $imageFile->guessExtension();
                
               
                // Déplacer le fichier dans le répertoire défini
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $safeFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si le fichier ne peut pas être déplacé
                }
                $images = new Images();
                // Crée une nouvelle instance de l'entité Photo.
                $images->setUrl('/img/' . $safeFilename);
                // Définit l'URL de la photo basée sur le chemin relatif et le nouveau nom de fichier.

                $images->setProduitLaitier($produit);
                // Associe la photo à la fromage actuelle.

                $entityManager->persist($images);
                // Prépare l'entité Photo pour être sauvegardée dans la base de données.

            }
            

            // Sauvegarder l'entité en base de données
            
            
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_laitier');
        }

        return $this->render('produit_laitier/ajoutFromage.html.twig', [
            'form' => $form,
        ]);
    }

    // pour supprimer produit
    #[Route('/produit/laitier/{id}/delete', name: 'remove_fromage')]
    public function removeFromage( EntityManagerInterface $entityManager, ProduitLaitier $fromage): Response
    {
        // Remove related photos
        foreach ($fromage->getImages() as $photo) {
            $entityManager->remove($photo);
        }

        $entityManager->remove($fromage);
        $entityManager->flush();

        return $this->redirectToRoute('app_produit_laitier');
    }

}

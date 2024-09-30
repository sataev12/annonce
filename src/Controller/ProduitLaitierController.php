<?php

namespace App\Controller;

use App\Entity\ProduitLaitier;
use App\Form\ProduitLaitieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            // $entityManager->persist($fromageAdd);
            // $entityManager->flush();
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            // Vérifie si un fichier a été téléchargé
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Sécuriser le nom du fichier pour éviter les problèmes
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Déplacer le fichier dans le répertoire défini
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si le fichier ne peut pas être déplacé
                }

                // Stocker le nom de fichier dans l'entité
                $fromageAdd->setImage($newFilename);
            }

            // Sauvegarder l'entité en base de données
            
            $entityManager->persist($fromageAdd);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_laitier');
        }

        return $this->render('produit_laitier/ajoutFromage.html.twig', [
            'form' => $form,
        ]);
    }

}

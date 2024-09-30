<?php

namespace App\Form;

use App\Entity\ProduitLaitier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitLaitieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fromagesType')
            ->add('OrigineLait')
            ->add('name')
            ->add('image', FileType::class, [
                'label' => 'Image (fichier JPG ou PNG)',
                'mapped' => false, // Le champ n'est pas mappé à une propriété de l'entité
                'required' => false, // Rendre l'upload facultatif (si nécessaire)
                'constraints' => [
                    new File([
                        'maxSize' => '2M', // Limite de la taille du fichier
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG ou PNG)',
                    ])
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProduitLaitier::class,
        ]);
    }
}

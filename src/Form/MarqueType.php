<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Bridge\Doctrine\Form\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('ville')
            ->add('file', FileType::class, ['required' => false])

            ->add('region', EntityType::class, [
                'class' => 'App\Entity\Region',
                'placeholder' => 'Sélectionner votre région',
                'mapped' => false,
                'required' => false,
            ])

            ->add('tag1')
            ->add('tag2')
            ->add('tag3')
            ->add('tag4')
            ->add('tag5')
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
        ]);
    }
}

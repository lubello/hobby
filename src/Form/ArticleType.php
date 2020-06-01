<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('marque')
            ->add('ref1')
            ->add('ref2')
            ->add('description')
            ->add('quantite')
            ->add('tag1')
            ->add('tag2')
            ->add('tag3')
            ->add('tag4')
            ->add('tag5')
            ->add('file', FileType::class, ['required' => false])

            ->add('save', SubmitType::class, ['label' => 'Créer Article'])
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Créer Article et ajouter un nouveau'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

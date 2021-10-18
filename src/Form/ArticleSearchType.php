<?php


namespace App\Form;


use App\Entity\Dto\ArticleSearchDto;
use App\Entity\Marque;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('liste', CollectionType::class, [
                'entry_type'    => TagDtoType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => false,
                'label'         => false,
                'required'      => false,
            ])
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher',
                ]
            ])
            ->add('marques', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Marque::class,
                'expanded' => true,
                'multiple' => true,
                //'choice_label' => 'nom',
                'choice_label' => function (Marque $marque) {
                    return $marque->getNom();
                },

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->innerJoin('m.articles', 'a')
                        ->orderBy('m.nom', 'ASC');
                },

            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Qté min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Qté max'
                ]
            ])
           
            ->add('tag', TextType::class, [
                'label' => 'Tag(s)',
                'required' => false
            ])

            ->add('ref', TextType::class, [
                'label' => 'Référence (ref1 | ref2)',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearchDto::class,
            'method' =>'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
        //return parent::getBlockPrefix(); // TODO: Change the autogenerated stub
    }
}
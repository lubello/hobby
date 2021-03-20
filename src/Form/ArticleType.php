<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class ArticleType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    //private $entityManager;

    /**
     * @var ArticleRepository
     */
    private $ar;

    /**
     * ArticleType constructor.
     * @param EntityManagerInterface $entityManager
     * @param ArticleRepository $ar
     */
    public function __construct(EntityManagerInterface $entityManager,
                                ArticleRepository $ar)
    {
        //$this->entityManager = $entityManager;
        $this->ar = $ar;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label'=>'Nom'])
            ->add('marque')
            ->add('ref1')
            ->add('ref2')
            ->add('description')
            ->add('quantite')
            ->add('prix')

            ->add('tag1', ChoiceType::class, [
                'choices' => $this->ar->findForTag1(),
                'required' => false,
            ])

            ->add('tag2', ChoiceType::class, [
                'choices' => $this->ar->findForTag2(),
                'required' => false,
            ])

            ->add('tag3', ChoiceType::class, [
                'choices' => $this->ar->findForTag3(),
                'required' => false,
            ])

            ->add('tag4', ChoiceType::class, [
                'choices' => $this->ar->findForTag4(),
                'required' => false,
            ])

            ->add('tag5', ChoiceType::class, [
                'choices' => $this->ar->findForTag5(),
                'required' => false,
            ])

            ->add('file', FileType::class, ['required' => false])

            ->add('save', SubmitType::class, ['label' => 'Créer Article'])
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Créer Article et ajouter un nouveau'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'  => Article::class,
            //'articleRepo' => null,
        ]);

        //$resolver->setAllowedTypes('articleRepo',ArticleRepository::class);
    }
}

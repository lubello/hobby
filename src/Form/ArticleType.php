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
        ///** @var ArticleRepository $articleRepo */
        //$articleRepo = $options['articleRepo'];
        //var_dump($this->ar->findForTag1());



        $builder
            //->add('nom', TextType::class, ['' ])
            ->add('marque')
            ->add('ref1')
            ->add('ref2')
            ->add('description')
            ->add('quantite')

            ->add('tag1', ChoiceType::class, [
                'choices' => $this->ar->findForTag1(),
                //'choice_label' => function(Article $article) { return $article->getTag1(); },
                //'multiple' => true
            ])

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
            'data_class'  => Article::class,
            //'articleRepo' => null,
        ]);

        //$resolver->setAllowedTypes('articleRepo',ArticleRepository::class);
    }
}

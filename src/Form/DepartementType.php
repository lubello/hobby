<?php

namespace App\Form;

use App\Entity\Departement;
use App\Repository\RegionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DepartementType extends AbstractType
{
    /**
     * @var RegionRepository
     */
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {

        $this->regionRepository = $regionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null, [
                'attr' => ['class' =>'form-control'],
                'help' => 'Entrer le nom du département',
                'invalid_message' => 'nom obligatoire',
            ])

            ->add('region',null, [
                'attr' => ['class' =>'form-control'],
                'help' => 'Entrer la région du département',
                'choice_label' => 'nom',
                'choices' => $this->regionRepository->findAll(),
            ])

            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choose a password!'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Come on, you can think of a password longer than that!'
                    ]),

                ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'attr' => ['class' =>'form-control'],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'I know, it\'s silly, but you must agree to our terms.'
                    ])
                ]
            ])





        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
        ]);
    }
}

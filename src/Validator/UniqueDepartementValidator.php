<?php


namespace App\Validator;


use App\Repository\DepartementRepository;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

class UniqueDepartementValidator extends ConstraintValidator
{
    /**
     * @var DepartementRepository
     */
    private $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, \Symfony\Component\Validator\Constraint  $constraint)
    {
        $existingUser = $this->departementRepository->findOneBy([ 'nom' => $value ]);
        if (!$existingUser) {
            return;
        }


        /** @var UniqueDepartement $constraint */
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}

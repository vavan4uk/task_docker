<?php

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

class ValidateEmailValidator extends ConstraintValidator
{
   /**
    * @var EntityManager
    */
   protected $em;
   private $container;
   
   
   public function __construct(ContainerInterface $container, EntityManager $entityManager)
   {
        $this->container = $container;
        $this->em = $entityManager;
   }

  public function validate($value, Constraint $constraint)
  {
        if ( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
                $errorMsg = $this->container->get('translator')->trans('form.alertmessage.email.notvalid2',['%value%' => $value],'messages');
                $this->context->buildViolation($errorMsg)
                    ->addViolation();
        }
      
  }
} 
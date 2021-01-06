<?php

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

use App\Entity\User;

class UniqueEmailValidator extends ConstraintValidator
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
          
            
      $repository = $this->em->getRepository(User::class);
      $user = $repository->findOneBy(array(
          'email' => $value
      ));
      

      if ($user instanceof User) {
          
            if (null === $token = $this->container->get('security.token_storage')->getToken()) {
                
            }
            else{
                if( $this->container->get('security.token_storage')->getToken()->getUser() instanceof User ){
                    if( $this->container->get('security.token_storage')->getToken()->getUser()->getId()==$user->getId() )
                        return;
                }
            }
          
            $errorMsg = $this->container->get('translator')->trans('user.form.alert.emailexist',[],'messages');
            $this->context->buildViolation($errorMsg)
                ->addViolation();
      }
  }
} 
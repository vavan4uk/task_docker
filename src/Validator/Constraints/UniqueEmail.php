<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* Class UniqueEmail
* @package MyApp\AppBundle\Validator\Constraints
* @Annotation
*/
class UniqueEmail extends Constraint
{
  public $message = 'The Email already exists.';

  public function validatedBy()
  {
      return 'unique.email.validator';
  }
}
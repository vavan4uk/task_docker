<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* Class UniqueEmail
* @package MyApp\AppBundle\Validator\Constraints
* @Annotation
*/
class ValidateEmail extends Constraint
{
  public $message = 'Email not valid';

  public function validatedBy()
  {
      return 'validate.email.validator';
  }
}
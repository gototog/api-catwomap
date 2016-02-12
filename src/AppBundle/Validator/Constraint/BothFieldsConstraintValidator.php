<?php
namespace AppBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * User: goto
 * Date: 11/02/16
 * Time: 14:31
 */
class BothFieldsConstraintValidator extends ConstraintValidator
{
    public function validate( $alert, Constraint $constraint)
    {
        /** @var $alert \AppBundle\Entity\Alert */
        if (  ($alert->getPositionLong() != "" && $alert->getPositionLat() != "")
        || ($alert->getPositionLong() == "" && $alert->getPositionLat() == "")
        ) {

        } else {
            $this->context->buildViolation($constraint->message)
                ->atPath("positionLat")
                ->addViolation();
        }
    }
}
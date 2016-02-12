<?php
namespace AppBundle\Validator\Constraint;
/**
 * User: goto
 * Date: 11/02/16
 * Time: 14:27
 *
 * @Annotation
 */
class BothFieldsConstraint extends \Symfony\Component\Validator\Constraint
{
    public $message = 'The fields "%field1%" and "%field2%" are both required';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Goto
 * Date: 16/01/2015
 * Time: 12:07
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserHelpAlertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isDeprecated');
        $builder->add('hasCalledPolice');
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\UserHelpAlert',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'user_help_alert_type';
    }

}
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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('gmapCreatedPosition', 'text');
        $builder->add('type', 'text');
        $builder->add('user', 'entity');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\Alert',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'alert_type';
    }

}
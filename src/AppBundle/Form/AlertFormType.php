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

class AlertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userCreator');
        $builder->add('positionLong');
        $builder->add('positionLat');
        $builder->add('category');
        $builder->add('description');
    }

    public function setDefaultOptions(OptionsResolver $resolver)
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
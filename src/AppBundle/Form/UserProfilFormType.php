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

class UserProfilFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname');
        $builder->add('lastname');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\User',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'user';
    }

}
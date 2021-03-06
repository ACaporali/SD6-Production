<?php

namespace SD6Production\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationType extends BaseType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);

    $builder
           ->add('roles', 'collection', array(
                   'type' => 'choice',
                   'options' => array(
                       'choices' => array(
                           'ROLE_ADMIN' => 'Admin',
                           'ROLE_SUPER_ADMIN' => 'Super admin'
                       )
                   )
               )
           )
       ;
  }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SD6Production\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
      return 'sd6production_userbundle_user';
    }

    public function getParent()
    {
      return 'fos_user_registration';
    }

    public function getName()
    {
      return 'user_registration';
    }


}

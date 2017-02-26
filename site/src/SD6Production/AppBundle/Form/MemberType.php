<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('name', 'text' , array('required' => false))
    ->add('firstName', 'text')
    ->add('post', 'text')
    ->add('description', 'textarea', array('required' => false))
    ->add('image', new ImageType(), array('required' => false))
    ->add('valider','submit');
  }

  /**
  * {@inheritdoc}
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'SD6Production\AppBundle\Entity\Member'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'sd6production_appbundle_member';
  }


}

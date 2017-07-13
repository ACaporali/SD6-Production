<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use SD6Production\AppBundle\Form\Type\ImageType;

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
    ->add('image', ImageType::class, array(
      'label'    => false,
      'choice_label' => 'url'
    ))
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

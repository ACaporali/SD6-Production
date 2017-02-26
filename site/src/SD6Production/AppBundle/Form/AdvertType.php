<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('title', 'text')
    ->add('taglines', 'text', array('required' => false))
    ->add('content', 'ckeditor', array(
  'config' => array('toolbar' => 'full')))
    ->add('author', 'text')
    ->add('date', 'date')
    ->add('published', 'checkbox', array('required' => false))// Element non obligatoire dans le form
    ->add('category', 'entity', array( //Affiche la liste des catégories
       'class'    => 'SD6ProductionAppBundle:Category',
       'property' => 'name',
       'multiple' => false))
    ->add('image', new ImageType(), array('required' => false)) // Imbriqué le form image dans celui-ci
    ->add('pinned', 'checkbox', array('required' => false))
    ->add('valider','submit');
  }

  /**
  * {@inheritdoc}
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'SD6Production\AppBundle\Entity\Advert'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'sd6production_appbundle_advert';
  }


}

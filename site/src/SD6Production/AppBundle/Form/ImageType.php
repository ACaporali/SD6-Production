<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ImageType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('date', 'date')
    ->add('url','text', array('required' => false))
    ->add('alt','text', array('required' => false))
    ->add('file', 'file',array('required' => false))
    ->add('category', EntityType::class, array( //Affiche la catégorie 'Galerie'
      'class'    => 'SD6ProductionAppBundle:Category',
      'query_builder' => function (EntityRepository $er) {
        return $er->getCategory('Galerie');
      },
      'property' => 'name',
      'multiple' => false,
      'required' => false))
    ->add('valider','submit')        ;
  }

  /**
  * {@inheritdoc}
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'SD6Production\AppBundle\Entity\Image'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'sd6production_appbundle_image';
  }
}

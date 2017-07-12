<?php

namespace SD6Production\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

class ImageType extends AbstractType
{
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefault( 'class', 'SD6Production\AppBundle\Entity\Image' );
    $resolver->setDefault( 'expanded', true );
  }

  public function buildView( FormView $view, FormInterface $form, array $options ) {
    //Creation de la valeur 'images' dans les data du form (child.parent.vars.images)
    $img = [];
    foreach ( $view->vars[ 'choices' ] as $choice )
      array_push( $img, $choice->data );
    $view->vars[ 'images' ] = $img;
  }

  public function getParent()
  {
    //return EntityType::class;
    return EntityType::class;
  }
}

?>

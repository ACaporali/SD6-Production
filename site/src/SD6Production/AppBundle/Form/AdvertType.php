<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
      ->add('image', new ImageType(), array('required' => false)) // Imbriqué le form image dans celui-ci
      ->add('pinned', 'checkbox', array('required' => false)
    );

    $builder->addEventListener(FormEvents::PRE_SET_DATA, function ( FormEvent $event ){
      $advert = $event->getData();
      $form = $event->getForm();

      //Ajout du champs pour les castings
      if ($advert->isCasting()) {
        $form
        ->add('closure', 'date', array(
          'label' => 'Date de cloture'
        ))
        ->add('category', EntityType::class, array( //Affiche la liste des catégories mais pas Casting
          'class'    => 'SD6ProductionAppBundle:Category',
          'query_builder' => function (EntityRepository $er) {
            return $er->getCategory('Casting');
          },
          'property' => 'name',
          'multiple' => false)
        );
      }else{
        $form
        ->add('category', EntityType::class, array( //Affiche la liste des catégories mais pas Casting
          'class'    => 'SD6ProductionAppBundle:Category',
          'query_builder' => function (EntityRepository $er) {
            return $er->getCategoryWithout('Casting');
          },
          'property' => 'name',
          'multiple' => false));
        }
      }
    );

    $builder
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

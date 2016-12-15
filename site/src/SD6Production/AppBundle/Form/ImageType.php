<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('url','text', array('required' => false))
        ->add('alt','text', array('required' => false))
        ->add('file', 'file',array('required' => false))
        ->add('categories','entity', array( //Affiche la liste des catégories
                'class'    => 'SD6ProductionAppBundle:Categorie',
                'property' => 'nom',
                'multiple' => true))
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

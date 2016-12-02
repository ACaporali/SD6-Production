<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre', 'text')
        ->add('accroche', 'text')
        ->add('contenu', 'textarea')
        ->add('auteur', 'text')
        ->add('date', 'date')
        ->add('publie', 'checkbox', array('required' => false))// Element non obligatoire dans le form
        ->add('categories', 'entity', array( //Affiche la liste des catégories
                'class'    => 'SD6ProductionAppBundle:Categorie',
                'property' => 'nom',
                'multiple' => true))
        ->add('image', new ImageType(), array('required' => false)) // Imbriqué le form image dans celui-ci
        ->add('valider','submit');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SD6Production\AppBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sd6production_appbundle_annonce';
    }


}

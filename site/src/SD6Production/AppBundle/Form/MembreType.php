<?php

namespace SD6Production\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', 'text' , array('required' => false))
        ->add('prenom', 'text')
        ->add('poste', 'text')
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
            'data_class' => 'SD6Production\AppBundle\Entity\Membre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sd6production_appbundle_membre';
    }


}

<?php

namespace SD6Production\PopupInfosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PopupPinnedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text')
        ->add('content', 'ckeditor', array(
      'config' => array('toolbar' => 'full')))
        ->add('published', 'checkbox', array('required' => false))
        ->add('valider','submit');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SD6Production\PopupInfosBundle\Entity\PopupPinned'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sd6production_popupinfosbundle_popuppinned';
    }


}

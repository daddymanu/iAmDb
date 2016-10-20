<?php

namespace MyApp\FilmsBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActeurSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
        	->add('keyword', TextType::class, array('label' => false, 'required' => false))
            // ->add('submit', SubmitType::class, array('label'=>false, 'attr'=>array('class'=>'btn btn-primary btn-search')))
        ;
    }
    
    public function getName()
    {        
        return 'acteur_search'; // any string, actually!!!
    }
}
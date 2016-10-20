<?php

namespace MyApp\FilmsBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ActeurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, array('label'=>'acteur.nom', 'attr'=>array('class'=>'form-control')))
            ->add('prenom', TextType::class, array('label'=>'acteur.prenom', 'attr'=>array('class'=>'form-control')))
            ->add('dateNaissance', BirthdayType::class, array('widget' => 'choice',
                                                             'format' => 'yyyy-MM-dd',
                                                             'years' => range(date('Y'), date('Y')-120)))
            // ->add('dateMort', BirthdayType::class, array('widget' => 'choice', 
            //                                          'format' => 'yyyy-MM-dd',
            //                                          'years' => range(date('Y'), date('Y')-90)))
            ->add('sexe', ChoiceType::class, array('choices' => array('Female'=>'F','Male'=>'M'), 'label'=>'acteur.sexe', 'attr'=>array('class'=>'form-control')))
            ->add('submit', SubmitType::class, array('label'=>'default.btnSave', 'attr'=>array('class'=>'btn btn-primary btn-md')))
        ;
        // dump($builder);
        // die();
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\FilmsBundle\Entity\Acteur'
        ));
    }
}

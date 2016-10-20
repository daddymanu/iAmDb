<?php

namespace MyApp\FilmsBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array('label'=>'film.titre', 'attr'=>array('class'=>'form-control')))

            ->add('description', TextareaType::class, array('label'=>'film.description', 'attr'=>array('class'=>'form-control')))

            // ->add('categorie', EntityType::class, array('label'=>'Category', 'placeholder'=>'Pick a category...', 'class'=>'MyAppFilmsBundle:Categorie', 'choice_label'=>'nom', 'multiple'=>false,'attr'=>array('class'=>'form-control')))
            // since we created a "__toString" method in Categorie, we can use:
            ->add('categorie', null, array('label'=>'film.category', 'placeholder'=>'film.categoryPlaceholder','attr'=>array('class'=>'form-control')))

            // ->add('year', ChoiceType::class, array('choices' => array_combine($years, $years), 'attr'=>array('class'=>'form-control')))
            ->add('year', ChoiceType::class, array('choices'=>$this->buildYearChoices(), 'multiple'=>false, 'label'=>'film.year', 'placeholder'=>'film.yearPlaceholder', 'attr'=>array('class'=>'form-control')))

            // ->add('acteurs', EntityType::class, array('label'=>'Actors (Multiple choices)', 'class'=>'MyAppFilmsBundle:Acteur', 'choice_label'=>'fullName', 'multiple'=>true, 'expanded'=>true))
            // since we created a "__toString" method in Acteur, we can use:
            ->add('acteurs', null, array('label'=>'film.actors', 'expanded'=>true)) 
                      
            ->add('submit', SubmitType::class, array('label'=>'default.btnSave', 'attr'=>array('class'=>'btn btn-primary btn-md')))
        ;
    }
    
    public function buildYearChoices()
    {
        // $years=[];
        // $i=1895;
        // while($i<date('Y')+20){
        //     array_push($years, $i);
        //     $i++;
        // }
        // dump($years);
        // die();

        $first = new \DateTime('01/01/1895');
        $now = date('Y')+20;
        $years = array();
        $years[0] = $first->format('Y');
        $i = 1;
        $oneYear = new \DateInterval('P1Y');
        while($first->format('Y') != $now) {
            $first->add($oneYear);
            $years[$i] = $first->format('Y');
            $i++;
        }
        rsort($years);
        return array_combine($years, $years);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\FilmsBundle\Entity\Film'
        ));
    }
}

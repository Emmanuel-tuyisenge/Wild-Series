<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Program;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du program',
                'attr' => [
                    'placeholder' => 'Tapez le nom d\'une série'
                ]
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Tapez une description assez courte mais parlante'
                ]
            ])
            ->add('poster', UrlType::class, [
                'label' => 'Affiche une série',
                'attr' => [
                    'placeholder' =>'Tapez l\'url de l\'image affiche de la série'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays d\'origine',
                'attr' => [
                    'placeholder' =>'Tapez le pays d\'origine de cette série'
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'l\'année de sorti',
                'attr' => [
                    'placeholder' => 'Veuillez renseinigner l\'année'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '** Choisir une catégorie **',
                'class' => Category::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}

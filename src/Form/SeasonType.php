<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', NumberType::class, [
                'label' => 'numéro'
            ])
            ->add('year', NumberType::class, [
                'label' => 'Année'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'])
            ->add('program', EntityType::class, [
                'label' => 'Série',
                'placeholder' => '** Choisir une série **',
                'class' => Program::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}

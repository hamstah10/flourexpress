<?php

namespace App\Form;

use App\Entity\sorte;
use App\Entity\Treuepunkte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreuepunkteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('datum', null, [
                'widget' => 'single_text',
            ])
            ->add('menge')
            ->add('erledigt')
            ->add('sorte', EntityType::class, [
                'class' => sorte::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Treuepunkte::class,
        ]);
    }
}

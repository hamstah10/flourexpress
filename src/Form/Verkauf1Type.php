<?php

namespace App\Form;

use App\Entity\Fahrer;
use App\Entity\Sorte;
use App\Entity\Verkauf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Verkauf1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('menge1g')
            ->add('menge05g')
            ->add('datum', null, [
                'widget' => 'single_text',
            ])
            ->add('sorte', EntityType::class, [
                'class' => Sorte::class,
                'choice_label' => 'id',
            ])
            ->add('fahrer', EntityType::class, [
                'class' => Fahrer::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Verkauf::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Sorte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Sorte1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            
            ->add('einkaufspreis_pro_kg', NumberType::class, [
                'label' => 'Wareneinkaufspreis pro 1/100 Zentner',
                'required' => true,
                'row_attr' => [
                    'class' => 'mb-3',
                ],
            ])
            ->add('verkaufspreis1g', NumberType::class, [
                'label' => 'Verkaufspreis pro Sack',
                'required' => true,
                'row_attr' => [
                    'class' => 'mb-3',
                ],
            ])
            ->add('verkaufspreis05g', NumberType::class, [
                'label' => 'Verkaufspreis pro 1/2 Sack',
                'required' => true,
                'row_attr' => [
                    'class' => 'mb-3',
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorte::class,
        ]);
    }
}

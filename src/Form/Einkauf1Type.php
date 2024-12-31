<?php

namespace App\Form;

use App\Entity\Einkauf;
use App\Entity\Sorte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Einkauf1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mengekg')
            ->add('datum', null, [
                'widget' => 'single_text',
            ])
            ->add('sorte', EntityType::class, [
                'class' => Sorte::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Einkauf::class,
        ]);
    }
}

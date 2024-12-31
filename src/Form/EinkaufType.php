<?php
namespace App\Form;

use App\Entity\Sorte;
use App\Entity\Einkauf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EinkaufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sorte', EntityType::class, [
                'class' => Sorte::class,
                'choice_label' => 'name',
            ])
            ->add('mengekg', NumberType::class)
            ->add('datum', DateType::class)
            ->add('submit', SubmitType::class, ['label' => 'Einkauf speichern']);
    }
}

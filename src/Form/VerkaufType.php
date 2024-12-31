<?php
namespace App\Form;

use App\Entity\Verkauf;
use App\Entity\Sorte;
use App\Entity\Fahrer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class VerkaufType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sorte', EntityType::class, [
                'class' => Sorte::class,
                'choice_label' => 'name',
            ])
            ->add('menge1g', NumberType::class)
            ->add('menge05g', NumberType::class)
            ->add('fahrer', EntityType::class, [
                'class' => Fahrer::class,
                'choice_label' => 'name',
            ])
            ->add('datum', DateType::class)
            ->add('submit', SubmitType::class, ['label' => 'Verkauf speichern']);
    }
}

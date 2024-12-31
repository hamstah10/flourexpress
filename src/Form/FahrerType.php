<?php
namespace App\Form;

use App\Entity\Sorte;
use App\Entity\Einkauf;
use App\Entity\Verkauf;
use App\Entity\Fahrer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DecimalType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FahrerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('verguetung1g', NumberType::class)
            ->add('verguetung05g', NumberType::class)
            ->add('submit', SubmitType::class, ['label' => 'Fahrer speichern']);
    }
}

<?php

namespace App\Form;

use App\Entity\VariableFeesLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariableFeesLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class,['label' => false, 'years' => range(Date('Y'), date('Y')), 'months' => range(Date('m') - 1, date('m'))])
            ->add('name',TextType::class,['label' => false])
            ->add('amount',NumberType::class,['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VariableFeesLine::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\VariableFeesLine;
use DateTime;
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
        $dateActuelle = (new \DateTime())->format('Y-m-d');
        $date1years = date('Y-m-d', strtotime($dateActuelle. ' - 1 years'));
        $builder
            ->add('date',DateType::class,['label' => false, 'attr' => ['min' => ($date1years), 'max' => $dateActuelle] ,'widget' => 'single_text'])
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

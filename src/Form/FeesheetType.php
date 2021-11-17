<?php

namespace App\Form;

use App\Entity\FeeSheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeesheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbDocuments')
            ->add('validAmount')
            ->add('standardfeeslines', CollectionType::class, [
            'entry_type' => StandardFeesLineType::class,
            'by_reference' => false,
            'label' => false,
            ])
            ->add('variablefeeslines', CollectionType::class, [
                'entry_type' => VariableFeesLineType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeeSheet::class,
        ]);
    }
}

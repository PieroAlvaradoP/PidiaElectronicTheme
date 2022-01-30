<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\EquipoMarca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoMarcaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreMarca')
            ->add('detalleMarca')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EquipoMarca::class,
        ]);
    }
}

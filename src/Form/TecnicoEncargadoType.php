<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\TecnicoEncargado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TecnicoEncargadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreTecnico')
            ->add('apellidoTecnico')
            ->add('dni')
            ->add('direccion')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('activo')
            ->add('uuid')
            ->add('propietario')
            ->add('config')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TecnicoEncargado::class,
        ]);
    }
}

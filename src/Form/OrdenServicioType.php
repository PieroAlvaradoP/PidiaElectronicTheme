<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Cliente;
use Pidia\Apps\Demo\Entity\Equipo;
use Pidia\Apps\Demo\Entity\OrdenServicio;
use Pidia\Apps\Demo\Entity\TecnicoEncargado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdenServicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroOrden')
            ->add('fechaIngreso', DateType::class, [
            'widget' => 'single_text',
        ])
            ->add('fechaSalida', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('clienteOrden', EntityType::class, [
                'class' => Cliente::class,
                'placeholder' => 'Seleccione ...',
            ])
            ->add('equipo', EntityType::class, [
                'class' => Equipo::class,
                'placeholder' => 'Seleccione ...',
            ])
            ->add('estadoOrden')
            ->add('tecnicoOrden', EntityType::class, [
                'class' => TecnicoEncargado::class,
                'placeholder' => 'Seleccione ...',
            ])
            ->add('precio')
            ->add('detalleOrdens', CollectionType::class, [
                'entry_type' => DetalleOrdenType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrdenServicio::class,
        ]);
    }
}

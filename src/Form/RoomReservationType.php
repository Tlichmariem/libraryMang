<?php
// src/Form/RoomReservationType.php

namespace App\Form;

use App\Entity\RoomReservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class RoomReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThan(['value' => new \DateTime(), 'message' => 'Start time must be in the future']),
                ],
            ])
            ->add('endTime', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[startTime].data',
                        'message' => 'End time must be after start time',
                    ]),
                    new LessThanOrEqual([
                        'value' => (new \DateTime())->modify('+4 hours'),
                        'message' => 'Reservation cannot exceed 4 hours',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RoomReservation::class,
        ]);
    }
}
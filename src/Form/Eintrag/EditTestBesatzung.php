<?php

// src/AppBundle/Form/UserType.php
namespace App\Form\Eintrag;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Fahrzeug;
use App\Entity\Mitglieder;
use App\Entity\Rolle;
use App\Entity\Fahrzeugbesatzung;

class EditTestBesatzung extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idfahrzeugbesatzung', HiddenType::class, array())
            ->add('idfahrzeugFahrzeug', EntityType::class, array(
                'placeholder'=> 'Wähle ein Fahrzeug...',
                'class' => Fahrzeug::class,
                'choice_label' => 'fahrzeugart',
                'label'=> 'Fahrzeug',
            ))
            ->add('idmitgliederMitglieder', EntityType::class, array(
                'placeholder'=> 'Wähle ein Mitglied..',
                'class' => Mitglieder::class,
                'choice_label' => 'uniqueName',
                'label'=> 'Mitglied'
            ))
            ->add('rolle', EntityType::class, array(
                'placeholder'=> 'Welche Rolle..',
                'class' => Rolle::class,
                'choice_label' => 'rollenname'
            ))
            ->add('atemschutz', CheckboxType::class, [
                'label' => 'Atemschutzeinsatz',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Fahrzeugbesatzung::class,
        ));
    }
}

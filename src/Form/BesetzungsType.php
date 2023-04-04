<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Logbuch;
use App\Entity\Fahrzeug;
use App\Entity\Mitglieder;
use App\Entity\Rolle;
use App\Entity\Fahrzeugbesatzung;

class BesetzungsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idlogbuchLogbuch', HiddenType::class, array())
            ->add('idfahrzeugFahrzeug', EntityType::class, array(
                'placeholder'=> 'Wähle ein Fahrzeug...',
                'class' => Fahrzeug::class,
                'choice_label' => 'fahrzeugart',
                'label' => 'Fahrzeug',
            ))
            ->add('idmitgliederMitglieder', EntityType::class, array(
                'placeholder'=> 'Wähle ein Mitglied..',
                'class' => Mitglieder::class,
                'choice_label' => 'uniqueName',
                'label' => 'Mitglied',
            ))
            ->add('rolle', EntityType::class, array(
                'placeholder'=> 'Welche Rolle..',
                'class' => Rolle::class,
                'choice_label' => 'rollenname',
                'label' => 'Rolle',
            ))
            ->add('atemschutz', CheckboxType::class, [
                'label' => 'Atemschutzträger',
                'required' => false,

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Fahrzeugbesatzung::class,
        ));
    }
}

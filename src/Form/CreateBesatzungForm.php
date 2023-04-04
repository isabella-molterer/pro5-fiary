<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
use App\Form\BesetzungsType;

class CreateBesatzungForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 4:
                $builder->add('besatzung', CollectionType::class, array(
                    'entry_type' => BesetzungsType::class,
                    'allow_add'    => true,
                ));
                break;
        }
    }

    public function getBlockPrefix() {
        return 'createEntry2';
    }
}

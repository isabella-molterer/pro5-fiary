<?php

// src/AppBundle/Form/UserType.php
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
use App\Form\BesetzungsType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Logbuch;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class CreateEntryForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 1:
                $builder->add('kategorie', ChoiceType::class, array(
                'choices'=>array('Einsatz'=>'Einsatz','Übung'=>'Übung', 'Tätigkeit'=> 'Tätigkeit'),
                    'placeholder'=> 'Wähle eine Kategorie..',
                    'required'=>true,
            ));
                break;
            case 2:
                // This form type is not defined in the example.
                $builder->add('unterkategorie', ChoiceType::class, [
                    'choices' => array_flip(Logbuch::getUnterKategorieOptions_Einsatz()),
                    'placeholder'=> 'Wähle eine Unterkategorie'
                ])
                    //beim technischen einsatz gibts ne unterunterkategorie
                    ->add('unterunterkategorie', ChoiceType::class, array(

                        'choices' => array_flip(Logbuch::getUnterKategorien_TechEinsatz()),
                        'required'=>false,
                        'placeholder' => 'Wähle...'
                    ))
                    //wenn unterkategorie==brandeinsatz
                    ->add('brandausDate', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandausTime', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'required'=>false
                    ))
                    ->add('brandwacheStartDate', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandwacheStartTime', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'required'=>false
                    ))
                    ->add('brandwacheEndeDate', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandwacheEndeTime', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'required'=>false
                    ))
                    ->add('brandausmass', ChoiceType::class, array(
                        'choices' => array_flip(Logbuch::getBrandausmassOptions()),
                        'multiple'=>false,
                        'expanded'=>true,
                        'placeholder' => false,
                        'required'=>false

                    ))
                    ->add('brandobjekte', TextType::class, array(
                        'required'=>false
                    ))
                    //wenn unterkategorie==brandsicherheitswache
                    ->add('anlass', ChoiceType::class, array(
                        'choices'=>array('brandgefährliche Tätigkeit'=>'brandgefährliche Tätigkeit','bei Veranstaltung'=>'bei Veranstaltung'),
                        'multiple'=>false,
                        'expanded'=>true,'placeholder' => false,
                        'required'=>false
                    ))
                    ->add('strasse', TextType::class)
                    ->add('hausnummer', TextType::class)
                    ->add('plz', NumberType::class)
                    ->add('ort', TextType::class)
                    ->add('alarmdatum', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('alarmzeit', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'empty_data' => '',
                        'required'=>false

                    ))
                    ->add('beginnDatum', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now")
                    ))
                    ->add('beginnZeit', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                    ))
                    ->add('endeDatum', DateType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                        'data' => new \DateTime("now")
                    ))
                    ->add('endeZeit', TimeType::class, array(
                        // renders it as a single text box
                        'widget' => 'single_text',
                    ))
                    ->add('lagebeimEintreffen', TextareaType::class, array(
                        'required'=>false
                    ))
                    ->add('beschreibung', TextareaType::class, array(
                        'required'=>true
                    ))
                    ->add('eingesetzteGeraete', TextType::class, array(
                        'label' => 'Eingesetzte Geräte',
                        'required'=>false,

                    ));

                break;
            case 3:
                $builder->add('geschaedigterName', TextType::class, array(
                    'required'=>false
                ))
                    ->add('geschaedigterAdresse', TextType::class, array(
                        'required'=>false
                    ))
                    ->add('geschaedigterTel', TextType::class, array(
                        'required'=>false
                    ))
                    ->add('geschaedigterKennzeichen', TextType::class, array(
                        'required'=>false
                    ))

                    ->add('wetter', ChoiceType::class, array(
                        'choices' => array_flip(Logbuch::getWetterOptions()),
                        'multiple'=>true,
                        'expanded'=>true,
                        'required'=>false
                    ))
                    ->add('anwesend', ChoiceType::class, array(
                        'choices'=>array('BH'=>'Bezirkshauptmannschaft','EVU'=>'EVU','Polizei'=>'Polizei','Straßenverwaltung'=>'Straßenverwaltung',
                            'BFKDT/AFKDT'=>'BFKDT/AFKDT', 'Gemeinde'=>'Gemeinde', 'Rettung'=>'Rettung', 'Wasserwerk'=>'Wasserwerk', 'Sonstige'=>'Sonstige'),
                        'multiple'=>true,
                        'expanded'=>true

                    ))
                    ->add('betriebsmittel', TextType::class, array(
                        'required'=>false
                    ))
                    ->add('notizen', TextareaType::class, array(
                        'required'=>false
                    ))
                    ->add('bericht', TextareaType::class, array(
                        'required'=>false
                    ))
                    ->add('uebungsleiter', TextType::class, array(
                        'required'=>false
                    ))
                    ->add('photo', FileType::class, array(
                        'required'=>false
                    ));
                break;
            case 4:

                $builder->add('besatzung', CollectionType::class, array(
                    'entry_type' => BesetzungsType::class,
                    'entry_options' => ['label' => false],
                    'allow_add'    => true,
                ));
                break;
                //C:\xampp\htdocs\newfiary\vendor\symfony\framework-bundle\Resources\views\Form


        }
    }

    public function getBlockPrefix() {
        return 'createEntry';
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return $this->getBlockPrefixFoto();
    }
    /**
     * {@inheritDoc}
     */
    public function getBlockPrefixFoto() {
        return 'photoUpload';
    }
}

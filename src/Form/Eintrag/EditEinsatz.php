<?php

namespace App\Form\Eintrag;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\BesetzungsType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Logbuch;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EditEinsatz extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unterkategorie', ChoiceType::class, [
                'choices' => array_flip(Logbuch::getUnterKategorieOptions_Einsatz3()),
            ])
            ->add(
                $builder->create('zeit', FormType::class, array('inherit_data' => true, 'attr' => ['class' => 'zeit'], 'label' => 'Zeitliche Details'))
                    ->add('alarmdatum', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required' => false
                    ))
                    ->add('alarmzeit', TimeType::class, array(
                        'widget' => 'single_text',
                        'empty_data' => '',
                        'required' => false
                    ))
                    ->add('beginnDatum', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now")
                    ))
                    ->add('beginnZeit', TimeType::class, array(
                        'widget' => 'single_text',
                    ))
                    ->add('endeDatum', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now")
                    ))
                    ->add('endeZeit', TimeType::class, array(
                        'widget' => 'single_text',
                    ))
            )
            ->add(
                $builder->create('ort', FormType::class, array('inherit_data' => true, 'attr' => ['class' => 'ort'], 'label' => 'Örtliche Details'))
                    ->add('strasse', TextType::class)
                    ->add('hausnummer', TextType::class)
                    ->add('plz', NumberType::class)
                    ->add('ort', TextType::class)
                    ->add('photo', FileType::class, array(
                        'required'=>false, 'attr' => ['class' => 'fullwidth']
                    ))
            )
            ->add(
                $builder->create('zusatz', FormType::class, array('inherit_data' => true, 'attr' => ['class' => 'zusatz'], 'label' => 'Zusätzliche Details'))
                    ->add('lagebeimEintreffen', TextareaType::class, array(
                        'required'=>false, 'attr' => ['class' => 'fullwidth']
                    ))
                    ->add('beschreibung', TextareaType::class, array(
                        'required'=>false, 'attr' => ['class' => 'fullwidth']
                    ))
                    ->add('eingesetzteGeraete', TextType::class, array(
                        'required'=>false, 'attr' => ['class' => 'fullwidth']
                    ))
            )
            // wenn unterkategorie==technischen
            ->add('unterunterkategorie', ChoiceType::class, array(
                'choices' => array_flip(Logbuch::getUnterKategorien_TechEinsatz()),
                'required'=>false,
                'attr'=> array('class'=>'test'),
                'label' => 'Technische Einsatzart '
            ))
            // wenn unterkategorie==brandeinsatz
            ->add(
                $builder->create('brandeinsatz', FormType::class, array('inherit_data' => true, 'attr' => ['class' => 'brand'], 'label' => 'Details zum Brand'))
                    ->add('brandausDate', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandausTime', TimeType::class, array(
                        'widget' => 'single_text',
                        'required'=>false
                    ))
                    ->add('brandwacheStartDate', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandwacheStartTime', TimeType::class, array(
                        'widget' => 'single_text',
                        'required'=>false
                    ))
                    ->add('brandwacheEndeDate', DateType::class, array(
                        'widget' => 'single_text',
                        'data' => new \DateTime("now"),
                        'required'=>false
                    ))
                    ->add('brandwacheEndeTime', TimeType::class, array(
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
            )
            // wenn unterkategorie==brandsicherheitswache
            ->add(
                $builder->create('brandsicherheitswache', FormType::class, array('inherit_data' => true, 'attr' => ['class' => 'brandsicherheitswache']))
                    ->add('anlass', ChoiceType::class, array(
                        'choices'=>array('brandgefährliche Tätigkeit'=>'brandgefährliche Tätigkeit','bei Veranstaltung'=>'bei Veranstaltung'),
                        'multiple'=>false,
                        'expanded'=>true,'placeholder' => false,
                        'required'=>false
                    ))
                    ->add('geschaedigterName', TextType::class, array(
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
                        'required'=>false,
                    ))
                    ->add('anwesend', ChoiceType::class, array(
                        'choices'=>array('BH'=>'Bezirkshauptmannschaft','EVU'=>'EVU','Polizei'=>'Polizei','Straßenverwaltung'=>'Straßenverwaltung', 'BFKDT/AFKDT'=>'BFKDT/AFKDT', 'Gemeinde'=>'Gemeinde', 'Rettung'=>'Rettung', 'Wasserwerk'=>'Wasserwerk', 'Sonstige'=>'Sonstige'),
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
            )
            ->add('submit', SubmitType::class, array('attr' => array('class'=>'submit bigredbutton')));
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

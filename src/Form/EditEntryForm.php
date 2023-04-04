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
use App\Form\BesetzungsType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Logbuch;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EditEntryForm extends AbstractType
{
    public function buildEinsatzForm(FormBuilderInterface $builder, string $type, array $options)
    {
        $builder = $this->buildForm($builder);
        $builder
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
            ->add('lagebeimEintreffen', TextareaType::class, array(
                'required'=>false
            ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kategorie', ChoiceType::class, array(
                'choices'=>array('Einsatz'=>'Einsatz','Übung'=>'Übung', 'Tätigkeit'=> 'Tätigkeit'),
                'placeholder'=> 'Wähle eine Kategorie..',
                'required'=>false,
            ))
            ->add('unterkategorie', ChoiceType::class, [
                'choices' => array_flip(Logbuch::getUnterKategorieOptions_Einsatz()),
                'placeholder'=> 'Wähle eine Unterkategorie'
            ])
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
            ->add('lagebeimEintreffen', TextareaType::class, array(
                'required'=>false
            ))
            ->add('beschreibung', TextareaType::class, array(
                'required'=>false
            ))
            ->add('eingesetzteGeraete', TextType::class, array(
                'required'=>false
            ))
            ->add('strasse', TextType::class)
            ->add('hausnummer', TextType::class)
            ->add('plz', NumberType::class)
            ->add('ort', TextType::class);
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

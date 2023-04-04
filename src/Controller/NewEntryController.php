<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\Logbuch;
use App\Entity\Haus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Choice;

class NewEntryController extends AbstractController
{
    private function buildForm_Einsatz($entry) {

        return $this->createFormBuilder($entry)

            ->add('kategorie', ChoiceType::class, array(
                'choices'=>array('Einsatz'=>'Einsatz','Übung'=>'Übung', 'Tätigkeit'=> 'Tätigkeit')
            ))
            ->add('unterkategorie', ChoiceType::class, [
                'choices' => array_flip(Logbuch::getUnterKategorieOptions_Einsatz())
            ])
            // unterunterkategorie technischen einsatz
            ->add('unterunterkategorie', ChoiceType::class, array(
                'choices' => array_flip(Logbuch::getUnterKategorien_TechEinsatz()),
                'required'=>false
             ))
            // unterkategorie brandeinsatz
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
                'widget' => 'single_text',
                'data' => new \DateTime("now"),
                'required'=>false
            ))
            ->add('alarmzeit', TimeType::class, array(
                'widget' => 'single_text',
                'empty_data' => '',
                'required'=>false
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
            ->add('lagebeimEintreffen', TextareaType::class, array(
                'required'=>false
            ))
            ->add('beschreibung', TextareaType::class, array(
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
            ->add('eingesetzteGeraete', TextType::class, array(
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
            ->add('save', SubmitType::class)
            ->getForm();
    }

    /**
     * @Route("/newentry", name="newentry")
     */
    public function index(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userId = $user->getId();

        $neuereinsatz = new Logbuch();
        $neuereinsatz->setIdbenutzerBenutzer($userId);

        $form_einsatz = $this->buildForm_Einsatz($neuereinsatz);
        $form_einsatz->handleRequest($request);

        $repo=$this->getDoctrine()->getRepository(Haus::class);
        $häuser = $repo->findAll();

        if ($form_einsatz->isSubmitted() && $form_einsatz->isValid()) {
            $neuereinsatz = $form_einsatz->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($neuereinsatz);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('new_entry/newentry.html.twig', [
            'form_einsatz' => $form_einsatz->createView(),
            'haeuser'=>$häuser,
        ]);
    }
}

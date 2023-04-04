<?php

namespace App\Controller;

use App\Entity\Fahrzeugbesatzung;
use App\Entity\Feed;
use App\Form\BesetzungsType;
use App\Form\Eintrag\EditTestBesatzung;
use App\Form\Eintrag\EditBesatzung;
use App\Form\Eintrag\EditEinsatz;
use App\Form\Eintrag\EditTätigkeit;
use App\Form\Eintrag\EditÜbung;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Mitglieder;
use App\Entity\Haus;
use App\Entity\Logbuch;
use Symfony\Component\Form\Extension\Core\Type\DateType;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;


class PageController extends Controller //AbstracController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository(Feed::class);
        $allDates = $repository->createQueryBuilder('fd')
            ->select('fd.idfeed, fd.title, fd.feed, fd.date')
            ->orderBy('fd.date', 'DESC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();

        $ultimateFeed = $allDates[0];

        $repository =  $em->getRepository(Logbuch::class);

        $eintraege=$repository->createQueryBuilder('fc')
            ->select('fc.idlogbuch, fc.beginnDatum, fc.beschreibung, fc.kategorie, fc.unterkategorie, fc.strasse, fc.hausnummer, fc.metadata')
            ->orderBy('fc.beginnDatum', 'DESC')
            ->orderBy('fc.metadata', 'DESC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();

        // aktuelle Monatsstatistik
        $month=date('M');
        $monthnumber=date('m', strtotime('month'));
        $firstDayofMonth=date('Y') . '-' . $monthnumber . '-01';
        $lastDayofMonth=date('Y') . '-' . $monthnumber . '-31';
        $year=date('Y');

        $einsätze_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as einsaetze_month')
            ->getQuery()
            ->getSingleScalarResult();

        $tätigkeiten_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'tätigkeit')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as taetigkeiten_month')
            ->getQuery()
            ->getSingleScalarResult();

        $übungen_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'übung')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as uebung_month')
            ->getQuery()
            ->getSingleScalarResult();

        // replace this example code with whatever you need
        return $this->render('homepage/index.html.twig', [
            'entry' => $ultimateFeed,
            'eintraege'=> $eintraege,
            'month'=>$month,
            'einsaetze_month'=>$einsätze_month,
            'taetigkeiten_month'=>$tätigkeiten_month,
            'uebungen_month'=>$übungen_month,
            'year'=>$year,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/pages", name="pages")
     */
    public function pageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('pages/page.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/statistiken", name="statistics")
     */
    public function statisticAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository =  $em->getRepository(Logbuch::class);

        $lastDayofYear=date('Y') . '-12-31';
        $firstDayofYear=date('Y') . '-01-01';
        $year=date('Y');
        $month=date('M');
        $monthnumber=date('m', strtotime('month'));
        $lastDayofYearBefore=date('Y')-1 . '-12-31';
        $firstDayofYearBefore=date('Y')-1 . '-01-01';

        $firstDayofMonth=date('Y') . '-' . $monthnumber . '-01';
        $lastDayofMonth=date('Y') . '-' . $monthnumber . '-31';

        $einsätze=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as einsaetze')
            ->getQuery()
            ->getSingleScalarResult();

        $übungen=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'übung')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as uebungen')
            ->getQuery()
            ->getSingleScalarResult();

        $brandeinsatz=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum) and fc.unterkategorie = :unterkategorie')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('unterkategorie', '0')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as brandeinsatz')
            ->getQuery()
            ->getSingleScalarResult();

        $brandsicherheitswache=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum) and fc.unterkategorie = :unterkategorie')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('unterkategorie', '1')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as brandsicherheitswache')
            ->getQuery()
            ->getSingleScalarResult();

        $technischer=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum) and fc.unterkategorie = :unterkategorie')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('unterkategorie', '2')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as technischer')
            ->getQuery()
            ->getSingleScalarResult();

        $tätigkeiten=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'tätigkeit')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as taetigkeiten')
            ->getQuery()
            ->getSingleScalarResult();

        $einsätze_last=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('enddatum', $lastDayofYearBefore)
            ->setParameter('startdatum', $firstDayofYearBefore)
            ->select('COUNT(fc.idlogbuch) as einsaetze_last')
            ->getQuery()
            ->getSingleScalarResult();

        $gesamt=$repository->createQueryBuilder('fc')
            ->andWhere('(fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('COUNT(fc.idlogbuch) as gesamt')
            ->getQuery()
            ->getSingleScalarResult();

        $gesamt_last=$repository->createQueryBuilder('fc')
            ->andWhere('(fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('enddatum', $lastDayofYearBefore)
            ->setParameter('startdatum', $firstDayofYearBefore)
            ->select('COUNT(fc.idlogbuch) as gesamt_last')
            ->getQuery()
            ->getSingleScalarResult();

        $einsätze_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'einsatz')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as einsaetze_month')
            ->getQuery()
            ->getSingleScalarResult();

        $tätigkeiten_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'tätigkeit')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as taetigkeiten_month')
            ->getQuery()
            ->getSingleScalarResult();

        $übungen_month=$repository->createQueryBuilder('fc')
            ->andWhere('fc.kategorie = :kategorie and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('kategorie', 'übung')
            ->setParameter('enddatum', $lastDayofMonth)
            ->setParameter('startdatum', $firstDayofMonth)
            ->select('COUNT(fc.idlogbuch) as uebung_month')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('pages/statistiken.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'einsaetze'=> $einsätze,
            'year'=>$year,
            'lastyear'=>$year-1,
            'einsaetze_last'=>$einsätze_last,
            'gesamt'=>$gesamt,
            'uebungen'=>$übungen,
            'taetigkeiten'=>$tätigkeiten,
            'brandeinsatz'=>$brandeinsatz,
            'technischer'=>$technischer,
            'brandsicherheitswache'=>$brandsicherheitswache,
            'month'=>$month,
            'gesamt_last'=>$gesamt_last,
            'einsaetze_month'=>$einsätze_month,
            'taetigkeiten_month'=>$tätigkeiten_month,
            'uebungen_month'=>$übungen_month,
        ]);
    }

    /**
     * @Route("/eintraege", name="entries")
     */
    public function entryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository =  $em->getRepository(Logbuch::class);
        $lastDayofYear=date('Y') . '-12-31';
        $firstDayofYear=date('Y') . '-01-01';

        $eintraege=$repository->createQueryBuilder('fc')
            ->andWhere('(fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
            ->setParameter('enddatum', $lastDayofYear)
            ->setParameter('startdatum', $firstDayofYear)
            ->select('fc.idlogbuch, fc.beginnDatum, fc.beschreibung, fc.kategorie, fc.unterkategorie, fc.strasse, fc.hausnummer, fc.metadata')
            ->orderBy('fc.metadata', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('pages/entryOverview.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'eintraege'=> $eintraege,
        ]);
    }

    /**
     * @Route("/eintraege/delete/{id}", name="entries_delete")
     */
    public function deleteEntry($id)
    {
        $eintrag = $this->getDoctrine()->getRepository(Logbuch::class)->find($id);

        if ($eintrag) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eintrag);
            $em->flush();
        }

        return $this->redirectToRoute('entries');
    }

    /**
     * @Route("/eintraege/edit/{id}", name="entries_edit")
     */
    public function editEntry($id, Request $request)
    {
        $eintrag = $this->getDoctrine()->getRepository(Logbuch::class)->find($id);
        $kategorie = $eintrag->getKategorie();
        $unterkategorie = $eintrag->getUnterkategorie();
        $besatzungsForm = null;

        $em = $this->getDoctrine()->getManager();
        $besatzung = $em->getRepository(Fahrzeugbesatzung::class)->findBy(array('idlogbuchLogbuch' => $id));
        $bForms = null;

        $newBesatzung = new Fahrzeugbesatzung();
        $newBesatzung->setIdlogbuchLogbuch($eintrag);
        $sForm = $this->createForm(EditTestBesatzung::class, $newBesatzung)->createView();

        if ($eintrag) {
            if ($besatzung) {
                for ($i = 0; $i<sizeof($besatzung); $i++){
                    $besatzungsForm[$i] = $this->createForm(EditBesatzung::class, $besatzung[$i]);
                    $bForms[$i] = $besatzungsForm[$i]->createView();
                }
            }

            if ($kategorie == "Einsatz" ) {
                $form = $this->createForm(EditEinsatz::class, $eintrag);
            } else if ($kategorie == "Übung") {
                $form = $this->createForm(EditÜbung::class, $eintrag);
            } else if ($kategorie == "Tätigkeit") {
                $form = $this->createForm(EditTätigkeit::class, $eintrag);
            }

            if ($request->isMethod('POST')) {
                print('POST');

                $em = $this->getDoctrine()->getManager();
                $repository =  $em->getRepository(Fahrzeugbesatzung::class);

                $count = 0;
                if ($besatzungsForm) {
                    foreach ($besatzungsForm as $bform) {
                        $bform->handleRequest($request);
                        $count++;
                        print($count);

                        foreach ($besatzung as $member) {
                            if ($member->getIdmitgliederMitglieder() == $bform->get('idmitgliederMitglieder')->getData()){
                                print('small ');
                                $b = $bform->getData();
                                $em->persist($b);
                                $em->flush();

                                $bid = $bform->get('idfahrzeugbesatzung')->getData();
                                $rolle = $bform->get('rolle')->getData();

                                $fahrzeugId = $bform->get('idfahrzeugFahrzeug')->getData();
                                $mitgliederId = $bform->get('idmitgliederMitglieder')->getData();
                                $atemschutz = $bform->get('atemschutz')->getData();
                                print('rolle:' . $rolle . ' und ' . $member->getRolle());
                                $qb = $repository->createQueryBuilder('fb');
                                $p = $qb->update()
                                    ->set('fb.rolle', '?1')
                                    ->set('fb.idfahrzeugFahrzeug', '?2')
                                    ->set('fb.idmitgliederMitglieder', '?3')
                                    ->set('fb.atemschutz', '?4')
                                    ->where('fb.idfahrzeugbesatzung = ?5')
                                    ->setParameter(1, $rolle)
                                    ->setParameter(2, $fahrzeugId)
                                    ->setParameter(3, $mitgliederId)
                                    ->setParameter(4, $atemschutz)
                                    ->setParameter(5, $bid)
                                    ->getQuery()
                                    ->execute();
                                if ($p) {
                                    print('success');
                                } else {
                                    print('fail');
                                }
                            }
                            break;
                        }
                    }
                }

                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $eintrag = $form->getData();
                    $em->persist($eintrag);
                    $em->flush();
                    return $this->redirectToRoute('entries');
                }
                return $this->redirectToRoute('entries');
            }

            return $this->render('new_entry/editEntry.html.twig', [
                'kategorie' => $kategorie,
                'unterkategorie' => $unterkategorie,
                'form' => $form->createView(),
                'bForms' => $bForms,
                'sampleForm' => $sForm
            ]);
        }
    }

    /**
     * @Route("/eintraege/save/{id}", name="entries_save")
     */
    public function saveEntry($id, Request $request)
    {
        $eintrag = $this->getDoctrine()->getRepository(Logbuch::class)->find($id);
        $kategorie = $eintrag->getKategorie();
        $brandeinsatz = null;
        $anwesend = null;
        $wetter = null;
        $ausmass = null;
        $brandwache = null;
        $techeinsatz = null;
        $besatzung = $this->getDoctrine()->getManager()->getRepository(Fahrzeugbesatzung::class)->findBy(array('idlogbuchLogbuch' => $id));

        if (!$besatzung) {
            $besatzung = null;
        }

        if ($kategorie == "Einsatz" ) {
            $unterkategorien = $eintrag->getUnterKategorieOptions_Einsatz3();

            if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandeinsatz" || $unterkategorien[$eintrag->getUnterKategorie()] == "Technischer Einsatz") {
                if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandeinsatz") {
                    $brandeinsatz = true;
                    $ausmass = $eintrag->getBrandausmassOptions()[$eintrag->getBrandausmass()];
                } else if ($unterkategorien[$eintrag->getUnterKategorie()] == "Technischer Einsatz") {
                    $techeinsatz = $eintrag->getUnterKategorien_TechEinsatz()[$eintrag->getUnterunterkategorie()];
                }

                $wIndex = $eintrag->getWetter();
                $wetter = '';
                foreach($wIndex as $val) {
                    if( !next( $wIndex ) ) {
                        $wetter .= $eintrag->getWetterOptions()[$val];
                    } else {
                        $wetter .= $eintrag->getWetterOptions()[$val] . ', ';
                    }
                }

                $aIndex = $eintrag->getAnwesend();
                $anwesend = '';
                foreach($aIndex as $val){
                    if( !next( $aIndex ) ) {
                        $anwesend .= $eintrag->getAnwesendePersonen()[$val];
                    } else {
                        $anwesend .= $eintrag->getAnwesendePersonen()[$val] . ', ';
                    }
                }
            } else if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandsicherheitswache") {
                $brandwache = true;
            }
        } else if ($kategorie == "Übung") {
            $unterkategorien = $eintrag->getUnterKategorieOptions_Übung();
        } else if ($kategorie == "Tätigkeit") {
            $unterkategorien = $eintrag->getUnterKategorieOptions_Tätigkeit();
        }

        $unterkategorie = $unterkategorien[$eintrag->getUnterkategorie()];

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('new_entry/saveEntry.html.twig', [
            'title' => "Welcome to our PDF Test",
            'eintrag' => $eintrag,
            'bForms' => $besatzung,
            'unterkategorie' => $unterkategorie,
            'brandeinsatz' => $brandeinsatz,
            'brandwache' => $brandwache,
            'ausmass' => $ausmass,
            'anwesend' => $anwesend,
            'wetter' => $wetter,
            'techeinsatz' => $techeinsatz
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $dompdf->set_base_path(realpath( "newfiary/public/assets/css/pdf.css"));

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Eintragsübersicht.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/info", name="infos")
     */
    public function infoAction(Request $request)
    {
        $button = null;
        $rep = $this->getDoctrine()->getRepository(Mitglieder::class);
        $mitglieder = $rep->findAll();

        $repo=$this->getDoctrine()->getRepository(Haus::class);
        $häuser = $repo->findAll();

        $repPdf = $this->getDoctrine()->getRepository(Logbuch::class);

        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('datum', DateType::class, [
                'attr' => ['class' => 'datepicker'],
                'format' => 'yyyy-MM-dd',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
                'data' => new \DateTime("now")
            ])
            ->add('zeit', ChoiceType::class, [
                    'choices'  => [
                        'Standard' => 'Standard',
                        'Monat' => 'Monat',
                        'Jahr' => 'Jahr',
                    ],
                    'multiple'     => false,
                    'expanded'     => true,
                    'data' => 'Standard'
                ]
            )
           ->add('kategorie', ChoiceType::class, [
                    'choices'  => [
                        'Einsatz' => 'Einsatz',
                        'Übung' => 'Übung',
                        'Tätigkeit' => 'Tätigkeit',
                    ],
                    'multiple'     => true,
                    'expanded'     => true,
                ]
            )
            ->add('submit', SubmitType::class, ['label'=> 'Generieren', 'attr' => array(
                'class'=>'submit btn biggreybutton') ])
            ->add('submit1', SubmitType::class, ['label'=> 'Gesamtansicht', 'attr' => array(
                'class'=>'submit btn biggreybutton') ])
            ->getForm();

        $form->handleRequest($request);
        $date = null;
        $entries = null;

        if($form->isSubmitted() && $form->isValid()) {
            $dateData = $form->get('datum')->getData();
            if ($dateData != null) {
                $date = $form->get('datum')->getData()->format('Y-m-d');
                $year = $form->get('datum')->getData()->format('Y');
                $month = $form->get('datum')->getData()->format('m');
                $kategorie = $form->get('kategorie')->getData();
                $einsatz = null;
                $uebung = null;
                $taetigkeit = null;

                if ($kategorie) {
                    foreach ($kategorie as $val) {
                        if ($val == 'Übung') {
                            $uebung = $val;
                        } else if ($val == 'Tätigkeit') {
                            $taetigkeit = $val;
                        } else if ($val == 'Einsatz') {
                            $einsatz = $val;
                        }
                    }
                } else {
                    $uebung = 'Übung';
                    $taetigkeit = 'Tätigkeit';
                    $einsatz = 'Einsatz';
                }

                if ($form->get('zeit')->getData() == 'Monat') {
                    $firstDayofMonth = $year . '-' . $month . '-01';
                    $lastDayofMonth = $year . '-' . $month . '-31';
                    $entries = $repPdf->createQueryBuilder('fc')
                        ->andWhere('(fc.kategorie = :einsatz or fc.kategorie = :uebung or fc.kategorie = :taetigkeit) and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
                        ->setParameter('enddatum', $lastDayofMonth)
                        ->setParameter('startdatum', $firstDayofMonth)
                        ->setParameter('einsatz', $einsatz)
                        ->setParameter('uebung', $uebung)
                        ->setParameter('taetigkeit', $taetigkeit)
                        ->select('fc')
                        ->orderBy('fc.beginnDatum', 'ASC')
                        ->getQuery()
                        ->getResult();
                } else if ($form->get('zeit')->getData() == 'Jahr') {
                    $firstDayofYear = $year . '-' . '01' . '-01';
                    $lastDayofYear = $year . '-' . '12' . '-31';
                    $entries = $repPdf->createQueryBuilder('fc')
                        ->andWhere('(fc.kategorie = :einsatz or fc.kategorie = :uebung or fc.kategorie = :taetigkeit) and (fc.beginnDatum BETWEEN :startdatum AND :enddatum)')
                        ->setParameter('enddatum', $lastDayofYear)
                        ->setParameter('startdatum', $firstDayofYear)
                        ->setParameter('einsatz', $einsatz)
                        ->setParameter('uebung', $uebung)
                        ->setParameter('taetigkeit', $taetigkeit)
                        ->select('fc')
                        ->orderBy('fc.beginnDatum', 'ASC')
                        ->getQuery()
                        ->getResult();
                } else {
                    $entries = $repPdf->createQueryBuilder('fc')
                        ->andWhere('(fc.kategorie = :einsatz or fc.kategorie = :uebung or fc.kategorie = :taetigkeit) and fc.beginnDatum = :datum')
                        ->setParameter('datum', $date)
                        ->setParameter('einsatz', $einsatz)
                        ->setParameter('uebung', $uebung)
                        ->setParameter('taetigkeit', $taetigkeit)
                        ->select('fc')
                        ->orderBy('fc.beginnDatum', 'ASC')
                        ->getQuery()
                        ->getResult();
                }
            }

            if ($entries) {
                $button = true;
            }

            if ($form->get('submit1')->isClicked() && $form->isValid()) {
                $loop = 0;

                foreach ($entries as $eintrag) {
                    $kategorie = $eintrag->getKategorie();
                    $wetter_array[$loop] = null;
                    $anwesend_array[$loop] = null;
                    $ausmass[$loop] = null;
                    $techeinsatz[$loop] = null;
                    $brandeinsatz[$loop] = null;
                    $brandwache[$loop] = null;

                    $besatzung[$loop] = null;
                    $id = $eintrag->getIdlogbuch();

                    $besatzung[$loop] = $this->getDoctrine()->getManager()->getRepository(Fahrzeugbesatzung::class)->findBy(array('idlogbuchLogbuch' => $id));

                    if (!$besatzung[$loop]) {
                        $besatzung[$loop] = null;
                    }

                    if ($kategorie == "Einsatz" ) {
                        $unterkategorien = $eintrag->getUnterKategorieOptions_Einsatz3();

                        if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandeinsatz" || $unterkategorien[$eintrag->getUnterKategorie()] == "Technischer Einsatz") {
                            if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandeinsatz") {
                                $brandeinsatz[$loop] = true;
                                $ausmass[$loop] = $eintrag->getBrandausmassOptions()[$eintrag->getBrandausmass()];
                            } else if ($unterkategorien[$eintrag->getUnterKategorie()] == "Technischer Einsatz") {
                                $techeinsatz[$loop] = $eintrag->getUnterKategorien_TechEinsatz()[$eintrag->getUnterunterkategorie()];
                            }

                            $wetter = '';
                            $wIndex = $eintrag->getWetter();
                            foreach($wIndex as $val) {
                                if( !next( $wIndex ) ) {
                                    $wetter .= $eintrag->getWetterOptions()[$val];
                                } else {
                                    $wetter .= $eintrag->getWetterOptions()[$val] . ', ';
                                }
                            }
                            $wetter_array[$loop] = $wetter;

                            $aIndex = $eintrag->getAnwesend();
                            $anwesend = '';
                            foreach($aIndex as $val){
                                if( !next( $aIndex ) ) {
                                    $anwesend .= $eintrag->getAnwesendePersonen()[$val];
                                } else {
                                    $anwesend .= $eintrag->getAnwesendePersonen()[$val] . ', ';
                                }
                            }
                            $anwesend_array[$loop] = $anwesend;
                        } else if ($unterkategorien[$eintrag->getUnterKategorie()] == "Brandsicherheitswache") {
                            $brandwache[$loop] = true;
                        }
                    } else if ($kategorie == "Übung") {
                        $unterkategorien = $eintrag->getUnterKategorieOptions_Übung();
                    } else if ($kategorie == "Tätigkeit") {
                        $unterkategorien = $eintrag->getUnterKategorieOptions_Tätigkeit();
                    }

                    $loop++;
                    $unterkategorie[] = $unterkategorien[$eintrag->getUnterkategorie()];
                }

                $pdfOptions = new Options();
                $pdfOptions->set('isRemoteEnabled', true);
                $pdfOptions->set('defaultFont', 'Arial');

                // Instantiate Dompdf with our options
                $dompdf = new Dompdf($pdfOptions);

                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('new_entry/saveEntries.html.twig', [
                    'title' => "Welcome to our PDF Test",
                    'eintraege' => $entries,
                    'bForms' => $besatzung,
                    'unterkategorie' => $unterkategorie,
                    'brandeinsatz' => $brandeinsatz,
                    'brandwache' => $brandwache,
                    'ausmass' => $ausmass,
                    'anwesend' => $anwesend_array,
                    'wetter' => $wetter_array,
                    'techeinsatz' => $techeinsatz
                ]);

                // Load HTML to Dompdf
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();
                $dompdf->set_base_path(realpath( "newfiary/public/assets/css/pdf.css"));


                // Output the generated PDF to Browser (force download)
                $dompdf->stream("Eintragsübersicht.pdf", [
                    "Attachment" => false
                ]);
            }
        }
        return $this->render('pages/info.html.twig', [
            'mitglieder' => $mitglieder,
            'button' => $button,
            'haeuser'=>$häuser,
            'form' => $form->createView(),
            'eintraege' => $entries
        ]);
    }

    /**
     * @Route("/info/newhaus", name="newhaus")
     */
    public function newHausAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTERED', null, 'Unable to access this page!');
        $row = 1;
        if (($handle = fopen("Häuserliste.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data);
                echo "<p> $num Felder in Zeile $row: <br /></p>\n";
                $row++;
                $haus = new Haus();
                $haus->setStrasse($data[0]);
                $haus->setHausNr($data[1]);
                $bewohner=base64_encode($data[2]); //encode the names of bewohner
                $haus->setBewohner($bewohner);
              for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($haus);
                $em->flush();
            }
            fclose($handle);
        }

        return new Response(
            '<html><body>Häuserliste wurde upgedatet!</body></html>'
        );
    }

    /**
     * @Route("/support", name="support")
     */
    public function supportAction(Request $request)
    {
        return $this->render('pages/support.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/datenschutz", name="datenschutz")
     */
    public function datenschutzAction(Request $request)
    {
        return $this->render('pages/datenschutz.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}

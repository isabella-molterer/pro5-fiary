<?php

namespace App\Controller;

use App\Entity\Fahrzeugbesatzung;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Choice;


class CraueFormFlowNewEntryController extends Controller
{
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    /**
     * @Route("/newcraueentry", name="newcraueentry")
     */
    public function createEntryAction() {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userId = $user->getId();

        $formData = new Logbuch();
        $formData->setIdbenutzerBenutzer($userId);

        $flow = $this->get('app.form.flow.createEntry'); // must match the flow's service id
        $flow->bind($formData);

        $repo=$this->getDoctrine()->getRepository(Haus::class);
        $häuser = $repo->findAll();

        $form = $flow->createForm(); // form of the current step

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                /* form for the next step */
                $form = $flow->createForm();
            } else {
                /* flow finished */
                $em = $this->getDoctrine()->getManager();                 
                $em->getRepository(Logbuch::class);
                $em->persist($formData);

                $array=$formData->getBesatzung();

                foreach($array as $entry){
                    if($entry->getIdmitgliederMitglieder() != NULL) {
                        $entry->setIdlogbuchLogbuch($formData);
                        $em->persist($entry);
                        $em->flush();
                    }
                }

                $em->flush();

                $flow->reset(); // reset form and remove data from the session

                return $this->redirectToRoute('homepage');
            }
        }
        if ($flow->redirectAfterSubmit($form)) {
            $request = $this->get('request_stack')->getCurrentRequest();
            $params = $this->get(
                'craue_formflow_util')->addRouteParameters(array_merge($request->query->all(), 
                $request->attributes->get('_route_params')), 
                $flow
            );
            return $this->redirect($this->generateUrl($request->attributes->get('_route'), $params));
        }

        return $this->render('Entry/createEntry.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
            'formData' => $formData,
            'unterKategorie' => Logbuch::getUnterKategorieOptions_Einsatz(),
            'unterunterKategorie' => Logbuch::getUnterKategorien_TechEinsatz(),
            'metadata' => $formData->getMetadata(),
            'weTTer' =>Logbuch::getWetterOptions(),
            'brandAusmass'=>Logbuch::getBrandausmassOptions(),
            'haeuser' =>$häuser,
        ));
    }
}

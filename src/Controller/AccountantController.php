<?php

namespace App\Controller;

use App\Entity\FeeSheet;
use App\Form\FeesheetType;
use App\Repository\StateRepository;
use App\Repository\FeeSheetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountantController extends AbstractController
{
    #[Route('/accountant/feesheet', name: 'app_accountant_feesheet')]
    public function index(EntityManagerInterface $em, FeeSheetRepository $feeSheetRepository, StateRepository $stateRepository, Request $request): Response
    {
        //Récupération des fiche de frais aevc l'état cloturée
        $stateCloturees = $stateRepository->find(2);
        $feesheetsCloturees = $feeSheetRepository->findBy(['state' => $stateCloturees]);

        //Formulaire Cloturation des fiches frais du mois dernier dont l'état est 'crée"
        $form = $this->createFormBuilder()
                    ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $date = new DateTime(date('Y-m-01 00:00:00'));
            $date->modify('-1 month');
            $stateCreate = $stateRepository->find(1);
            $feesheetsCreates = $feeSheetRepository->findBy(['date' => $date,'state' => $stateCreate]);
            foreach($feesheetsCreates as $feesheet)
            {
                $feesheet->setState($stateCloturees);
                $em->persist($feesheet);
                $em->flush();
            }
        }

        return $this->render('accountant/feesheet/index.html.twig', [
            'feesheetsCloturees' => $feesheetsCloturees,
            'form' => $form->createView()
        ]);
    }

    #[Route('/accountant/feesheet/{id<[0-9]+>}', name: 'app_accountant_feesheet_show')]
    public function show(FeeSheet $feesheet,Request $request, EntityManagerInterface $em, StateRepository $stateRepository): Response
    {

            $form = $this->createForm(FeesheetType::class, $feesheet, [
                'label'=> false
            ]);

            $form->handleRequest($request);

            // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 2 (cloturée).
            if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 2) {
                foreach($feesheet->getVariableFeesLines() as $variablefeesline){
                    //Calcul montant Valide

                    $variablefeesline->setFeesheet($feesheet);
                    $em->persist($variablefeesline);
                    $em->remove($variablefeesline);
                }   
                    $StateValid = $stateRepository->find(3);
                    $feesheet->setState($StateValid);
                    $em->persist($feesheet);
                    $em->flush();
                return $this->redirectToRoute('app_accountant_feesheet_show', ['id' => $feesheet->getId()]);
            }


        return $this->render('accountant/feesheet/show.html.twig', [
            'form' => $form->createView(),
            'feesheet' => $feesheet
        ]);
    }

    #[Route('/accountant/feesheet/follow-payment', name: 'app_accountant_feesheet_follow-payment')]
    public function all(EntityManagerInterface $em, FeeSheetRepository $feeSheetRepository, StateRepository $stateRepository, Request $request): Response
    {
         
        //Récupération des fiche de frais aevc l'état cloturée
        $stateValid = $stateRepository->find(3);
        $stateapayment = $stateRepository->find(4);
        $states34 = [$stateValid, $stateapayment];
        $feesheets = $feeSheetRepository->findBy(['state' => $states34]);

        return $this->render('accountant/feesheet/follow-payment.html.twig', [
            'feesheets' => $feesheets
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\FeeSheet;
use App\Form\FeesheetType;
use App\Repository\StateRepository;
use App\Repository\FeeSheetRepository;
use App\Repository\VariableFeesLineRepository;
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
        //Récupération des fiches de frais avec l'état 'cloturée'
        $stateCloturees = $stateRepository->find(2);
        $feesheetsCloturees = $feeSheetRepository->findBy(['state' => $stateCloturees]);

        //Formulaire Cloturation des fiches frais du mois dernier dont l'état est 'crée"
        $form = $this->createFormBuilder()
                     ->getForm()
        ;

        $form->handleRequest($request);


        // Si le formulaire est submit et valide on cloture les fiche frais du mois d'avant
        if($form->isSubmitted() && $form->isValid())
        {
            // Récupération des fiches frais de la date (mois actuel - 1) 
            $date = new DateTime(date('Y-m-01 00:00:00'));
            $date->modify('-1 month');
            $stateCreate = $stateRepository->find(1);
            $feesheetsCreates = $feeSheetRepository->findBy(['date' => $date,'state' => $stateCreate]);

            // On met les fiches frais à l'état cloturée
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
    public function show(FeeSheet $feesheet,Request $request, EntityManagerInterface $em, StateRepository $stateRepository, VariableFeesLineRepository $VariableFeesLineRepository): Response
    {   
            // Sécurité : Vérification si l'utilisateur veut afficher une fiche frais avec comme état 'Crée'
            // il sera redirigé vers sa page des fiches frais à valider
            if($feesheet->getState()->getId() === 1 ) {
                return $this->redirectToRoute('app_accountant_feesheet');
            }

            // Si la fiche frais est à l'état cloturée on crée le formulaire
            // Sinon on crée le formulaire sans les frais variable et frais standard
            if($feesheet->getState()->getId() === 2) {
                $form = $this->createForm(FeesheetType::class, $feesheet, [
                'label'=> false
                ]);
            }
            else {
                $form = $this->createForm(FeesheetType::class, $feesheet, [
                    'label'=> false
                ]);
                $form->remove('nbDocuments');
                $form->remove('validAmount');
                $form->remove('variablefeeslines');
                $form->remove('standardfeeslines');
            }
            

            $form->handleRequest($request);


            // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 2 (cloturée).
            if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 2) {
                //Traitement des valeurs pour les frais variable
                foreach($feesheet->getVariableFeesLines() as $variablefeesline){
                    $variablefeesline->setFeesheet($feesheet);
                    $em->persist($variablefeesline);
                    $em->remove($variablefeesline);
                }   
                // Passage de la fiche frais à l'état 'Validée'
                $StateValid = $stateRepository->find(3);
                $feesheet->setState($StateValid);

                $em->persist($feesheet);
                $em->flush();

                //redirection vers la page de détail du fiche frais
                return $this->redirectToRoute('app_accountant_feesheet_show', ['id' => $feesheet->getId()]);
            }

            // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 3 (Validé).
            if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 3) {
                // Passage de la fiche frais à l'état 'Mise en paiement'
                $StatePayment = $stateRepository->find(4);
                $feesheet->setState($StatePayment);

                $em->persist($feesheet);
                $em->flush();
                //redirection vers la page de détail du fiche frais
                return $this->redirectToRoute('app_accountant_feesheet_show', ['id' => $feesheet->getId()]);
            }

            // Si l'état de la fiche frais est 'cloturée' on affiche la vue 'Edit'
            // Sinon on affiche la vue 'View' qui permet d'afficher sans modifier
            if($feesheet->getState()->getId() === 2) {
                return $this->render('accountant/feesheet/showEdit.html.twig', [
                    'form' => $form->createView(),
                    'feesheet' => $feesheet
                ]);
            }
            else {
                return $this->render('accountant/feesheet/showView.html.twig', [
                    'form' => $form->createView(),
                    'feesheet' => $feesheet
                ]);
            }
    }

    #[Route('/accountant/feesheet/follow-payment', name: 'app_accountant_feesheet_follow-payment')]
    public function all(EntityManagerInterface $em, FeeSheetRepository $feeSheetRepository, StateRepository $stateRepository): Response
    {
        //Récupération des fiche de frais avec l'état 'Validée' et 'Mise en paiement'
        $stateValid = $stateRepository->find(3);
        $stateapayment = $stateRepository->find(4);
        $states34 = [$stateValid, $stateapayment];
        $feesheets = $feeSheetRepository->findBy(['state' => $states34]);
        
        // on affiche la vue follow-payment
        return $this->render('accountant/feesheet/follow-payment.html.twig', [
            'feesheets' => $feesheets
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\FeeSheet;
use App\Form\FeesheetType;
use App\Repository\StateRepository;
use App\Repository\FeeSheetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountantController extends AbstractController
{
    #[Route('/accountant/feesheet', name: 'app_accountant_feesheet')]
    public function index(FeeSheetRepository $feeSheetRepository, StateRepository $stateRepository): Response
    {
        $state = $stateRepository->find(2);
        $feesheetsCreates = $feeSheetRepository->findBy(['state' => $state]);
        return $this->render('accountant/feesheet/index.html.twig', [
            'feesheetsCreates' => $feesheetsCreates,
        ]);
    }

    #[Route('/accountant/feesheet/{id<[0-9]+>}', name: 'app_accountant_feesheet_show')]
    public function show(FeeSheet $feesheet,Request $request, EntityManagerInterface $em, StateRepository $stateRepository): Response
    {
        $form = $this->createForm(FeesheetType::class, $feesheet, [
            'label'=> false
            ]);

            $form->handleRequest($request);

            // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 1 (crée).
            if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 2) {
                
                //Calcul montant Valide
                $ValidAmount = 0;
                foreach($feesheet->getStandardFeesLines() as $standardfeesline) {
                    $ValidAmount = $ValidAmount + $standardfeesline->getQuantity() * $standardfeesline->getStandardFees()->getUnitAmount();
                }
                
                foreach($feesheet->getVariableFeesLines() as $variablefeesline){
                    //Calcul montant Valide
                    $ValidAmount = $ValidAmount + $variablefeesline->getAmount();

                    $variablefeesline->setFeesheet($feesheet);
                    $em->persist($variablefeesline);
                    $em->remove($variablefeesline);
                }   
                    $StateValid = $stateRepository->find(3);
                    $feesheet->setState($StateValid);
                    $feesheet->setValidAmount($ValidAmount);
                    $em->persist($feesheet);
                    $em->flush();
                return $this->redirectToRoute('app_accountant_feesheet_show', ['id' => $feesheet->getId()]);
            }


        return $this->render('accountant/feesheet/show.html.twig', [
            'form' => $form->createView(),
            'feesheet' => $feesheet
        ]);
    }
}

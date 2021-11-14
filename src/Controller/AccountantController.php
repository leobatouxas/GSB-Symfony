<?php

namespace App\Controller;

use App\Entity\FeeSheet;
use App\Form\FeesheetType;
use App\Repository\StateRepository;
use App\Repository\FeeSheetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountantController extends AbstractController
{
    #[Route('/accountant/feesheet', name: 'app_accountant_feesheet')]
    public function index(FeeSheetRepository $feeSheetRepository, StateRepository $stateRepository): Response
    {
        $state = $stateRepository->find(1);
        $feesheetsCreates = $feeSheetRepository->findBy(['state' => $state]);
        return $this->render('accountant/feesheet/index.html.twig', [
            'feesheetsCreates' => $feesheetsCreates,
        ]);
    }

    #[Route('/accountant/feesheet/{id<[0-9]+>}', name: 'app_accountant_feesheet_show')]
    public function show(FeeSheet $feesheet): Response
    {
        $form = $this->createForm(FeesheetType::class, $feesheet, [
            'label'=> false
            ]);


        return $this->render('accountant/feesheet/show.html.twig', [
            'form' => $form->createView(),
            'feesheet' => $feesheet
        ]);
    }
}

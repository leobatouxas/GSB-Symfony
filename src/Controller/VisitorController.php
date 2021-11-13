<?php

namespace App\Controller;

use App\Entity\FeeSheet;
use App\Entity\StandardFeesLine;
use App\Form\FeesheetType;
use App\Repository\FeeSheetRepository;
use App\Repository\StandardFeesRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VisitorController extends AbstractController
{
    #[Route('/visitor/feesheet', name: 'app_visitor_feesheet')]
    public function index(FeeSheetRepository $feeSheetRepository, Request $request, EntityManagerInterface $em, StateRepository $stateRepository, StandardFeesRepository $StandardFeesRepository): Response
    {
        //récupération de toutes les fiches frais
        $feesheets = $feeSheetRepository->findBy(['employee' => $this->getUser()]);

        $feesheet = new FeeSheet;
        $form = $this->createFormBuilder($feesheet)
                    ->add('date',DateType::class, ['days' => range(1,1), 'years' => range(Date('Y'), date('Y')), 'months' => range(Date('m') - 1, date('m'))])
                    ->getForm()
        ;

        $form->handleRequest($request);
       
        
        if($form->isSubmitted() && $form->isValid())
        {        
            // Verification si il existe déjà une fiche frais avec cette utilisateur et la même date
            if($feeSheetRepository->findOneBy(['date' => $form->getData()->getDate(),'employee' => $this->getUser()]) == null)
            {
                $feesheet->setNbDocuments(0);
                $feesheet->setValidAmount(0);
                $state = $stateRepository->findOneBy(['id' => 1]);
                $feesheet->setState($state); 
                $feesheet->setEmployee($this->getUser());
                $em->persist($feesheet);
                $em->flush();
                $AllstandardFees = $StandardFeesRepository->findAll();

                for($i = 0;$i<count($AllstandardFees);$i++)
                {
                    $standardfeesline = new standardfeesline();
                    $standardfeesline->setFeeSheet($feesheet);
                    $standardfeesline->setStandardFees($AllstandardFees[$i]);
                    $standardfeesline->setQuantity(0);
                    $em->persist($standardfeesline);
                    $em->flush();
                }


                $feesheetPrevMonth = $feeSheetRepository->findOneBy(['date' => $form->getData()->getDate()->modify('-1 month'), 'employee' => $this->getUser()]);

                if($feesheetPrevMonth != null)
                {
                    if($feesheetPrevMonth->getState()->getId() === 1)
                    {
                        $state2 = $stateRepository->findOneBy(['id' => 2]);
                        $feesheetPrevMonth->setState($state2);
                        $em->persist($feesheetPrevMonth);
                        $em->flush();
                    }
                }
                

                return $this->redirectToRoute('app_visitor_feesheet_show',['id' => $feesheet->getId()]);
                
            }
            else {
                return $this->redirectToRoute('app_visitor_feesheet');
            }
            
        }

        return $this->render('visitor/feesheet/index.html.twig', ['feesheets' => $feesheets, 'form' => $form->createView()]);
    }

    #[Route('/visitor/feesheet/{id<[0-9]+>}', name: 'app_visitor_feesheet_show')]
    public function show(FeeSheet $feesheet, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('FEESHEET_MANAGE', $feesheet);
        $form = $this->createForm(FeesheetType::class, $feesheet, [
            'label'=> false
            ]);
        
        $form->handleRequest($request);

        // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 1 (crée).
        if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 1) {
            foreach($feesheet->getVariableFeesLines() as $variablefeeslines){
                $variablefeeslines->setFeesheet($feesheet);
                $em->persist($variablefeeslines);
                $em->remove($variablefeeslines);
            }   
                $em->persist($feesheet);
                $em->flush();
            return $this->redirectToRoute('app_visitor_feesheet_show', ['id' => $feesheet->getId()]);
        }

        return $this->render('visitor/feesheet/show.html.twig', [
            'form' => $form->createView(),
            'feesheet' => $feesheet
        ]);
    }
}

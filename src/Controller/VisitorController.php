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
                    ->add('date',DateType::class, ['days' => range(1,1), 'years' => range(date('Y',strtotime('-1 months')), date('Y',strtotime('+1 months')))])
                    ->getForm()
        ;

        $form->handleRequest($request);
       
        
        if($form->isSubmitted() && $form->isValid())
        {        
            // Verification si il existe déjà une fiche frais avec cette utilisateur et la même date
            if($feeSheetRepository->findOneBy(['date' => $form->getData()->getDate(),'employee' => $this->getUser()]) == null)
            {
                //Récupération de la date actuelle
                $dateActu = new \DateTime();
                $dateActuelle = $dateActu->format('Y-m-d');
                
                $datedebut = date('Y-m-01', strtotime($dateActuelle. ' - 1 months'));  
                $dateFin = date('Y-m-01', strtotime($dateActuelle));

                // Récupération date du fomulaire et formatage de la date pour pouvoir
                // la comparer à la date de début et de fin
                $dateForm = $form->getData()->getDate();
                $dateForm = $dateForm->format('Y-m-d');

                // Si la date du formulaire est entre le mois d'avant 
                // et le mois actuelle on crée la fiche frais
                if($dateForm >= $datedebut && $dateForm <= $dateFin) {
                    $feesheet->setNbDocuments(0);
                    $feesheet->setValidAmount(0);
                    $state = $stateRepository->findOneBy(['id' => 1]);
                    $feesheet->setState($state); 
                    $feesheet->setEmployee($this->getUser());
                    $em->persist($feesheet);
                    $em->flush();
                    $AllstandardFees = $StandardFeesRepository->findAll();

                    // Création des frais forfaitaire automatique
                    for($i = 0;$i<count($AllstandardFees);$i++)
                    {
                        $standardfeesline = new standardfeesline();
                        $standardfeesline->setFeeSheet($feesheet);
                        $standardfeesline->setStandardFees($AllstandardFees[$i]);
                        $standardfeesline->setQuantity(0);
                        $em->persist($standardfeesline);
                        $em->flush();
                    }


                    // Traitement : Cloturation de la fiche frais du mois précédent

                    // On récupere la fiche frais du mois d'avant de c'elle crée
                    $feesheetPrevMonth = $feeSheetRepository->findOneBy(['date' => $form->getData()->getDate()->modify('-1 month'), 'employee' => $this->getUser()]);
                    
                    // S'il existe une fiche frais du mois d'avant et que l'état est 'Crée'
                    // on définis l'état de la fiche frais à cloturée
                    // et on la persiste en base de données
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
                
        }

        return $this->render('visitor/feesheet/index.html.twig', ['feesheets' => $feesheets, 'form' => $form->createView()]);
    }

    #[Route('/visitor/feesheet/{id<[0-9]+>}', name: 'app_visitor_feesheet_show')]
    public function show(FeeSheet $feesheet, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('FEESHEET_MANAGE', $feesheet);
        if($feesheet->getState()->getId() === 1) {
            $form = $this->createForm(FeesheetType::class, $feesheet, [
                'label'=> false
            ]);
            $form->remove('validAmount');
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

        // On verifie si le formulaire à était submit, valide et que l'état de la fiche de frais est équivalent à 1 (crée).
        if ($form->isSubmitted() && $form->isValid() && $feesheet->getState()->getId() === 1) {
            $dateActuelle = (new \DateTime())->format('Y-m-d');
            $date1years = date('Y-m-01', strtotime($dateActuelle. ' - 1 years'));
            $erreur = 0;
            foreach($feesheet->getVariableFeesLines() as $variablefeeslines){
                //Vérification côté serveur si la date est entre la date actuelle et 1 ans avant
                $date = $variablefeeslines->getDate()->format('Y-m-d');
                if (($date >= $date1years) && ($date <= $dateActuelle)){
                    $variablefeeslines->setFeesheet($feesheet);
                    $em->persist($variablefeeslines);
                    $em->remove($variablefeeslines);
                }else{
                    $erreur = 1;
                   //ERROR
                }
                
            }   
                if($erreur === 0) {
                    $em->persist($feesheet);
                    $em->flush();
                }
                
            return $this->redirectToRoute('app_visitor_feesheet_show', ['id' => $feesheet->getId()]);
        }

        if($feesheet->getState()->getId() === 1) {
            return $this->render('visitor/feesheet/showEdit.html.twig', [
                'form' => $form->createView(),
                'feesheet' => $feesheet
            ]);
        }
        else {
            return $this->render('visitor/feesheet/showView.html.twig', [
                'form' => $form->createView(),
                'feesheet' => $feesheet
            ]);
        }
    }
}

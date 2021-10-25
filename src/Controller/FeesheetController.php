<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\FeeSheet;
use App\Entity\StandardFeesLine;
use App\Entity\State;
use App\Entity\VariableFeesLine;
use App\Form\FeesheetType;
use App\Form\VariableFeesLineType;
use App\Repository\FeeSheetRepository;
use App\Repository\StandardFeesLineRepository;
use App\Repository\StandardFeesRepository;
use App\Repository\StateRepository;
use App\Repository\VariableFeesLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isNull;

class FeesheetController extends AbstractController
{
    #[Route('/feesheet', name: 'app_feesheet')]
    public function index(FeeSheetRepository $feeSheetRepository, Request $request, EntityManagerInterface $em, StateRepository $stateRepository, StandardFeesRepository $StandardFeesRepository): Response
    {
        
        //récupération de toutes les fiches frais
        $feesheets = $feeSheetRepository->findBy(['employee' => $this->getUser()]);

        $feesheet = new FeeSheet;
        $form = $this->createFormBuilder($feesheet)
                    ->add('date',DateType::class, ['days' => range(1,1)])
                    ->getForm()
        ;

        $form->handleRequest($request);
       
        
        if($form->isSubmitted() && $form->isValid())
        {
            dd($form);
            // Verification si 
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
                
                return $this->redirectToRoute('app_feesheet_show',['id' => $feesheet->getId()]);
                
            }
            else {
                return $this->redirectToRoute('app_feesheet');
            }
            
        }

        return $this->render('feesheet/index.html.twig', ['feesheets' => $feesheets, 'form' => $form->createView()]);
    }

    #[Route('/feesheet/{id<[0-9]+>/show}', name: 'app_feesheet_showe')]
    public function showe(FeeSheet $feesheet, StandardFeesLineRepository $standardFeesLineRepository, VariableFeesLineRepository $variableFeesLineRepository, Request $request, EntityManagerInterface $em): Response
    {
        //StandardFeesLine
        $standardFeesLines = $standardFeesLineRepository->findBy(['feeSheet' => $feesheet]);

        //update
        if($request->isMethod('POST') && isset($_POST['idStandardFeesLine']) == true) {
                $verif = 0;
                for($i=0;$i<count($standardFeesLines);$i++)
                {
                    if($standardFeesLines[$i]->getId() == $request->request->get('idStandardFeesLine'))
                    {
                        $verif = 1;
                    }
                }
                if($verif == 1)
                {
                    $standardFeesLine = $standardFeesLineRepository->findOneBy(['id'=> $request->request->get('idStandardFeesLine')]);
                    $standardFeesLine->setQuantity($request->request->get('quantity'));
                    $em->persist($standardFeesLine);
				    $em->flush();
                }    
        }

        //variablesFeesLines
        $variableFeesLines = $variableFeesLineRepository->findBy(['feeSheet' => $feesheet]);

        //create
        $VariableFeesLine = new VariableFeesLine;
        $form = $this->createFormBuilder($VariableFeesLine)
								 ->add('date', DateType::class)
								 ->add('name', TextType::class)
								 ->add('amount', NumberType::class)
								 ->getForm()
		;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $VariableFeesLine->setFeeSheet($feesheet);
            $em->persist($VariableFeesLine);
            $em->flush();
        }

        //update
        

        return $this->render('feesheet/showe.html.twig',[
            'feesheet' => $feesheet,
            'standardFeesLines' => $standardFeesLines,
            'variableFeesLines' => $variableFeesLines,
            'form' => $form->createView()
        ]);
    }



    #[Route('/feesheet/{id<[0-9]+>}', name: 'app_feesheet_show')]
    public function show(FeeSheet $feesheet, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FeesheetType::class, $feesheet, ['label'=> false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($feesheet);
            $em->flush();
        }

        return $this->render('feesheet/show.html.twig', [
            'form' => $form->createView(),
            'feesheet' => $feesheet
        ]);
    }
}

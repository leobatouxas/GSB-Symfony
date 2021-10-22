<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\FeeSheet;
use App\Entity\StandardFeesLine;
use App\Entity\State;
use App\Repository\FeeSheetRepository;
use App\Repository\StandardFeesLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeesheetController extends AbstractController
{
    #[Route('/feesheet', name: 'app_feesheet')]
    public function index(FeeSheetRepository $feeSheetRepository): Response
    {
        $feesheets = $feeSheetRepository->findBy(['employee' => $this->getUser()]);
        return $this->render('feesheet/index.html.twig', compact('feesheets'));
    }

    #[Route('/feesheet/create', priority: 10 , name: 'app_feesheet_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $feesheet = new FeeSheet;
        $form = $this->createFormBuilder($feesheet)
                    ->add('date', DateType::class)
                    ->add('nbDocuments',TextType::class)
                    ->add('validAmount', NumberType::class)
                    ->add('State', EntityType::class, [
                        'class' => State::class,
                        'choice_label' => function ($category) {
                            return $category->getName();
                        }
                    ])
                    ->add('Employee', EntityType::class, [
                        'class' => Employee::class,
                        'choice_label' => function ($category) {
                            return $category->getFirstname() . ' ' . $category->getLastName();
                        }
                    ])
                    ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($feesheet);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }


        return $this->render('feesheet/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/feesheet/{id<[0-9]+>}', name: 'app_feesheet_show')]
    public function show(FeeSheet $feesheet, StandardFeesLineRepository $standardFeesLineRepository): Response
    {
        $standardFeesLines = $standardFeesLineRepository->findBy(['feeSheet' => $feesheet]);
        return $this->render('feesheet/show.html.twig',compact('feesheet','standardFeesLines'));
    }
}

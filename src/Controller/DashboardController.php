<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {
        dump($request->getLocale());
        dump($request->getUser());
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
    
    
    /**
     * @Route("/changeLocale", name="changeLocale")
     */
    public function changeLocale(Request $request){
        $form=$this->createFormBuilder(null)
                ->add('locale',ChoiceType::class,[
                    'choices'=>[
                        "Francais"=>'fr_FR',
                        'Polish'=>'pl_PL',
                        'English(US)'=>'en_US',
                        'Deutsch'=>'de_DE'
                    ]
                ])
                    ->add('save',SubmitType::class) 
                    ->getForm()
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $locale=$form->getData()['locale'];
            $user=$this->getUser();
            $user->setLocale($locale);
            $em->persist($user);
            $em->flush();
        }
        
        
        return $this->render('dashboard/locale.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    
}

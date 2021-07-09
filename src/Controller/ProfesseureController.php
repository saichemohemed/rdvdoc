<?php

namespace App\Controller;
use App\Entity\PatientEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfesseureController extends AbstractController
{

  
    
    /**
     * @Route("/Professeur", name="Professeure")
     */
    public function Index():Response
    {

        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);
        
        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);

   
        return  $this->render('kbm/Page/Professeure.html.twig',[
            'notifications'=> $notification,
            'newdate'=> $newdate,
        ]);
    }
}

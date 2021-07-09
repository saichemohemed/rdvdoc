<?php

namespace App\Controller;
use App\Entity\Doctor;
use App\Entity\PatientEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DoctorController extends AbstractController
{

  
    
    /**
     * @Route("/Medcin", name="Doctors")
     */
  
    public function Index():Response
    {

        $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);



        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);

        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);


        return  $this->render('kbm/Page/Doctor.html.twig',[
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,


        ]);
    }
}

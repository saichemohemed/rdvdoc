<?php

namespace App\Controller;
use App\Entity\Doctor;
use App\Entity\PatientEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NeedController extends AbstractController
{
    /**
     * @Route("/Besoins", name="Need")
     */
    public function Need():Response
    {
        $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);


        //dump($notificationpat);
        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);

        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);


        return  $this->render('kbm/Page/Need.html.twig',[
             'notifications'=> $notification,
             'newdate'=> $newdate,
             'notifications_auj'=> $Rendez_vous_aujourdhui,
             'newdate1'=> $newdate1,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,


        ]);
    }
}

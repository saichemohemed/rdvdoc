<?php

namespace App\Controller;
use App\Entity\Doctor;
use App\Entity\PatientEvent;
use App\Entity\UserEvent;
use App\Entity\HospitalCenter;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DoctorBookingController extends AbstractController
{

  
    
    /**
     * @Route("/Medcin/Booking/{id}", name="Booking")
     */
  
    public function Index(Request $request ,$id):Response
    {
        $cookies = $request->cookies;
        dump( $cookies->get('date_rdv'));
        $datedep=$cookies->get('date_rdv');

        $date17 = new Cookie('date_rdv',$cookies->get('date_rdv'), strtotime('now + 10 minutes'));

        $doctorid= $this->getDoctrine()->getRepository(Doctor::class)->findById($id);

        $HospitalCenter = $this->getDoctrine()->getRepository(HospitalCenter::class)->findAll();

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

        $PatientEvents = $this->getDoctrine()->getRepository(PatientEvent::class)->findAll();

        $em = $this->getDoctrine()->getManager();
        $PatientEventTemp = $em->getRepository(UserEvent::class)->findAll();
        $workingtime=$PatientEventTemp;

        $response = $this->render('kbm/Page/DoctorBooking.html.twig',[
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            'doctors' => $doctorid,
            'HospitalCenters'=> $HospitalCenter,    
            'PatientEvents' => $PatientEvents,
            'workingtimes' => $workingtime,
            'datedep' => $datedep,

        ]);

        $response->headers->setCookie($date17);


        return $response;
    }
}

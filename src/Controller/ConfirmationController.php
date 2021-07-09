<?php


namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Calendar;
use App\Entity\HospitalCenter;
use App\Entity\UserEvent;
use App\Entity\PatternType;
use App\Entity\PatientEvent;
use App\Entity\Service;
use App\Form\PatientEvent1Type;
use Doctrine\ORM\EntityRepository;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PatientEventRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/rdv")
     */
class ConfirmationController extends AbstractController
{


    
    /**
     * @Route("/Confirmation/{id}/{heure}", name="Confirmation")
     */
    public function Index(Request $request ,EntityManagerInterface $em):Response
    {

        $repository = $this->getDoctrine()->getRepository(Doctor::class);
        //$cookie = new Cookie('doctor',$request->get('id'), strtotime('now + 10 minutes'));
        $cookies = $request->cookies;
        //dump( $cookies->get('date_rdv'));

        if ($request->get('id') == null) {
            $doctor = $repository->findOneById($cookies->get('id'));
            $ID = new Cookie('id', $cookies->get('id'), strtotime('+1 day'));
            $heure = new Cookie('heure', $cookies->get('heure'), strtotime('+1 day'));
            $date_rdv = new Cookie('date_rdv',$cookies->get('date_rdv'), strtotime('now + 10 minutes'));

        } else {
            $doctor = $repository->findOneById($request->get('id'));
            $ID = new Cookie('id', $request->get('id'), strtotime('+1 day'));
            $heure = new Cookie('heure',$request->get('heure'), strtotime('+1 day'));
            $date_rdv = new Cookie('date_rdv',$request->get('date_rdv'), strtotime('+1 day'));

        }

        
       //dump($doctor);
        $HospitalCenter = $this->getDoctrine()->getRepository(HospitalCenter::class)->findOneBy(['doctor'=>$doctor]);
       // dump($HospitalCenter);

  
        $LastName = new Cookie('LastName', $doctor->getLastName(), strtotime('now + 10 minutes'));
        $firstName = new Cookie('firstName', $doctor->getfirstName(), strtotime('now + 10 minutes'));
        $wilaya = new Cookie('wilaya', $HospitalCenter->getwilaya(), strtotime('now + 10 minutes'));
        $vill = new Cookie('vill', $HospitalCenter->gettown(), strtotime('now + 10 minutes'));
        $addres = new Cookie('address', $HospitalCenter->getaddress(), strtotime('now + 10 minutes'));
        $specialisation = new Cookie('specialisation', $doctor->getSpecialisation()->getName(), strtotime('now + 10 minutes'));
        $date_rdv = new Cookie('date_rdv',$cookies->get('date_rdv'), strtotime('now + 10 minutes'));
      
           // dump($doctor->getSpecialisation()->getName());
          // dump( $date_rdv);

       
      $test55 = $this->getDoctrine()->getRepository(PatternType::class)->findBy(['Doctor'=>$doctor]);
      //dump( $test55);
      $Motifs = [];
        foreach($test55 as $id=>$motif){
            array_push($Motifs,$motif->getMotif());    
        }

        $pat = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['patient'=>$this->getUser()]);
        //dump($pat[0]->getstartDatetime()->format('Y-m-d H:i'));
 

        $doct=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doct]);

        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doct]);

        $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);


       // dump($cookies->get('date_rdv'));
        //  dump($cookies->remove('PHPSESSID'));

        $val=$doctor->getspecialisation()->getid();
        $PatientEventRepository = $this->getDoctrine()->getRepository(Calendar::class);
        $p=$PatientEventRepository->findAllQueryBuilder($val);
       // dump($p[0]->getFgColor());
        //dump($p[0]->getbgColor());

        $patientEvent = new PatientEvent();
       $patientEvent->setDoctor($doctor)
        ->setPatient($this->getUser()) 
        ->setCalendar($p[0]) 
        ->setFgColor("#fff") 
        ->setBgColor($p[0]->getbgColor())
        ->setTypeRdv("waiting");

   

            $form = $this->createForm(PatientEvent1Type::class, $patientEvent);
            $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $date0= $form->get('startDatetime')->getData();
            //dump($date0);
            $date3= new \DateTime($date0->format('Y-m-d H:i:s'));
            $date1= new \DateTime($date0->format('Y-m-d H:i:s'));
            $datend= new \DateTime($date0->format('Y-m-d H:i:s'));
           $date3->add(new \DateInterval("PT1H"))->format('Y-m-d H:i');
           $date1->sub(new \DateInterval("PT1H"))->format('Y-m-d H:i');

            $daterdv=0;
            for ($i=0;$i<count($pat);$i++) {
                if (($pat[$i]->getstartDatetime()->format('Y-m-d H:i')>=$date1->format('Y-m-d H:i')) and ($pat[$i]->getstartDatetime()->format('Y-m-d H:i')<=$date3->format('Y-m-d H:i'))) {
                    $daterdv=$daterdv+1;

                } else {
                    $daterdv=$daterdv+0;
                }
            }
           // dump($daterdv);

            if($daterdv!=0){
                $this->addFlash('error', 'Impossible de prendre le RDV, vous avez déjà résérvé ce créneau !');
                return $this->redirectToRoute('Index', ['doctor' => $doctor->getSpecialisation()->getName(),'willaya'=>'','submit'=>'','page'=>'1']);

            }else{
                $motifid=$form->get('motifid')->getData();
                $motif2 = $this->getDoctrine()->getRepository(PatternType::class)->findOneBy(['Motif'=>$motifid]);
                $entityManager = $this->getDoctrine()->getManager();
                $patientEvent->setMotif($motif2);
                $patientEvent->setendDatetime($datend->add(new \DateInterval("PT1H")));
                $patientEvent->setupdatedate(new \DateTime());
                $patientEvent->setNumberOfChangePatient(0);
                $patientEvent->setNumberOfChangeDoctor(0);
                $entityManager->persist($patientEvent);
                $entityManager->flush();
                
                $this->addFlash('success', 'le rendez vous et ajoute avec Succès');
                //$this->addFlash('success', 'le rendez vous est en attente');

                return $this->redirectToRoute('patient_appointment_waiting');
            }
        }
        

        $response = $this->render('kbm/Page/Confirmation.html.twig', [
            'LastName' => $LastName,
            'firstName' => $firstName,
            'wilaya' => $wilaya,
            'vill' => $vill,
            'addres' => $addres,
            'Motifs' => $Motifs,
           'specialisation' => $specialisation,
            'cookies' => $cookies,
            'heure' =>$heure,
            'date_rdv'=>$date_rdv,
            'patient_event' => $patientEvent,
            'form' => $form->createView(),
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            

        ]);
        //$response->headers->setCookie($LastName);
        // $response->headers->setCookie(new Cookie('id', $ID, time() + 3600));
        $response->headers->setCookie($ID);
        $response->headers->setCookie($heure);
        $response->headers->setCookie($date_rdv);
        //dump($cookies->get('date_rdv'));

        return $response;
    }



    /**
     * @Route("/appointment ", name="patient_appointment", methods={"GET"})
     */
    public function rdv(PatientEventRepository $patientEventRepository): Response
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


       $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);


        $Specialisation = $this->getDoctrine()->getRepository(Service::class)->findall();
        //dump($Specialisation);

        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');        
        return $this->render('kbm/Page/ConfirmationAppointment.html.twig', [
            'newdate1'=> $newdate1,
            'notifications'=> $notification,
            'Specialisation'=> $Specialisation,
            'newdate'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
                'patient_events' => $patientEventRepository->findBy(
                ['patient'=>$this->getUser()->getId(),'TypeRdv'=>'confirmed'], 
                ['id'=>'DESC']
            
            ),
        ]);
    }


    /**
     * @Route("/appointment/waiting ", name="patient_appointment_waiting", methods={"GET"})
     */
    public function rdv_waiting(PatientEventRepository $patientEventRepository): Response
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


       $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]); 

        $patient_events = $patientEventRepository->findBy(
            ['patient'=>$this->getUser()->getId(),'TypeRdv'=>'waiting'], 
            ['id'=>'DESC']);

             $Specialisation = $this->getDoctrine()->getRepository(Service::class)->findall();
            // dump($Specialisation);

        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');        
        return $this->render('kbm/Page/ConfirmationAppointmentWaiting.html.twig', [
            'newdate1'=> $newdate1,
            'Specialisation'=> $Specialisation,
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'patient_events' => $patient_events
            
            
        ]);
    }



    /**
       * @Route("/{id}", name="patient_show", methods={"GET"})
       */
    public function show(PatientEvent $patientEvent): Response
    {
       $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);

        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]); 

        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);


        return $this->render('kbm/Page/ConfirmationShow.html.twig', [
            'patient_event' => $patientEvent,
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
        ]);
    }


        /**
        * @Route("/{id}/edit", name="patient_edit", methods={"GET","POST"})
        */
        
    public function edit(Request $request, PatientEvent $patientEvent): Response
    {


        $form = $this->createForm(PatientEvent1Type::class, $patientEvent);
        $doctor=$patientEvent->getdoctor();
        $form->add('motif', EntityType::class,       
        array('class' => 'App:PatternType',
        'choice_label' => 'Motif',
        'query_builder' => function (EntityRepository $er) use($doctor) {
            return $er->createQueryBuilder('s')
                      ->where('s.Doctor = :doctor')
                      ->setParameter('doctor', $doctor);
        },
        
        'multiple' => false,
        'expanded' => false,
        'required' => true,
        )
        );
        $form->handleRequest($request);
        $startDatetime=$patientEvent->getstartDatetime();
        //dump($doctor);

        $PatientEvents = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['doctor'=>$doctor]);
       // dump($PatientEvents);


          $em = $this->getDoctrine()->getManager();
          $PatientEventTemp = $em->getRepository(UserEvent::class)->findBy(['Doctor'=>$doctor]);
          $workingtime=$PatientEventTemp;
         // dump($workingtime);
  
          $doctor=$this->getUser();
          $newdate1=new \DateTime();
          $newdate1->format('Y-m-d');
          $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);


        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);
  
        $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);


        if ($form->isSubmitted() && $form->isValid()) {

            $em =  $this->getDoctrine()->getManager();
            $PatientEvent = $em->getRepository(patientEvent::class)->find($patientEvent->getId());
            $PatientEvent
            ->setTypeRdv("waiting")
            ->setNumberOfChangeDoctor(0)
            ->setNumberOfChangePatient(1);
            $em->flush();
            $this->addFlash('success', 'le rendez vous et modifier avec Succès');
            return $this->redirectToRoute('patient_appointment_waiting');
        }
        $HospitalCenter = $this->getDoctrine()->getRepository(HospitalCenter::class)->findAll();

        $Specialisation = $this->getDoctrine()->getRepository(Service::class)->findall();
        //dump($Specialisation);


        return $this->render('kbm/Page/ConfirmationEdit.html.twig', [
            'PatientEvents' => $PatientEvents,
            'patient_event' => $patientEvent,
            'Specialisation'=> $Specialisation,
            'form' => $form->createView(),
            'workingtimes' => $workingtime,
            'startDatetime' => $startDatetime,
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            'HospitalCenters'=> $HospitalCenter,    

        ]);
    }
    
    /**
        * @Route("/{id}", name="patient_delete", methods={"DELETE"})
        */
    public function delete(Request $request, PatientEvent $patientEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patientEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patientEvent);
            $entityManager->flush();
            return $this->redirectToRoute('patient_appointment');

        }
    return $this->render('kbm/Page/ConfirmationDeleteForm.html.twig');

    }
}


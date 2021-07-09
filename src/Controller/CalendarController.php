<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Form\MotifType;
use App\Entity\Calendar;
use App\Entity\UserEvent;
use App\Entity\PatternType;
use App\Entity\PatientEvent;
use App\Entity\TreatingDoctor;
use App\Form\PatientEventType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PatientEventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{

  
    /**
     * @Route("/calendar", name="calendar")
     */

    public function Index(EntityManagerInterface $em, Request $request):Response
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

        $form = $this->createForm(PatientEventType::class);
        $form->handleRequest($request);

        $cal = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$this->getUser()]);


        //dump($this->getUser()->getspecialisation()->getid());
        $val=$this->getUser()->getspecialisation()->getid();
        $PatientEventRepository = $this->getDoctrine()->getRepository(Calendar::class);
        $p=$PatientEventRepository->findAllQueryBuilder($val);
//  $val="momoh";
//  $patient= $this->getDoctrine()->getRepository(Patient::class);
//  dump($pat=$patient->findAllQueryBuilder($val));
 //dump($cal);
// dump($date->add(new \DateInterval("PT1H")));

$id=$this->getUser();
$em = $this->getDoctrine()->getManager();
$PatientEventTemp = $em->getRepository(Doctor::class)->findBy(['id'=>$id]);
$workingtime=$PatientEventTemp[0]->getworkingtime();



        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PatientEvent 
             * $PatientEvent 
             *
             */


            $motifid=$form->get('motifid')->getData();
            $motif2 = $this->getDoctrine()->getRepository(PatternType::class)->findOneBy(['Motif'=>$motifid]);
            $patient= $this->getDoctrine()->getRepository(Patient::class);
            $username=$form->get('username')->getData();
            $motif=$form->get('motifid')->getData();
            $date=$form->get('startDatetime')->getData();
            $date2= new \DateTime($date->format('Y-m-d H:i:s'));
             //dump($date);
            // dump($date2);
            // dump($date2->add(new \DateInterval("PT2H")));
            $pat=$patient->findAllQueryBuilder($username);

            $PatientEvent = $form->getData()
                        ->setDoctor($this->getUser())
                        ->settitle($pat[0]->getfirstName().' '.$pat[0]->getlastName().' '.$motif)
                        ->setpatient($pat[0])
                        ->setCalendar($p[0])
                        ->setMotif($motif2)
                        ->setupdatedate(new \DateTime())
                        ->setBgColor($p[0]->getbgColor())
                        ->setfgColor('#fff')
                        ->setNumberOfChangePatient(0)
                        ->setNumberOfChangeDoctor(0)
                        ->setendDatetime($date2->add(new \DateInterval("PT1H")))
                        ->setTypeRdv("confirmed");
                        
            
            $em->persist($PatientEvent);
            $em->flush();
    
            $this->addFlash('success', 'le rendez vous et ajoute avec Succès');
            return $this->redirectToRoute("calendar");

        }
      
        $doctor=$this->getUser();
        $test55 = $this->getDoctrine()->getRepository(PatternType::class)->findBy(['Doctor'=>$doctor]);
        //dump( $test55);
        $Motifs = [];
          foreach($test55 as $id=>$motif){
              array_push($Motifs,$motif->getMotif());    
          }
          $form2 = $this->createForm(MotifType::class);
          $form2->handleRequest($request);
  
          


    return  $this->render('fullcalendar/calendar.html.twig',[
        'form' => $form->createView(),
        'cals'=> $cal,
        'test'=>"calendar",
        'Motifs'=>$Motifs,
        'workingtime'=>$workingtime,
        'notifications'=> $notification,
        'newdate'=> $newdate,
        'notifications_auj'=> $Rendez_vous_aujourdhui,
        'newdate1'=> $newdate,
        'newdatepat'=> $newdatepat,
        'notificationpats'=> $notificationpat,


    ]);
    }


    /**
     * @Route("/notification", name="notification")
     */
    public function notification(Request $request)
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
        //dump(count ($notification));


        //dump($notification);

        return  $this->render('kbm/Page/DoctorAppointment.html.twig',[
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
            

    
    
        ]);
    }


    
    /**
     * @Route("/Rendez-vous_aujourd'hui", name="Rendez-vous_aujourdhui")
     */
    public function AppointmentPatient(Request $request)
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

//         dump(count ($Rendez_vous_aujourdhui));

        
// for($i =0;$i<count ($Rendez_vous_aujourdhui);$i++){
//     $date=$Rendez_vous_aujourdhui[$i]->getstartDatetime()->format('Y-m-d') ;
//     dump($date);
//     $newdate=new \DateTime();
//     dump($newdate->format('Y-m-d'));

// }

        return  $this->render('kbm/Page/AppointmentPatient.html.twig',[
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
    
    
        ]);
    }


    /**
     * @Route("/ajax_edit", name="ajax_edit")
     */
    public function edit(Request $request)
    {
        $dateaa = $request->get('datea');
dump($dateaa);
        $motif2 = $this->getDoctrine()->getRepository(PatternType::class)->findOneBy(['Motif'=>$motif]);
        $id = $request->get('id');
        $title = $request->get('title');
        $dater = $request->get('dater');
        $newDate = new \DateTime( $dater);

        $em = $this->getDoctrine()->getManager();
        $PatientEvent = $em->getRepository(PatientEvent::class)->find($id);
 

            $PatientEvent 

            ->settitle($title ) 
            ->setStartDatetime($newDate)
            ->setNumberOfChangeDoctor(1)
            ->setmotif( $motif2);
            $em->flush();
          
    
                    $response = new Response(json_encode(array($id,$title,$motif,$dater)));
                    $response->headers->set('Content-Type', 'application/json');
                    
                    return $response;   

    }

        
    /**
     * @Route("/ajax_Delete", name="ajax_Delete")
     */

    public function ajaxDeleteItem(Request $request)
    {
    
        
            $id = $request->get('id');
         
            $em = $this->getDoctrine()->getManager();
            $PatientEvent = $em->getRepository(PatientEvent::class)->find($id);
            $PatientEvent ->setTypeRdv("cancel");
            $em->flush();
    
           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
        //return new JsonResponse('good');
      
    }

    /**
     * @Route("/ajax_accepte", name="ajax_accepte")
     */

    public function ajaxaccepteItem(Request $request)
    {
    
        
            $id = $request->get('id');
         
             $em = $this->getDoctrine()->getManager();
             $PatientEvent  = $em->getRepository(PatientEvent::class)->find($id);
             $PatientEvent ->setTypeRdv("confirmed");
             $em->flush();
             $this->addFlash('success', 'le rendez vous accepte avec succès');

           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
      
    }

        /**
     * @Route("/ajax_annuler", name="ajax_annuler")
     */

    public function ajaxannulertem(Request $request)
    {
    
        
            $id = $request->get('id');
            //$id=166;

             $em = $this->getDoctrine()->getManager();
             $PatientEvent  = $em->getRepository(PatientEvent::class)->find($id);
             $PatientEvent ->setTypeRdv("cancel");
             $em->flush();
             $this->addFlash('error', 'le rendez vous annuler avec succès');

           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
      
    }

    /**
     * @Route("/ajax_edit_hure", name="ajax_edit_hure")
     */
    public function edit_hure(Request $request)
    {
 
        $id = $request->get('id');
        $hure_date_deb = $request->get('hure_date_deb');
        $hure_date_deb = new \DateTime( $hure_date_deb);
        $hure_date_fin = $request->get('hure_date_fin');
        $hure_date_fin = new \DateTime( $hure_date_fin);
        $title = $request->get('hure_titel');

        $em = $this->getDoctrine()->getManager();
        $PatientEvent = $em->getRepository(UserEvent::class)->find($id);
 

            $PatientEvent 

            ->settitle($title) 
            ->setstartDatetime($hure_date_deb)
            ->setendDatetime( $hure_date_fin);
            $em->flush();
          
    
                    $response = new Response(json_encode(array($id,$title,$hure_date_fin,$hure_date_deb)));
                    $response->headers->set('Content-Type', 'application/json');
                    
                    return $response;   

    }

       
   
    /**
     * @Route("/ajax_Delete_hure", name="ajax_Delete_hure")
     */

    public function ajaxDeleteItem_hure(Request $request)
    {
    
        
            $id = $request->get('id');
         
            $em = $this->getDoctrine()->getManager();
            $PatientEvent = $em->getRepository(UserEvent::class)->find($id);
            $em->remove($PatientEvent);
            $em->flush();
            $this->addFlash('success', 'La suppression est terminée avec succès');
           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
        //return new JsonResponse('good');
      
    }


    /**
     * @Route("/ajaxDeleteMotif", name="ajaxDeleteMotif")
     */

    public function ajaxDeleteMotif(Request $request)
    {
    
        
           // $id = $request->get('id');
            $motif = $request->get('motif');
            $id = $request->get('id');

            $em = $this->getDoctrine()->getManager();
            $PatternType = $em->getRepository(PatternType::class)->findBy(['Doctor'=>$id,'Motif'=>$motif]);
            $sup = $PatternType[0]->getid();


            $em = $this->getDoctrine()->getManager();
            $PatternType = $em->getRepository(PatternType::class)->find($sup);
            $em->remove($PatternType);
            $em->flush();
            $this->addFlash('success', 'La suppression est terminée avec succès');
           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
      
    }
   


    /**
     * @Route("/username_exists_note", name="username_exists_note")
     */
    public function username_exists(Request $request)
    {
        $username_rend = $request->get('username_email_phone');
       
                        
        $em = $this->getDoctrine()->getManager();
        $User = $em->getRepository(Patient::class)->findAll();

        $username = [];
        foreach($User as $id => $usernameExists){
            array_push($username,$usernameExists->getUsername());    
        }

        $email = [];
        foreach($User as $id => $emailExists){
            array_push($email,$emailExists->getEmail());    
        };

        $phone = [];
        foreach($User as $id => $phoneExists){
            array_push($phone,$phoneExists->getPhone());    
        };


        $username_email_phone ="Ce nom n'est pas un nom d'utilisateur, ce n'est pas un numéro de téléphone, ni un e-mail Ou pas un patient.";

            if (in_array($username_rend, $username) or in_array($username_rend, $email) or in_array($username_rend, $phone) ) {
                $username_email_phone ="";
            };
 

                    $response = new Response(json_encode(array($username_email_phone)));
                    $response->headers->set('Content-Type', 'application/json');
                    
                    return $response;   

    }






}

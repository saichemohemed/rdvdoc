<?php

namespace App\Controller;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Calendar;
use App\Entity\UserEvent;
use App\Form\UserEventType;
use App\Entity\PatientEvent;
use App\Repository\PatientRepository;
use App\Repository\UserEventtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class hourController extends AbstractController
{

  
    /**
     * @Route("/hour", name="hour")
     */
   

    public function Index(EntityManagerInterface $em, Request $request):Response
    {


        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);

        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);

        $form = $this->createForm(UserEventType::class);
        $form->handleRequest($request);
        //dump($this->getUser());
        $cal = $this->getDoctrine()->getRepository(UserEvent::class)->findBy(['Doctor'=>$this->getUser()]);
        //dump($cal);

        $id=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $PatientEventTemp = $em->getRepository(Doctor::class)->findBy(['id'=>$id]);
        $workingtime=$PatientEventTemp[0]->getworkingtime();
        //dump($PatientEventTemp);


$val=$this->getUser()->getspecialisation()->getid();
//dump($val);

$PatientEventRepository = $this->getDoctrine()->getRepository(Calendar::class);
$p=$PatientEventRepository->findAllQueryBuilder($val);
//dump($p);
        if ($form->isSubmitted() && $form->isValid()) {
            $UserEvent = $form->getData();
            //dump($UserEvent->getstartDatetime()->format('Y-m-d l w'));

            $period=$form->get('period')->getData();
            $week=$form->get('week')->getData();
            //dump($week);
            //dump($period);
            //die();
            $start1=$UserEvent->getstartDatetime()->format('Y-m-d H:i');
            $startDatetime=$UserEvent->getstartDatetime()->format('l');
            //$date1= new \DateTime($UserEvent->getendDatetime()->format('Y-m-d H:i'));

            //dump($start1);
            //dump($startDatetime);
            
            
            for ($j=0;$j<count($week);$j++) {
 
                for ($i=1;$i<7;$i++) {
                    $date2= new \DateTime($UserEvent->getstartDatetime()->format('Y-m-d H:i'));
                    $date2->add(new \DateInterval("P".$i."D"));
                    $date1= new \DateTime($UserEvent->getendDatetime()->format('Y-m-d H:i'));
                    $date1->add(new \DateInterval("P".$i."D"));

                    if($week[$j] == $date2->format('l') ){
                        // dump($week[$j]);
                        // dump($date2);
                        // dump($date1);
                        $UserEvent1 = new UserEvent();
                        $UserEvent1->setstartDatetime($date2);
                        $UserEvent1->setendDatetime($date1);
                        $UserEvent1->setDoctor($this->getUser());
                        $UserEvent1->setbgColor($UserEvent->getbgColor());
                        $UserEvent1->setfgColor($UserEvent->getfgColor());
                        $UserEvent1->settitle($UserEvent->gettitle());
                        $em->persist($UserEvent1);
                        $em->flush();
                    }
                    

                }
            }

                        for ($j=1;$j<$period;$j++) {
                    //$date2= new \DateTime($UserEvent->getstartDatetime()->format('Y-m-d H:i'));
                    $date1= new \DateTime($UserEvent->getendDatetime()->format('Y-m-d H:i'));
                    $date1->add(new \DateInterval("P".$j."D"));

                    //dump($date1);die();
                                $date2= new \DateTime($UserEvent->getstartDatetime()->format('Y-m-d H:i'));
                                $date2->add(new \DateInterval("P".$j."D"));

                                $UserEvent1 = new UserEvent();
                                $UserEvent1->setstartDatetime($date2);
                                $UserEvent1->setendDatetime($date1);
                                $UserEvent1->setDoctor($this->getUser());
                                $UserEvent1->setbgColor($UserEvent->getbgColor());
                                $UserEvent1->setfgColor($UserEvent->getfgColor());
                                $UserEvent1->settitle($UserEvent->gettitle());
                                $em->persist($UserEvent1);
                                $em->flush();
                            
                    

                }
            
                
                $UserEvent->setCalendar($p[0]);
                $UserEvent->setDoctor($this->getUser());
                $em->persist($UserEvent);
                $em->flush();
    
                $this->addFlash('success', 'success');
                return $this->redirectToRoute("hour");
            }
      
            return  $this->render('fullcalendar/calendar.html.twig', [
        'form' => $form->createView(),
        'cals'=> $cal,
        'test'=>"les horaires de travail",
        'workingtime'=>$workingtime,
        'notifications'=> $notification,
        'newdate'=> $newdate,
        'notifications_auj'=> $Rendez_vous_aujourdhui,
        'newdate1'=> $newdate,


    ]);
        }
    

/**
     * @Route("/ajax_Temp", name="ajax_Temp")
     */
    public function edit_Temp(Request $request)
    {

        $Temp = $request->get('Temp');
        $id=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $PatientEventTemp = $em->getRepository(Doctor::class)->find($id);
 

            $PatientEventTemp 
            ->setWorkingtime($Temp ) ;
            $em->flush();
          
    
                    $response = new Response(json_encode(array($Temp,$id)));
                    $response->headers->set('Content-Type', 'application/json');
                    
                    return $response;   

    }




}

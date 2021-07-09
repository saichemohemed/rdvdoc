<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Calendar;
use App\Entity\PatternType;
use App\Entity\PatientEvent;
use App\Entity\RemindingEvent;
use App\Form\RemindingEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class NoteController extends AbstractController
{
    /**
     * @Route("/note", name="note")
     */
    public function index(EntityManagerInterface $em, Request $request):Response
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

        $id=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $PatientEventTemp = $em->getRepository(Doctor::class)->findBy(
            ['id'=>$id]
        );
        $workingtime=$PatientEventTemp[0]->getworkingtime();

        $val=$this->getUser()->getspecialisation()->getid();
        $PatientEventRepository = $this->getDoctrine()->getRepository(Calendar::class);
        $p=$PatientEventRepository->findAllQueryBuilder($val);


        $form = $this->createForm(RemindingEventType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RemindingEvent 
             * $evenement 
             *
             */
            $username=$form->get('username')->getData();
            $body=$form->get('body')->getData();
            $patient= $this->getDoctrine()->getRepository(Patient::class);
            $pat=$patient->findAllQueryBuilder($username);

            
            $RemindingEvent = $form->getData()
                       ->setBgColor($p[0]->getbgColor())
                       ->setfgColor('#fff')
                       ->setDoctor($this->getUser())
                       ->setcalendar($p[0]);
                       if($username != null){
                        $RemindingEvent->setpatient($pat[0])
                        ->settitle($pat[0]->getfirstName().' '.$pat[0]->getlastName().' '.$body);

                    }else{
                        $RemindingEvent->settitle($body);
                    }

            $em->persist($RemindingEvent);
            $em->flush();
    
            $this->addFlash('success', 'la note est ajouté avec succès');
            return $this->redirectToRoute('note');
        }

        $cal = $this->getDoctrine()->getRepository(RemindingEvent::class)->findBy(['Doctor'=>$this->getUser()]);
//dump($cal);

        return $this->render('fullcalendar/calendar.html.twig',[
        'form' => $form->createView(),
        'cals'=> $cal,
        'workingtime'=>$workingtime,
        'test'=>"note",
        'notifications'=> $notification,
        'newdate'=> $newdate,
        'notifications_auj'=> $Rendez_vous_aujourdhui,
        'newdate1'=> $newdate,
        
        

    ]);
    }


    /**
     * @Route("/ajax_edit_note", name="ajax_edit_note")
     */
    public function edit_note(Request $request)
    {
 
        $id = $request->get('id');
        $note_date_deb = $request->get('note_date_deb');
        $note_date_deb = new \DateTime( $note_date_deb);
        $note_date_fin = $request->get('note_date_fin');
        $note_date_fin = new \DateTime( $note_date_fin);
        $body = $request->get('body');
        $statu = $request->get('statu');

        $em = $this->getDoctrine()->getManager();
        $RemindingEvent = $em->getRepository(RemindingEvent::class)->find($id);
 

            $RemindingEvent 

            ->setBody($body) 
            ->setState($statu)
            ->settitle($body)
            ->setstartDatetime($note_date_deb)
            ->setendDatetime( $note_date_fin);
            $em->flush();
          
    
                    $response = new Response(json_encode(array($id,$body,$statu,$note_date_fin,$note_date_deb)));
                    $response->headers->set('Content-Type', 'application/json');
                    
                    return $response;   

    }

       
   
    /**
     * @Route("/ajax_Delete_note", name="ajax_Delete_note")
     */

    public function ajaxDeleteItem_hure(Request $request)
    {
    
        
            $id = $request->get('id');
         
            $em = $this->getDoctrine()->getManager();
            $RemindingEvent = $em->getRepository(RemindingEvent::class)->find($id);
            $em->remove($RemindingEvent);
            $em->flush();
            $this->addFlash('success', 'La suppression est terminée avec succès');
           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
        //return new JsonResponse('good');
      
    }










}





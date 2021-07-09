<?php

namespace App\Controller;
use App\Entity\PatientEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class HeaderController extends AbstractController
{

  
    
    /**
     * @Route("/Header", name="Header")
     */
    public function Index():Response
    {
        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);

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
   
        return  $this->render('kbm/include/Header.html.twig',[
            'notifications'=> $notification,
            'newdate'=> $newdate, 
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,
                   ]);
    }


    /**
     * @Route("/annuler", name="annuler")
     */

    public function ajaxannu(Request $request)
    {
    
            $id = $request->get('id');
            //$id=166;

             $em = $this->getDoctrine()->getManager();
             $PatientEvent  = $em->getRepository(PatientEvent::class)->find($id);
             $PatientEvent ->setTypeRdv("cancel");
             $em->flush();
           $response = new Response(json_encode(array($id)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
      
    }



}

<?php

namespace App\Controller;

use App\Entity\PatientEvent;
use App\Entity\HospitalCenter;
use App\Form\HospitalCenterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HospitalCenterController extends AbstractController
{

    /**
     * @Route("/hospital/center/", name="hospital_center")
     */
    public function index(EntityManagerInterface $em, Request $request ,\Swift_Mailer $mailer ):Response
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



        $HospitalCenter = $this->getDoctrine()->getRepository(HospitalCenter::class)->findOneBy(['doctor'=>$doctor]);
        $form = $this->createForm(HospitalCenterType::class,$HospitalCenter);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var HospitalCenter 
             * $HospitalCenter 
             *
             */

            $HospitalCenter = $form->getData();
            $HospitalCenter->setUpdateDate(new \DateTime());
            $em->persist($HospitalCenter);
            $em->flush();

            $message = (new \Swift_Message('Hello Email'))
            ->setSubject('Bonjour mohamed ')
            ->setFrom('mohamedsaiche.kbm@gmail.com')
            ->setTo('saiche.mohamed@gmail.com')
            ->setBody('test')
            ;
             $mailer->send($message);



             $this->addFlash('success', 'la modification de hopitale ést mis à jour avec succès');
            return $this->redirectToRoute('hospital_center');
        }



        return $this->render('kbm/Page/HospitalCenter.html.twig', [
            'form' => $form->createView(),
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'newdate'=> $newdate,
            'newdatepat'=> $newdatepat,
            ]);
    }




    
}
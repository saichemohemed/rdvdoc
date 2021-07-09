<?php

namespace App\Controller;

use App\Form\MotifType;
use App\Entity\PatternType;
use App\Entity\PatientEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PatternController extends AbstractController
{
    /**
     * @Route("/pattern", name="pattern")
     */
    public function Index(EntityManagerInterface $em, Request $request):Response
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

        $doctor=$this->getUser();
        $test55 = $this->getDoctrine()->getRepository(PatternType::class)->findBy(['Doctor'=>$doctor]);
        //dump( $test55);
        $Motifs = [];
          foreach($test55 as $id=>$motif){
              array_push($Motifs,$motif->getMotif());    
          }
          $form2 = $this->createForm(MotifType::class);
          $form2->handleRequest($request);
  
          

          if ($form2->isSubmitted() && $form2->isValid()) {
            /** @var PatternType 
             * $PatternType 
             *
             */

            $motif = $form2->getData()
            ->setDoctor($this->getUser());
            $em->persist($motif);
            $em->flush();
        

            $this->addFlash('success', 'le motif est ajouté avec succès');
            return $this->redirectToRoute("pattern");

            }

        return  $this->render('kbm/Page/pattern.html.twig',[
             'notifications'=> $notification,
             'newdate'=> $newdate,
             'form2' => $form2->createView(),
             'Motifs'=>$Motifs,
             'notifications_auj'=> $Rendez_vous_aujourdhui,
             'newdate1'=> $newdate1,
            'newdatepat'=> $newdatepat,
            'notificationpats'=> $notificationpat,


        ]);
    }
}

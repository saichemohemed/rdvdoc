<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\PatientEvent;
use App\Entity\TreatingDoctor;
use App\Entity\MedicalPersonalHistory;
use App\Form\MedicalPersonalHistoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedicalPersonalHistoryController extends AbstractController
{
    /**
     * @Route("/DossierPatient/{id}", name="medical_personal_history")
     */
    public function index(EntityManagerInterface $em, Request $request , $id ):Response
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

        
            //$id = $request->get('id');
            $idPate =$id;
            $em = $this->getDoctrine()->getManager();
            $Patient=$em->getRepository(Patient::class)->findOneById($id);
            dump($Patient);

            $MedicalPersonalHistory=$em->getRepository(MedicalPersonalHistory::class)->findOneById($Patient->getmedicalPersonalHistory());

        //dump($MedicalPersonalHistory);
        $form = $this->createForm(MedicalPersonalHistoryType::class,  $MedicalPersonalHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le Antécédents médicaux mise à jour avec succès');

            return $this->redirectToRoute('calendar');
        }



        $em = $this->getDoctrine()->getManager();
        $Treating=$em->getRepository(TreatingDoctor::class)->findBy(['Patient'=>$id]);
//dump($Treating);
$Treatings = [];
foreach($Treating as $id=>$Treating){
    array_push($Treatings,$Treating->getDoctor()->getfirstName().' '. $Treating->getDoctor()->getlastName().' '.$Treating->getDoctor()->getSpecialisation()->getdescription() );    
}

//dump($Treatings);

        return $this->render('kbm/Page/medical_personal_history.html.twig', [
            'form' => $form->createView(),
            'notifications'=> $notification,
            'newdate'=> $newdate,
            'notifications_auj'=> $Rendez_vous_aujourdhui,
            'newdate1'=> $newdate,
            'id'=> $idPate,
            'Treatings'=> $Treatings,

            ]);
    }


    /**
     * @Route("/ajax_add_doctor", name="ajax_add_doctor")
     */

    public function ajaxadddoctor(Request $request)
    {
    
        
        $idPatient = $request->get('idPatient');
        $idDoctor = $request->get('idDoctor');  


        $em = $this->getDoctrine()->getManager();
        $Patient=$em->getRepository(Patient::class)->find($idPatient);

        $em = $this->getDoctrine()->getManager();
        $Doctor=$em->getRepository(Doctor::class)->find($idDoctor);





        $em = $this->getDoctrine()->getManager();
        $Treating=$em->getRepository(TreatingDoctor::class)->findAll();

$cpt = 0;
for($i=0;$i<count($Treating);$i++){
    if(($Treating[$i]->getPatient()->getid() == $Patient->getid()) and  ($Treating[$i]->getDoctor()->getid() == $Doctor->getid()) ){
        $cpt = $cpt+1;

      }
}
if($cpt == 0){
    
    $TreatingDoctor = new TreatingDoctor();
    $TreatingDoctor
    ->setDoctor( $Doctor)
    ->setPatient( $Patient);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($TreatingDoctor);
    $entityManager->flush();
    
}


           $response = new Response(json_encode(array($Patient,$Doctor,$cpt)));
           $response->headers->set('Content-Type', 'application/json');
           
           return $response;
      
    }




}

<?php
namespace App\Controller;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\UserEvent;
use App\Entity\Wilaya;
use App\Entity\PatientEvent;
use App\Entity\HospitalCenter;
use App\Form\SearcheDoctorType;
use App\Repository\DoctorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{


  
  /**
    * @var DoctorRepository
    */

    private $Repository;
    public function __construct(DoctorRepository $Repository)
    {
        $this ->Repository =$Repository;
    }
    
    

    /**
     * @Route("/", name="Index", defaults={"_locale"="fr"}, requirements={"_locale" = "%app.locales%"})
     *  @param DoctorRepository $Repository
     * @return Response
     */

     
    public function index(Request $request , PaginatorInterface $paginator):Response
    {
        $cookies = $request->cookies;

        $datedep=$cookies->get('date_rdv');
        //dump($cookies);

        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);



        $em = $this->getDoctrine()->getManager();
        $PatientEventTemp = $em->getRepository(UserEvent::class)->findAll();
        $workingtime=$PatientEventTemp;
        //dump($workingtime);

        $em = $this->getDoctrine()->getManager();
        $DoctorTemp = $em->getRepository(Doctor::class)->findAll();
        $total_doctor=count($DoctorTemp);

        $em = $this->getDoctrine()->getManager();
        $DoctorTemp = $em->getRepository(Patient::class)->findAll();
        $total_Patient=count($DoctorTemp);

        $doctor=$this->getUser();
        $newdate1=new \DateTime();
        $newdate1->format('Y-m-d');
        $Rendez_vous_aujourdhui = $this->getDoctrine()->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'confirmed','doctor'=>$doctor]);
        
        $patient=$this->getUser();
        $newdatepat=new \DateTime();
        $newdatepat->format('Y-m-d');
        $notificationpat = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','patient'=>$patient]);


        $HospitalCenter = $this->getDoctrine()->getRepository(HospitalCenter::class)->findAll();


        $PatientEvents = $this->getDoctrine()->getRepository(PatientEvent::class)->findAll();
        $total_rdv=count($PatientEvents);
        $form = $this->createForm(SearcheDoctorType::class);
        $form->handleRequest($request);	

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $wilaaya=$form->get('willaya')->getData();
            $doc=$form->get('doctor')->getData();
            //dump($wilaaya);
            //dump($doc);
           

            $doctor = $pagination = $paginator->paginate(
              $this ->Repository->findBysearche($wilaaya, $doc), /* query NOT result */
              $request->query->getInt('page', 1), /*page number*/
              2 /*limit per page*/
          );




            $recharche=count($doctor);
            return  $this->render('kbm/Page/Doctor.html.twig',[
              'wilaaya' => $wilaaya,
              'doc' => $doc,
              'doctors' => $doctor,
              'DoctorTemps' => $DoctorTemp,
                'workingtimes' => $workingtime,
                'datedep' => $datedep,
                'recharche' => $recharche,
                'PatientEvents' => $PatientEvents,
                'notifications' => $notification,
                'newdate'=> $newdate,
                'notifications_auj'=> $Rendez_vous_aujourdhui,
                'newdate1'=> $newdate,
                'newdatepat'=> $newdatepat,
                'notificationpats'=> $notificationpat,             
                'HospitalCenters'=> $HospitalCenter,    
                'Form' => $form->createView(),
         

                ]);
                
                
                  
        }    
      
        return  $this->render('kbm/Page/Index.html.twig',[
          'Form' => $form->createView(),
          'total_rdv' => $total_rdv,
          'total_doctor' => $total_doctor,
          'total_Patient' => $total_Patient,    
          'notifications' => $notification,
          'newdate'=> $newdate,
          'notifications_auj'=> $Rendez_vous_aujourdhui,
          'newdate1'=> $newdate,            
          'newdatepat'=> $newdatepat,
          'notificationpats'=> $notificationpat,
        ]);
    }
	
	
    /**
     *  @Route("/findDoc", name="ajax_autocomplete_doctor")
     *  @param DoctorRepository $Repository
     *  @return Response
     */
    public function findDoc(Request $request , PaginatorInterface $paginator):Response
    {
            $term = $request->request->get('term');
             
			// fetch a title for a better user experience maybe..
			$em = $this->getDoctrine()->getManager();
			
			$array= $em->getRepository(Doctor::class)->doctorList($term);
			
            $response = new Response(json_encode($array));
             
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;
    }

    /**
     *  @Route("/findWil", name="ajax_autocomplete_Wilaya")
     *  @param WilayaRepository $Repository
     *  @return Response
     */
    public function findWil(Request $request , PaginatorInterface $paginator):Response
    {
            $term = $request->request->get('term');
             
			// fetch a title for a better user experience maybe..
			$em = $this->getDoctrine()->getManager();
			
			$array= $em->getRepository(Wilaya::class)->WilayaList($term);
			
            $response = new Response(json_encode($array));
             
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;
    }

}

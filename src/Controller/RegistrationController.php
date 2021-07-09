<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Doctor;
use App\Form\UserType;
use App\Entity\Service;
use App\Entity\PatientEvent;
use App\Entity\HospitalCenter;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class RegistrationController extends BaseController
{

  
    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory     = $formFactory;
        $this->userManager     = $userManager;
        $this->tokenStorage    = $tokenStorage;
    }
    
    /**
     * @Route("/Professeur", name="Professeure")
     */
    public function registerDoctorAction(EntityManagerInterface $em, Request $request ,\Swift_Mailer $mailer) {

        $doctor=$this->getUser();
        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting','doctor'=>$doctor]);

        // 1) build the form
        $user = new Doctor();
        $form = $this->createForm(UserType::class, $user);
        $form->add('company', TextType::class)
        ->add('specialisation', EntityType::class, [
            'class' => Service::class,
            'attr' => ['class' => 'form-control',
            'style'=> 'display: block !important'],
        ])
        ->add('title', ChoiceType::class, [
            'choices' => ['Docteur' => 'Docteur', 'Professeur' => 'Professeur'],
            'placeholder' => 'Choisir...',
            'attr' => ['class' => 'form-control',
            'style'=> 'display: block !important'],
        ]);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form->setData($user);       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $message = (new \Swift_Message('Hello Email'))
            ->setSubject('création de compte DocRdv')
            ->setFrom('kbmdocmail@gmaissssl.com')
            ->setTo($user->getEmailCanonical())
            ->setBody('Bonjour '.$user->getTitle().' '.$user->getLastName().' '.$user->getFirstName().PHP_EOL.PHP_EOL.'Nous vous confirmons la création de votre compte sur notre plateforme DocRdv, toutefois le compte ne sera accéssible qu\'après la validation de l\'équipe DocRdv, vous recevrez un appel dans les les plus bref délais pour pouvoir accéder a ce dernier'
                .PHP_EOL.PHP_EOL.'Nous vous remercions de votre intérêt envers DocRdv et vous prions d\'agréer nos salutations les plus cordiales')
            ;
             $mailer->send($message);

            //on active par défaut
            $user->setEnabled(true);
            $user->setRoles(['ROLE_ADMIN']);   
            $user->setDateopened(new \DateTime); 
            $user->setImageName('doctor.png');
            $user->setImagePath('images/image_user/');
            $user->setUpdatedAt(new \DateTime());  

            // 4) save the User!
            $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $HospitalCenter = new HospitalCenter();
                $HospitalCenter->setDoctor($user);
                $HospitalCenter->setName($user->getcompany());
                $entityManager ->persist($HospitalCenter);
                $entityManager ->flush();

              
 




                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                  }

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
        
        }
        return $this->render('kbm/Page/Professeure.html.twig', [
            'form' => $form->createView(), 
            'mainNavRegistration' => true, 
            'title' => 'Inscription',
            'notifications'=> $notification,
            'newdate'=> $newdate,
            ]);
    }
    
/**
     * @Route("/register/ee")
     */
    
    public function registerAdminAction(Request $request) {

        $newdate=new \DateTime();
        $newdate->format('Y-m-d');
        $notification = $this->getDoctrine()
        ->getRepository(PatientEvent::class)->findBy(['TypeRdv'=>'waiting']);

        // 1) build the form
        $user = new Admin();
        $form = $this->createForm(UserType::class, $user);
        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form->setData($user);       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
           
            //on active par défaut
            $user->setEnabled(true);
            $user->setRoles(['ROLE_SUPER_ADMIN']);   
            $user->setImageName('admin.jpg');
            $user->setImagePath('images/image_user/');
            $user->setUpdatedAt(new \DateTime()); 
            // 4) save the User!
            $event = new FormEvent($form, $request);
                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                  }

                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
        
        }
        return $this->render('kbm/Page/registerr.html.twig', [ 'notifications'=> $notification,
        'newdate'=> $newdate,'form' => $form->createView(), 'mainNavRegistration' => true, 'title' => 'Inscription']);
    }
}



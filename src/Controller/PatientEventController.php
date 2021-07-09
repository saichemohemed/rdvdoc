<?php

namespace App\Controller;

use App\Entity\PatientEvent;
use App\Form\PatientEvent1Type;
use App\Repository\PatientEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/patient/event")
 */
class PatientEventController extends AbstractController
{

    /**
     * @Route("/", name="patient_event_index", methods={"GET"})
     */
    public function index(PatientEventRepository $patientEventRepository): Response
    {      $PatientEvent =new PatientEvent;
         // dump('patient_events');
        //dump($this->getUser()->getId());
        return $this->render('patient_event/index.html.twig', [
            'patient_events' => $patientEventRepository->findBy(['patient'=>$this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="patient_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $patientEvent = new PatientEvent();
        $form = $this->createForm(PatientEvent1Type::class, $patientEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patientEvent);
            $entityManager->flush();

            return $this->redirectToRoute('patient_event_index');
        }

        return $this->render('patient_event/new.html.twig', [
            'patient_event' => $patientEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_event_show", methods={"GET"})
     */
    public function show(PatientEvent $patientEvent): Response
    {
        return $this->render('patient_event/show.html.twig', [
            'patient_event' => $patientEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PatientEvent $patientEvent): Response
    {
        $form = $this->createForm(PatientEvent1Type::class, $patientEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_event_index');
        }

        return $this->render('patient_event/edit.html.twig', [
            'patient_event' => $patientEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PatientEvent $patientEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patientEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patientEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patient_event_index');
    }
}

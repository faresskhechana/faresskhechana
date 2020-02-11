<?php

namespace ClubBundle\Controller;

use ClubBundle\Entity\Event;
use ClubBundle\Form\EventType;
use Composer\DependencyResolver\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EventController extends Controller
{
    public function AjouterAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $event=new Event();
        $form=$this->createForm(EventType::class,$event)
            ->add('photo',FileType::class);
        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('_afficherEvent');
        }
        return $this->render('@Club/Event/ajouter.html.twig',
            array('event'=>$event,'f'=>$form->createView()));
    }

    public function ModifierAction(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository(Event::class)
            ->find($id);
        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('_afficherEvent');
        }
        return $this->render('@Club/Event/modifier.html.twig', array(
            'event'=>$event,'f'=>$form->createView()));
    }

    public function AfficherAction()
    {
        $event=$this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('@Club/Event/afficher.html.twig',
            array('event'=>$event));
    }

    function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository(Event::class)
            ->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('_afficherEvent');
    }

}

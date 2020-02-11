<?php

namespace ClubBundle\Controller;

use ClubBundle\Entity\Club;
use ClubBundle\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class ClubController extends Controller
{
    public function AjouterAction(Request $request)
    {
        $club=new Club();
        $form=$this->createForm(ClubType::class,$club)
            ->add('logo',FileType::class,array('label'=>'logo'));
        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            //$valid =1;
            //die('here');
            /**
             * @var UploadedFile $file
             */
            $file=$club->getLogo();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$fileName);
            $club->setLogo($fileName);

            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('_afficher');
        }
        return $this->render('@Club/Club/ajouter.html.twig',
            array('club'=>$club,'f'=>$form->createView()));
    }

    public function ModifierAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(Club::class)
            ->find($id);
        $form=$this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('_afficher');
        }
        return $this->render('@Club/Club/modifier.html.twig', array(
            'club'=>$club,'f'=>$form->createView()));
    }

    public function AfficherAction()
    {
        $club=$this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render('@Club/Club/afficher.html.twig',
            array('club'=>$club));
    }

    public function SupprimerAction($id){
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(Club::class)
            ->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('_afficher');
    }

    public function AfficherIdAction($id){
        $club=$this->getDoctrine()->getRepository(Club::class)->find(array('id'=>$id));
        return $this->render('@Club/Club/afficherClub.html.twig',
            array('club'=>$club));
    }
}

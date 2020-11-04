<?php


namespace App\Controller;


use App\Entity\Identity;
use App\Entity\Program;
use App\Form\IdentityType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    /**
     * @Route("programme/nouveau",name="program.new")
     */
    public function newProgram(Request $request,ObjectManager $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $prog=new Program();
        $identity=new Identity();
        $identity->setAuteur($this->getUser());
        $form = $this->createForm(IdentityType::class,$identity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($this->isGranted("ROLE_MODO"))$identity->setEtat(1);
            else $identity->setEtat(0);
            $em->persist($identity);
            $em->flush();
            $prog->setIdentity($identity);
            $em->persist($prog);
            $em->flush();
            return $this->redirectToRoute("program.edit",["id"=>$prog->getId()]);
        }
        return $this->render("program/new.html.twig",[
            'prog'=>$prog,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/programme/modifier/{id}",name="program.edit")
     */
    public function edit(Program $prog,Request $request,ObjectManager $em){
        $identity=$prog->getIdentity();
        $form=$this->createForm(IdentityType::class,$identity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($identity);
            $em->flush();
            return $this->redirectToRoute("program.view",["id"=>$prog->getId()]);
        }
        return $this->render("program/edit.html.twig",[
            'identity'=>$identity,
            'prog'=>$prog,
            'form'=>$form->createView()
        ]);
    }
}
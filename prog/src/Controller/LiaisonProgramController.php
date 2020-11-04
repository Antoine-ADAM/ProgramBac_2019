<?php


namespace App\Controller;


use App\Entity\Identity;
use App\Entity\LiaisonProgram;
use App\Entity\Program;
use App\Form\IdentityType;
use App\Repository\ProgramRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LiaisonProgramController extends AbstractController
{
    /**
     * @Route("liaisonProg/newSubProg",name="liaisonProg.newSubProg")
     */
    public function newProgram(Request $request,ObjectManager $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $jsonDecode=$this->$this->decodeJson($request);
        if(empty($jsonDecode["idParent"]) || empty($jsonDecode["name"]) || !is_integer($jsonDecode["idParent"]))return $this->error("Liaison:001","Il y a une erreur avec les valeurs envoyés.");
        $prog = new Program();
        $repository=$this->getDoctrine()->getRepository(Program::class);
        $progParent=$repository->find($jsonDecode["idParent"]);
        if($progParent->getLiaisonProgramsUp()->count()!=1)return $this->error("","");
        $liaisonPrincipal=$progParent->getLiaisonProgramsUp()->first();
        if($liaisonPrincipal->getType() != 1)return $this->error("","");
        $liaison=new LiaisonProgram();
        $liaison->setName($jsonDecode["name"]);
        $liaison->setParent($progParent);
        $liaison->setType(1);
        $liaison->addProgram($prog);
        $liaison->setProgramPrincipal($liaisonPrincipal->getProgramPrincipal());
        $identity=$liaisonPrincipal->getProgramPrincipal()->getIdentity();
        if($this->isGranted("ROLE_MODO") || $this->getUser()->isEqual($identity->getAuteur()))return $this->error("","");
        $em->persist($prog);
        $em->persist($liaison);
        $em->flush();
        return $this->json('{"statut":0}');
    }
    private function decodeJson(Request $request){
        return json_decode($request->request->get("dataJson","{}"));
    }

    private function error($code,$message)
    {
        return $this->json('{"statut":1}');
    }
}
<?php


namespace App\Controller;


use App\Entity\Diapo;
use App\Entity\Page;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $om;
    function __construct(ObjectManager $om)
    {
        $this->om=$om;
    }

    /**
     * @Route("/page/add/{id}",name="page.add",methods={"POST"})
     */
    function add(Diapo $diapo, Request $request){
        if($this->getUser()->isEqual($diapo->getIdentity()->getAuteur()) || $this->isGranted('ROLE_ADMIN')){
            $page=new Page();
            $page->setDiapo($diapo);
            $page->setText($request->request->get("textPage",""));
            $this->om->persist($page);
            $this->om->flush();
            $diapo->updateModif($this->om);
            return JsonResponse::fromJsonString('{"etat":0,"message":"La page a bien été ajoutée"}');
        }
        return JsonResponse::fromJsonString('{"etat":1,"message":"Vous n\'avais pas la permision pour ajouter une page au diapo"}');
    }

    /**
     * @Route("/page/edit/{id}",name="page.edit")
     */
    function edit(Page $page,Request $request){
        if(!$this->getUser()->isEqual($page->getDiapo()->getIdentity()->getAuteur()))$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $page->setText($request->request->get("textPage",""));
        $this->om->persist($page);
        $this->om->flush();
        $page->getDiapo()->updateModif($this->om);
    }

    /**
     * @Route("/page/remove/{id}",name="page.remove")
     */
    function remove(Page $page){
        if(!$this->getUser()->isEqual($page->getDiapo()->getIdentity()->getAuteur()))$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->om->remove($page);
        $this->om->flush();
        $page->getDiapo()->updateModif($this->om);
    }

}
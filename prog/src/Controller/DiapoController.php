<?php


namespace App\Controller;


use App\Entity\Diapo;
use App\Entity\Identity;
use App\Form\DiapoCreateType;
use App\Form\IdentityType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class DiapoController extends AbstractController
{
    /**
     * @Route("/diapo/nouveau",name="diapo.create")
     */
    public function create(Request $request,ObjectManager $em){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $diapo=new Diapo();
        $identity=new Identity();
        $diapo->setIdentity($identity);
        $identity->setAuteur($this->getUser());
        $form = $this->createForm(IdentityType::class,$identity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($this->isGranted("ROLE_MODO"))$identity->setEtat(1);
            else $identity->setEtat(0);
            $em->persist($identity);
            $em->persist($diapo);
            $em->flush();
            return $this->redirectToRoute("diapo.edit",["id"=>$diapo->getId()]);
        }
        return $this->render("diapo/create.html.twig",[
            'identity'=>$identity,
            'diapo'=>$diapo,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/diapo/{id}",name="diapo.view")
     */
    public function view(Diapo $diapo,Request $request){
        $pages=$diapo->getPage();
        $identity=$diapo->getIdentity();
        return $this->render("diapo/view.html.twig",[
            'identity'=>$identity,
            'diapo'=>$diapo,
            'pages'=>$pages,
        ]);
    }
    /**
     * @Route("/diapo/televerse/{id}",name="diapo.download")
     */
    public function download(Diapo $diapo){
        return $this->render("diapo/download.html.twig",[
            'diapo'=>$diapo,
        ]);
    }
    /**
     * @Route("/diapo/telecharger/{id}",name="diapo.download.file")
     */
    public function downloadFile(Diapo $diapo){
        $identity=$diapo->getIdentity();
        $header="--------------------------------{Programme {$diapo->getTitle()}}--------------------------------\n";
        $taille=strlen($header)-77;
        $header.="{$identity->getDescription()}

Programme produit par {$identity->getAuteur()->getFirstName()} {$identity->getAuteur()->getFirstName()} le {$identity->getCreateAt()->format("d/m/Y")}, 
créer via l'outi en ligne ProgrammeTi (programmeti.fr)

Vous pouver sauvegarder le programme sur votre pc en le téléchargent (CONTROL + S)

/!\\ Le programme ne supporte que les calculatrice de modele: TI-83 premium CE /!\\
MODE D'EMPLOI:
      1 - Télécharger et installer le logiciel TI Connectect CE (https://education.ti.com/fr/products/computer-software/ti-connect-ce-sw)
      
      2 - Connecter votre calculatrice (TI-83 premium CE) au pc via le câble fournie avec la calculatrice

      3 - Lancé l'application TI Connectect CE puis cliquer sur le bouton en forme de pyramide de trois carré (en haut à gauche de la fenetre)

      4 - Copier (CONTROL + C) le programme ci-dessous (des petits tirés : ---------)

      5 - Cliquer sur \"Nouveau programme\" puis coller le programme (CONTROL + V)

      6 - Renommer (\"NOM VAR:\" en haut de la zone de texte) le programme (par exemple: MATH)

      7 - Cliquer sur le bouton en forme de calculatrice pointé par la flèche (en haut à gauche de la fenetre)
          Vous devriez voir une case cocher droite du nom de votre calculatrice si ce n'est pas le cas cocher la
          si vous ne voier votre calculatrice s'est quelle n'est pas connecter au pc

      8 - Cliquer sur le bouton \"ENVOYER\", Le programme est installer et prés à être éxécuté 

ProgrammeTi © 2020 Antoine ADAM All Rights Reserved
-----------------------------------------------------------------------------";
        for($i=0;$i<$taille;$i++)$header.="-";
        $header.="\n\n";
        return new Response($header.$diapo->getCode(), 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="ProgrammeTi_'.$identity->getTitle().'.txt"',
        ]);
    }
    /**
     * @Route("/diapo/modifier/{id}",name="diapo.edit")
     */
    public function edit(Diapo $diapo,Request $request,ObjectManager $em){
        $identity=$diapo->getIdentity();
        $form = $this->createForm(IdentityType::class,$identity);
        $form->handleRequest($request);
        $pages=$diapo->getPage();
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($identity);
            $em->flush();
            return $this->redirectToRoute("diapo.view",["id"=>$diapo->getId()]);
        }
        return $this->render("diapo/edit.html.twig",[
            'identity'=>$identity,
            'diapo'=>$diapo,
            'pages'=>$pages,
            'form'=>$form->createView()
        ]);
    }

}
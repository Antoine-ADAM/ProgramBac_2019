<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;
    public function __construct(ObjectManager $em)
    {
        $this->em=$em;
    }

    /**
     * @Route("/deconnection", name="logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
    /**
     * @Route("/membre/parametre",name="member.setting")
     */
    public function editUserMember(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user=$this->getUser();
        $form = $this->createForm(UserEditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("security/editMember.html.twig",[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils){
        $error=$authenticationUtils->getLastAuthenticationError();
        $lastUsername=$authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username'=>$lastUsername,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/inscription",name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user=new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render("security/register.html.twig",[
            'user'=>$user,
            'form'=>$form->createView()
        ]);
    }
}
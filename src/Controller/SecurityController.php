<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SecurityController extends AbstractController
{

  
    /**
     * @Route("/Redirect")
     */
    public function RedirectloginAction(Request $request)
    
    {        $cookies = $request->cookies;
        //dump($cookies->get('test'));
       

//  $some = $this->get('App\Controller\SecurityController')->getSomeAction();

        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');
    
        if ($authChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($router->generate('kbmadmin'));
        }
        elseif ($authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('calendar'));
        }
        elseif (($authChecker->isGranted('ROLE_USER'))and ($cookies->get('test')==1)) {
            $id=$cookies->get('id');
            $heure=$cookies->get('heure');
            
                return new RedirectResponse($router->generate("Confirmation" , array('id' => $id,'heure'=>$heure)));
        }
        else {
                return new RedirectResponse($router->generate('Index'));
            }
        
         //dump($cookies);
         $cookies->remove('Homer');

    }
}

<?php

namespace MyApp\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Cookie;

class DefaultController extends Controller
{
    public function welcomeAction()
    {
		// Render without prm:
		// return $this->render('MyAppFilmsBundle:Default:index.html.twig');
		// Render with prm:
		//$message = 'GUEST';
		$message = $this->get('translator')->trans('default.welcomeUser');
		return $this->render('MyAppFilmsBundle:Default:welcome.html.twig', array('message' => $message));
    }

	public function languageAction(Request $request, $lg = null)
	{
	    // IMPORTANT!!!
	    // LISTENER IS REQUIRED!!! (..\src\MyApp\FilmsBundle\EventListener\LocaleListener.php)
	    // LISTENER REGISTRATION IS REQUIRED!!! (..\src\MyApp\FilmsBundle\Resources\config\services.yml)
	    
	    // If not null, store LG into session
	    if($lg != null){
            $request->getSession()->set('_locale', $lg);
        	// var_dump($request->getSession()->get('_locale'));
        	// die();
	    }

	    // Redirect to current page
	    $url = $request->headers->get('referer');
		// else, redirect to homepage
	    if(empty($url)) {
	        $url = $this->generateUrl('myapp_homepage');
	    }

	    //return new RedirectResponse($url);
	    return $this->redirect($url);
	}
}

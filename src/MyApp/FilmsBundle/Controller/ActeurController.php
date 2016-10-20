<?php

namespace MyApp\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use MyApp\FilmsBundle\Entity\Acteur;
use MyApp\FilmsBundle\Form\ActeurType;
use MyApp\FilmsBundle\Form\ActeurSearchType;

class ActeurController extends Controller
{
    /**
     * @Route("/actors")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actors = $em->getRepository('MyAppFilmsBundle:Acteur')->findBy(array(), array('nom' => 'ASC'));

        // 404
        if (!$actors){
            $actorHeader = $this->get('translator')->trans('acteur.listHeader');
            $actorBody = $this->get('translator')->trans('acteur.listBody');
            $actorNotFound = $this->get('translator')->trans('acteur.notFoundMsg');
            
            return $this->render('MyAppFilmsBundle:Acteur:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $actorHeader, 'body' => $actorBody, 'msg' => $actorNotFound, 'add' => true));
        }

        //$form = $this->container->get('form.factory')->create(new ActeurSearchType());
        $form = $this->createForm(ActeurSearchType::class);

        $lg = $request->getSession()->get('_locale');

        return $this->render('MyAppFilmsBundle:Acteur:list.html.twig', array('actors' => $actors, 'form' => $form->createView(), 'lg' => $lg));
    }

    /**
     * @Route("/actor/search")
     */
    public function searchAction(Request $request)
    {               
        //$request = $this->container->get('request');

        if($request->isXmlHttpRequest()){
            $keyword = '';
            $keyword = $request->request->get('keyword');
            $em = $this->getDoctrine()->getManager();

            if($keyword != ''){
                $query = $em->createQueryBuilder();
                $query->select('a')
                   ->from('MyAppFilmsBundle:Acteur', 'a')
                   ->where("a.nom LIKE :keyword OR a.prenom LIKE :keyword")
                   ->orderBy('a.nom', 'ASC')
                   ->setParameter('keyword', '%'.$keyword.'%');
                $actors = $query->getQuery()->getResult();
            }
            else{
                $actors = $em->getRepository('MyAppFilmsBundle:Acteur')->findBy(array(), array('nom' => 'ASC'));
            }

            $lg = $request->getSession()->get('_locale');

            return $this->render('MyAppFilmsBundle:Acteur:listRange.html.twig', array('actors' => $actors, 'lg' => $lg));
        }
        else{
            return $this->listAction();
        }
    }

    /**
     * @Route("/actor/add")
     */
    public function addAction(Request $request)
    {
        $message = '';
        $messageType = '';
        $actor = new Acteur();
        $form = $this->createForm(ActeurType::class, $actor);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('acteur.addSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);
            $em->flush();

            // RESET ALL VALUES
            return $this->redirect($this->generateUrl('myapp_actor_add'));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_actors');

        $lg = $request->getSession()->get('_locale');

        return $this->render('MyAppFilmsBundle:Acteur:add.html.twig', array('form' => $form->createView(), 'prevPage' => $prevPage, 'lg' => $lg));
    }

    /**
     * @Route("/actor/edit/{id}")
     */
    public function editAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $actor = $em->find('MyAppFilmsBundle:Acteur', $id);
        $form = $this->createForm(ActeurType::class, $actor);

        // 404
        if (!$actor){
            $actorHeader = $this->get('translator')->trans('acteur.editHeader');
            $actorBody = $this->get('translator')->trans('acteur.editBody');
            $actorNotFound = $this->get('translator')->trans('acteur.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Acteur:fourOfour.html.twig', array('md' => '6','offset' => '3','heading' => $actorHeader, 'body' => $actorBody, 'msg' => $actorNotFound, 'back' => true));
        }
        // success
        elseif($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('acteur.editSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($actor);
            $em->flush();
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_actors');

        $lg = $request->getSession()->get('_locale');

        return $this->render('MyAppFilmsBundle:Acteur:edit.html.twig', array('form' => $form->createView(), 'prevPage' =>$prevPage, 'lg' => $lg));
    }

    /**
     * @Route("/actor/delete/{id}")
     */
    public function deleteAction($id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $actor = $em->find('MyAppFilmsBundle:Acteur', $id);

        // 404
        if (!$actor){
            $actorHeader = $this->get('translator')->trans('acteur.listHeader');
            $actorBody = $this->get('translator')->trans('acteur.listBody');
            $actorNotFound = $this->get('translator')->trans('acteur.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Acteur:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $actorHeader, 'body' => $actorBody, 'msg' => $actorNotFound, 'back' => true));
        }

        $messageType = 'success';
        $message = $this->get('translator')->trans('acteur.deleteSuccess');
        $this->addFlash($messageType, $message);

        $em->remove($actor);
        $em->flush();

        return $this->redirect($this->generateUrl('myapp_actors'));
    }

    /**
     * @Route("/actor/query/{id}")
     */
    public function queryAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();
        $actor = $em->find('MyAppFilmsBundle:Acteur', $id);

        // 404
        if (!$actor){
            $actorHeader = $this->get('translator')->trans('acteur.queryHeader');
            $actorBody = $this->get('translator')->trans('acteur.queryBody');
            $actorNotFound = $this->get('translator')->trans('acteur.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Acteur:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $actorHeader, 'body' => $actorBody, 'msg' => $actorNotFound, 'back' => true));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_actors');

        return $this->render('MyAppFilmsBundle:Acteur:query.html.twig', array('actor' => $actor, 'prevPage' => $prevPage));
    }

    /**
     * @Route("/actor/top")
     */
    public function topAction($max = 3)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder();
        $query->select('a')
           ->from('MyAppFilmsBundle:Acteur', 'a')
           ->orderBy('a.dateNaissance', 'DESC')
           ->setMaxResults($max);

        $actors = $query->getQuery()->getResult();

        return $this->render('MyAppFilmsBundle:Acteur:list.html.twig', array('actors' => $actors));
    }

    /**
     * @Route("/actor/xxxxxxxxxxxxxxxxxxxx")
     */
    public function sortbynameAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQueryBuilder();
        $query->select('a')
           ->from('MyAppFilmsBundle:Acteur', 'a')
           ->orderBy('a.dateNaissance', 'DESC')
           ->setMaxResults($max);

        $actors = $query->getQuery()->getResult();

        return $this->render('MyAppFilmsBundle:Acteur:list.html.twig', array('actors' => $actors));
    }

}

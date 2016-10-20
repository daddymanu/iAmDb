<?php

namespace MyApp\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use MyApp\FilmsBundle\Entity\Categorie;
use MyApp\FilmsBundle\Form\CategorieType;

class CategorieController extends Controller
{
    /**
     * @Route("/categories")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('MyAppFilmsBundle:Categorie')->findBy(array(), array('nom' => 'ASC'));

        // 404
        if (!$categories){
            $categoryHeader = $this->get('translator')->trans('categorie.listHeader');
            $categoryBody = $this->get('translator')->trans('categorie.listBody');
            $categoryNotFound = $this->get('translator')->trans('categorie.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Categorie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $categoryHeader, 'body' =>  $categoryBody,'msg' => $categoryNotFound, 'add' => true));
        }
        
        $lg = $request->getSession()->get('_locale');

        return $this->render('MyAppFilmsBundle:Categorie:list.html.twig', array('categories' => $categories, 'lg' => $lg));
    }

    /**
     * @Route("/category/add")
     */
    public function addAction(Request $request)
    {
        $message = '';
        $messageType = '';
        $category = new Categorie();
        $form = $this->createForm(CategorieType::class, $category);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('categorie.addSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            // RESET ALL VALUES
            //unset($category);
            //unset($form);
            return $this->redirect($this->generateUrl('myapp_category_add'));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_categories');

        return $this->render('MyAppFilmsBundle:Categorie:add.html.twig', array('form' => $form->createView(), 'prevPage' => $prevPage));
    }

    /**
     * @Route("/category/edit/{id}")
     */
    public function editAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $category = $em->find('MyAppFilmsBundle:Categorie', $id);
        $form = $this->createForm(CategorieType::class, $category);

        // 404
        if (!$category){
            $categoryHeader = $this->get('translator')->trans('categorie.editHeader');
            $categoryBody = $this->get('translator')->trans('categorie.editBody');
            $categoryNotFound = $this->get('translator')->trans('categorie.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Categorie:fourOfour.html.twig', array('md' => '6','offset' => '3','heading' => $categoryHeader, 'body' => $categoryBody,'msg' => $categoryNotFound, 'back' => true));
        }
        elseif($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('categorie.editSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }
        
        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_categories');
        
        return $this->render('MyAppFilmsBundle:Categorie:edit.html.twig', array('form' => $form->createView(), 'prevPage' => $prevPage));
    }

    /**
     * @Route("/category/delete/{id}")
     */
    public function deleteAction($id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $category = $em->find('MyAppFilmsBundle:Categorie', $id);
        $hasFilms = $em->getRepository('MyAppFilmsBundle:Film')->findBy(array('categorie'=>$id));
        
        // 404
        if (!$category){
            $categoryHeader = $this->get('translator')->trans('categorie.listHeader');
            $categoryBody = $this->get('translator')->trans('categorie.listBody');
            $categoryNotFound = $this->get('translator')->trans('categorie.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Categorie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $categoryHeader, 'body' => $categoryBody, 'msg' => $categoryNotFound, 'back' => true));
        }
        //CANT DELETE IF CATEGORY HAS MOVIES!!!
        elseif ($hasFilms){
            $messageType = 'danger';
            $message = $this->get('translator')->trans('categorie.deleteForbidden');
            $this->addFlash($messageType, $message);

            $em->flush();

            return $this->redirect($this->generateUrl('myapp_categories'));
            // return $this->render('MyAppFilmsBundle:Categorie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => 'DETAILS OF THE CATEGORY', 'body' => 'Here you can review details of the movie category you selected...', 'msg' => 'This category cannot be deleted: Some movies belongs to it...', 'back' => true));
        }

        $messageType = 'success';
        $message = $this->get('translator')->trans('categorie.deleteSuccess');
        $this->addFlash($messageType, $message);

        $em->remove($category);
        $em->flush();

        return $this->redirect($this->generateUrl('myapp_categories'));
    }

    /**
     * @Route("/category/query/{id}")
     */
    public function queryAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $category = $em->find('MyAppFilmsBundle:Categorie', $id);

        // 404
        if (!$category){
            $categoryHeader = $this->get('translator')->trans('categorie.queryHeader');
            $categoryBody = $this->get('translator')->trans('categorie.queryBody');
            $categoryNotFound = $this->get('translator')->trans('categorie.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Categorie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $categoryHeader, 'body' => $categoryBody, 'msg' => $categoryNotFound, 'back' => true));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_categories');

        return $this->render('MyAppFilmsBundle:Categorie:query.html.twig', array('category' => $category, 'prevPage' => $prevPage));
    }
}

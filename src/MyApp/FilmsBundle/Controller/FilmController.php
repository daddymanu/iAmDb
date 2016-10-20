<?php

namespace MyApp\FilmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use MyApp\FilmsBundle\Entity\Film;
use MyApp\FilmsBundle\Form\FilmType;

class FilmController extends Controller
{
    /**
     * @Route("/movies")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('MyAppFilmsBundle:Film')->findBy(array(), array('titre' => 'ASC'));

        // 404
        if (!$movies){
            $movieHeader = $this->get('translator')->trans('film.listHeader');
            $movieBody = $this->get('translator')->trans('film.listBody');
            $movieNotFound = $this->get('translator')->trans('film.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Film:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $movieHeader, 'body' => $movieBody, 'msg' => $movieNotFound, 'add' => true));
        }

        return $this->render('MyAppFilmsBundle:Film:list.html.twig', array('movies' => $movies));
    }

    /**
     * @Route("/movie/add")
     */
    public function addAction(Request $request)
    {
        $message = '';
        $messageType = '';
        $movie = new Film();
        $form = $this->createForm(FilmType::class, $movie);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('film.addSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            // RESET ALL VALUES
            return $this->redirect($this->generateUrl('myapp_movie_add'));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_movies');

        return $this->render('MyAppFilmsBundle:Film:add.html.twig', array('form' => $form->createView(), 'prevPage' => $prevPage));
    }

    /**
     * @Route("/movie/edit/{id}")
     */
    public function editAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $movie = $em->find('MyAppFilmsBundle:Film', $id);
        $form = $this->createForm(FilmType::class, $movie);
        
        // 404
        if (!$movie){
            $movieHeader = $this->get('translator')->trans('film.editHeader');
            $movieBody = $this->get('translator')->trans('film.editBody');
            $movieNotFound = $this->get('translator')->trans('film.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Movie:fourOfour.html.twig', array('md' => '6','offset' => '3','heading' =>  $movieHeader, 'body' => $movieBody, 'msg' => $movieNotFound, 'back' => true));
        }
        elseif($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $messageType = 'success';
            $message = $this->get('translator')->trans('film.editSuccess');
            $this->addFlash($messageType, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_movies');

        return $this->render('MyAppFilmsBundle:Film:edit.html.twig', array('form' => $form->createView(), 'prevPage' => $prevPage));
    }

    /**
     * @Route("/movie/delete/{id}")
     */
    public function deleteAction($id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $movie = $em->find('MyAppFilmsBundle:Film', $id);

        // 404
        if (!$movie){
            return $this->render('MyAppFilmsBundle:Movie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => 'DETAILS OF THE MOVIE', 'body' => 'Here you can review details of the movie you selected...', 'msg' => 'Movie not found...', 'back' => true));
        }

        $messageType = 'success';
        $message = $this->get('translator')->trans('film.deleteSuccess');
        $this->addFlash($messageType, $message);

        $em->remove($movie);
        $em->flush();

        return $this->redirect($this->generateUrl('myapp_movies'));
    }

    /**
     * @Route("/movie/query/{id}")
     */
    public function queryAction(Request $request, $id)
    {
        $message = '';
        $messageType = '';
        $em = $this->getDoctrine()->getManager();

        $movie = $em->find('MyAppFilmsBundle:Film', $id);

        // 404
        if (!$movie){
            $movieHeader = $this->get('translator')->trans('film.queryHeader');
            $movieBody = $this->get('translator')->trans('film.queryBody');
            $movieNotFound = $this->get('translator')->trans('film.notFoundMsg');

            return $this->render('MyAppFilmsBundle:Movie:fourOfour.html.twig', array('md' => '10','offset' => '1','heading' => $movieHeader, 'body' => $movieBody, 'msg' => $movieNotFound, 'back' => true));
        }

        //$prevPage = $request->headers->get('referer');
        //$prevPage = $request->server->get('HTTP_REFERER');
        $prevPage = $this->generateUrl('myapp_movies');

        return $this->render('MyAppFilmsBundle:Film:query.html.twig', array('movie' => $movie, 'prevPage' => $prevPage));
    }
}

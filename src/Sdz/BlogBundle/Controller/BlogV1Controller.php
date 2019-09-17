<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function helloAction($id)
    {
        $aData = array(
            'nom' => 'Mek',
            'company' => 'Logimek'
        );
        return $this->render('SdzBlogBundle:Blog:hello.html.twig', $aData);
    }

    public function byeAction()
    {
        return new Response("Byebye Mek");
    }

    public function indexAction($page)
    {
        // Génération des urls
        $url = $this->generateUrl('sdz_blog_view', array('id'=> 19));
        $urlAbsolue = $this->generateUrl('sdz_blog_view', array('id'=> 19), true);

        $aData = array(
            'app' => 'Blog',
            'author' => 'Mek',
            'page' => $page,
            'url' => $url,
            'urlAbsolue' => $urlAbsolue
        );

        return $this->render('SdzBlogBundle:Blog:index.html.twig', $aData);
    }

    public function testAction($param) 
    {
        $request = $this->get('request');
        // Params GET, variables d'URL: $request->query
        $tag = $request->query->get('tag');
        // Param POST, variables de formulaire: $request->request
        // Cookies, variables de cookies: $request->cookies
        // Variables de serveur: $request->server
        // Variables d'en-tête: $request->headers
        // Variables de route: $request->attributes

        // dump($request->server);
        // dump($request->headers);
        // dump($request->attributes);
        // dump($request->getMethod());

        if ($request->getMethod() == 'POST') {
            // Un formulaire a été soumis, on peut le traiter
        }
        if ($request->isXmlHttpRequest()) {
            // C'est une requête Ajax
        }

        // $response = new Response();
        // $response->setContent('Ceci est une page d\'erreur 404');
        // $response->setStatusCode(404);
        // dump($response);

        // return new Response("test param: $param");
        // return $response;

        // Une redirection est une réponse Http !
        // return $this->redirect(
        //     $this->generateUrl('sdz_blog_home')
        //     // array('page' => 2)
        // );

        // Changer le content type de la réponse
        // On retourne du json et non du html
        // $response = new Response(json_encode(array('id' => $param)));
        // $response->headers->set('Content-type', 'application/json');
        // return $response;

        // Ex utilisation des services

        // Récupération du service mailer   
        $mailer = $this->get('mailer'); 
        // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message    
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello zéro !')
            ->setFrom('tutorial@symfony2.com')      
            ->setTo('logimek72@gmail.com')      
            ->setBody('Coucou, voici un email que vous venez de recevoir !');    
        // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message    
        $mailer->send($message); 
        // N'oublions pas de retourner une réponse, par exemple, une page qui afficherait « L'email a bien été envoyé »    
        return new Response('Email bien envoyé'); 

        // Autre service templating
        $templating = $this->get('templating');
        $content = $templating->render('SdzBlogBundle:Blog:hello.html.twig');
        return new Response($content);

        // Service Request
        $request = $this->get('request');

        // Service Session
        $session = $this->get('session');
        // On peut aussi obtenir ce service par le service request, $this->get('request')->getSession()
        // Récupération
        $user_id = $session->get('user_id');
        // Définition
        $session->set('user_id', 19);
    }

    public function viewAction($id)
    {
        return $this->render('SdzBlogBundle:Blog:view.html.twig', array(
            'id' => $id
        ));
        // return new Response("View article id: $id");
    }

    public function addAction()
    {
        // return new Response('Add new article');
        $this->get('session')->getFlashBag()->add('info', 'Article bien enregistré');
        $this->get('session')->getFlashBag()->add('info', 'Et oui Article bien enregistré !');
        
        return $this->redirect(
            $this->generateUrl('sdz_blog_addViewTest', array('id' => 18))
        );
    }

    public function addViewTestAction($id) 
    {
        // return new Response('Hello mek');
        return $this->render('SdzBlogBundle:Blog:addViewTest.html.twig', array('id' => $id));
    }

    public function editAction($id)
    {
        return new Response("Edit article id: " . $id);
    }

    public function removeAction($id)
    {
        return new Response("Remove article id: " . $id);
    }

}


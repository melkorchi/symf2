<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        } 

        $articles = [
            [
            'id' => 1,
            'title' => 'Symfony 2.7, framework php',
            'author' => 'Mek',
            'content' => 'Vital de connaître ce framework, il est utilisé chez Bourse Direct. Actuellement la migration vers la version 3.4 est en cours...',
            'date' => new \Datetime()
            ],
            [
            'id' => 2,
            'title' => 'CSS3, Less',
            'author' => 'Mek',
            'content' => 'Vital de manipuler ces langages pour devenir autonome...',
            'date' => new \Datetime()
            ]
        ];
        
        return $this->render('SdzBlogBundle:Blog:index.html.twig', ['articles' => $articles]);
    }

    public function menuAction($number) 
    {
        $lastArticlesList = [
            ['id' => 3, 'title' => 'Symfony 2.7'],
            ['id' => 4, 'title' => 'Twig, moteur de template'],
            ['id' => 5, 'title' => 'HTML5'],
            ['id' => 6, 'title' => 'ECMA Script'],
            // ['id' => 7, 'title' => 'VueJs'],
            // ['id' => 8, 'title' => 'Angular'],
        ];

        return $this->render('blog/menu.html.twig', ['list'=> $lastArticlesList]);
    }

    public function viewAction($id)
    {
        $article = [
            'id' => 1,
            'title' => 'Symfony 2.7, framework php',
            'author' => 'Mek',
            'content' => 'Vital de connaître ce framework, il est utilisé chez Bourse Direct. Actuellement la migration vers la version 3.4 est en cours...',
            'date' => new \Datetime()
        ];

        return $this->render('SdzBlogBundle:Blog:view.html.twig', ['article' => $article]);
    }

    public function addAction()
    {
        if ($this->get('request')->getMethod() == 'POST') {
            // Traitement du formulaire, persister les datas en base
            // Message flash
            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');
            // Redirection vers la page de visualisation de l'article
            return $this->redirect($this->generateUrl('sdz_blog_view', ['id' => 19]));
        }

        // Affichage du formulaire d'ajout d'article
        return $this->render('SdzBlogBundle:Blog:add.html.twig');
    }

    public function editAction($id)
    {
        return $this->render('SdzBlogBundle:Blog:edit.html.twig', ['id' => $id]);
    }

    public function removeAction($id)
    {
        return $this->render('SdzBlogBundle:Blog:remove.html.twig', ['id' => $id]);
    }

}


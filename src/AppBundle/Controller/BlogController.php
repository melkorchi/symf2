<?php
// src/AppBundle/Controller/BlogController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller 
{
    /**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list")
     */
    public function listAction() 
    {
        return new Response("<h1>@route match exactly with blog</h1>");
    }

    /**
     * Matches /blog/{page}
     *
     * @Route("/blog/{page}", name="blog_showPage", requirements={"page"="\d+"})
     */
    public function showPageAction($page = 1) 
    {
        // e.g. at /blog/n, then $page=nbre n

        return new Response("<h1>@route match with blog/".$page." (param numérique)</h1>");
    }

    /**
     * Matches /blog/*
     *
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function showAction($slug) 
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /blog/yay-routing, then $slug='yay-routing'

        return new Response("<h1>@route match with blog/".$slug." (param chaîne de caractère)</h1>");
    }

    /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function showArticlesAction($_locale, $year, $slug) 
    {

    }

}
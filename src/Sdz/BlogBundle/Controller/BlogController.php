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

        // $aData = array(
        //     'app' => 'Blog',
        //     'author' => 'Mek',
        //     'page' => $page
        // );

        // $precedent = 200;
        // $reel = 100;
        // variation -> -50 %

        // $precedent = 100;
        // $reel = 200;
        // variation -> +100 %

        // $precedent = -200;
        // $reel = -100;
        // variation -> 50 %

        // $precedent = -100;
        // $reel = -200;
        // variation -> -100 %

        // $precedent = -200;
        // $reel = 100;
        // variation -> +150 %

        // $precedent = 200;
        // $reel = -100;
        // variation -> -150 %

        // $signe = intval(($reel * $precedent > 0 && $reel < 0) ? '-1' : '1');
        // $signe = intval(($reel * $precedent < 0 && $reel > $precedent) ? '-1' : '1');

        // $variation = (($reel -$precedent) / $precedent) * 100 * $signe;

        // $rez = array(
        //     'precedent' => $precedent,
        //     'reel' => $reel,
        //     'signe' => $signe,
        //     'variation' => $variation
        // );

        // dump($rez);die();

        // Test rendu fichier text
        // $content = $this->renderView('SdzBlogBundle:Blog:email.txt.twig', array(
        //     'pseudo' => 'Mek',
        //     'company' => 'Logimek'
        // ));
        // dump($content);die;

        // Test reg exp
        // dump($this->cecleFinanceRegExp());die();

        $articles = [
            [
            'id' => 1,
            'title' => 'First article',
            'author' => 'Mek',
            'date' => new \Datetime()
            ],
            [
            'id' => 2,
            'title' => 'Second article',
            'author' => 'Mek',
            'date' => new \Datetime()
            ]
        ];
        
        // return $this->render('SdzBlogBundle:Blog:index.html.twig', $aData);
        return $this->render('SdzBlogBundle:Blog:index.html.twig', ['articles' => $articles]);
    }

    private function cecleFinanceRegExp() {
        // Expression régulière
        // $str = '123 milliers$';
        // $str = '1 millier de barils';
        // $str = '2.000 Mds$';
        // $str = '2,3 MlsE';
        // $str = '0,13 Ml';
        // $str = '1.000,3 Mls$';
        // $str = '-3,2%';
        $str = '+2,00%';
        // $str = '1.999.250 Mds$';
        // $str = '0,954 Md$';
        // $str = "100.500,25";
        // $str = "100.500,25$";

        // dump($str);

        if (preg_match("#milliers?#", $str)) {
            $q = trim(preg_split("#milliers?#", $str)[0]);
            $u = (!empty(preg_split("#milliers?#", $str)[1])) ? trim(preg_split("#milliers?#", $str)[1]) : "none";
            $m = 1000;
        } elseif (preg_match("#Mls?#", $str)) {
            $q = trim(preg_split("#Mls?#", $str)[0]);
            $u = (!empty(preg_split("#Mls?#", $str)[1])) ? trim(preg_split("#Mls?#", $str)[1]) : "none";
            $m = 1000000;
        } elseif (preg_match("#Mds?#", $str)) {
            $q = trim(preg_split("#Mds?#", $str)[0]);
            $u = (!empty(preg_split("#Mds?#", $str)[1])) ? trim(preg_split("#Mds?#", $str)[1]) : "none";
            $m = 1000000000;
        } elseif (preg_match("#%$#", $str)) {
            // variation, pourcentage
            $q = trim(preg_split("#%$#", $str)[0]);
            $u = "%";
            $m = 1;
        } else {
            // Nombre
            $q = $str;
            $u = "none";
            $m = 1;
        }

        // Traitement du float
        $q1 = str_replace('.', '', $q);
        $q1 = str_replace(',', '.', $q1);
        $q1 = (float) $q1;
        $q1 = $m * $q1;

        // Traitement Baril de pétrole
        if (preg_match("#de barils#", $u)) {
            $u = "barils";
        }

        return array(
            'strInput' => $str,
            'float' => $q1,
            'unite' => $u
        );
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
        return $this->render('SdzBlogBundle:Blog:view.html.twig', ['id' => $id]);
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


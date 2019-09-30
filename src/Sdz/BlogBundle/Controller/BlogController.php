<?php

namespace Sdz\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sdz\BlogBundle\Entity\Article;
use Sdz\BlogBundle\Entity\ArticleCompetence;
use Sdz\BlogBundle\Entity\Categorie;
use Sdz\BlogBundle\Entity\Commentaire;
use Sdz\BlogBundle\Entity\Competence;
use Sdz\BlogBundle\Entity\Image;

class BlogController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        } 

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SdzBlogBundle:Article');
        $articles = $repository->findAll();
        
        return $this->render('SdzBlogBundle:Blog:index.html.twig', ['articles' => $articles]);
    }

    public function menuAction($number) 
    {
        $lastArticlesList = [
            ['id' => 3, 'title' => 'Symfony 2.7'],
            ['id' => 4, 'title' => 'Twig'],
            ['id' => 5, 'title' => 'HTML5'],
            ['id' => 6, 'title' => 'ECMA Script'],
            ['id' => 7, 'title' => 'VueJs'],
            ['id' => 8, 'title' => 'Angular']
        ];

        return $this->render('blog/menu.html.twig', ['list'=> $lastArticlesList]);
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryArticle = $em->getRepository('SdzBlogBundle:Article');

        $article = $repositoryArticle->find($id);
        // dump($article->getImage()->getUrl()); LAZY LOADING

        if (null === $article) {
            throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
        }

        // On récupère les commentaires associés à l'article
        $repositoryCommentaire = $em->getRepository('SdzBlogBundle:Commentaire');
        // $commentaires = $repositoryCommentaire->findByArticle($article);
        $commentaires = $repositoryCommentaire->findByArticle($article->getId());

        // On récupère les compétences liées à l'article
        $article_competences = $em->getRepository('SdzBlogBundle:ArticleCompetence')->findByArticle($article->getId());
        // dump($article_competences);die();
        

        return $this->render('SdzBlogBundle:Blog:view.html.twig', [
            'article' => $article, 
            'commentaires' => $commentaires,
            'article_competences' => $article_competences
        ]);
    }

    public function addAction()
    {
        // Ajouter un article...
        $article = new Article();
        $article->setTitle('Relation ManyToOne')
                ->setAuthor('Mek')
                ->setContent('L\'entité Commentaire est Propriétaire alors que l\'entité Article est dîte Inverse.');

        // Lier une image à un article...
        $image = new Image();
        $image->setUrl('img/photo.png')
              ->setAlt('image');

        $article->setImage($image);

        // Lier des commentaires à un article
        $comment1 = new Commentaire();
        $comment1->setAuthor('IbnMek')
                 ->setContent('On peut ajouter des commentaires')
                 ->setArticle($article); 
        $comment2 = new Commentaire();
        $comment2->setAuthor('IbnAbass')
                 ->setContent('On peut vraiment ajouter des commentaires')
                 ->setArticle($article); 

        $em = $this->getDoctrine()->getManager();

        // Petite mise à jour
        // $article2 = $em->getRepository('SdzBlogBundle:Article')->find(1);
        // $article2->setContent('Al hamdoulillah 3ala Kouli \'hal');

        // Lier les catégories
        $categories = $em->getRepository('SdzBlogBundle:Categorie')->findAll();
        foreach ($categories as $categorie) {
            $article->addCategory($categorie);
        }

        $em->persist($article);
        $em->persist($comment1);
        $em->persist($comment2);

        // Les compétences
        // Récup depuis le DB
        $competences = $em->getRepository('SdzBlogBundle:Competence')->findAll();
        foreach ($competences as $key => $competence) {
            $articleCompetence[$key] = new ArticleCompetence();
            $articleCompetence[$key]->setArticle($article)
                                    ->setCompetence($competence)
                                    ->setLevel('Intermédiaire');
            $em->persist($articleCompetence[$key]);
        }

        $em->flush();

        if ($this->get('request')->getMethod() == 'POST') {
            // Traitement du formulaire, persister les datas en base
            // Message flash
            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');
            // Redirection vers la page de visualisation de l'article
            return $this->redirect($this->generateUrl('sdz_blog_view', ['id' => $article->getId()]));
        }

        // Affichage du formulaire d'ajout d'article
        return $this->render('SdzBlogBundle:Blog:add.html.twig');
    }

    public function editAction($id)
    {
        // Récupération de l'article d'id = $id
        // Création et gestion du formulaire

        return $this->render('SdzBlogBundle:Blog:edit.html.twig', ['id' => $id]);
    }

    public function removeAction($id)
    {
        return $this->render('SdzBlogBundle:Blog:remove.html.twig', ['id' => $id]);
    }

}


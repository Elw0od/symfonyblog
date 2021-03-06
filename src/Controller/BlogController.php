<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;


class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog/new", name="create_article")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {

        if(!$article) {
            $article = new Article();
        }

       // $form = $this->createFormBuilder($article)
       //              ->add('title')
       //              ->add('content')
       //              ->add('image')
       //              ->getForm();

       $form = $this->createForm(ArticleType::class, $article);
       
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('single', ['id' => $article->getid()]);
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'EditMod' => $article->getId() !== null
        ]);
    }

    /** 
     * @Route("/blog/{id}", name="single")
    */

    public function single(Article $article)
    {
        return $this->render('blog/single.html.twig', [
            'article' => $article
        ]);
    }


}
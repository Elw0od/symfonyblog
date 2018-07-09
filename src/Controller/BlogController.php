<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Repository\ArticleRepository;

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
     */
    public function create(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, [
                         'attr' => [
                             'label' => 'Titre',
                             'placeholder' => "Titre de l'article"
                         ]
                     ])
                     ->add('content', TextareaType::class, [
                        'attr' => [
                            'placeholder' => "Contenue de l'article"
                        ]
                    ])
                     ->add('image', TextType::class, [
                        'attr' => [
                            'placeholder' => "Contenue de l'article"
                        ]
                     ])
                     ->getForm();
        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()
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
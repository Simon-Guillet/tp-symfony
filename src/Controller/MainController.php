<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $articles =$this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('main/index.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        $articles =$this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('main/about.html.twig');
    }
    /**
     * @Route("/post", name="post")
     */
    public function post(): Response
    {
        return $this->render('main/post.html.twig');
    }
    /**
     * @Route("/add", name="form")
     */
    public function form(Request $request): Response
    {
        $post = new Article();
        $post->setTitle('Titre');
        $post->setArticle('Article');
        $post->setAuthor('Auteur');
        $post->setCreatedAt(new \DateTime('now'));

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('article', TextType::class)
            ->add('author', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }

        return $this->render('main/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

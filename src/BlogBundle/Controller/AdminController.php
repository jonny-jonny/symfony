<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Blog;
use BlogBundle\Forms\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction(){
        return new Response("HERE");
    }
    public function blogAction(){
        $blogs = $this->getDoctrine()->getRepository("BlogBundle:Blog")->findAll();
        return $this->render("BlogBundle:Admin:blog-view.html.twig", [
            "blogs" => $blogs
        ]);
    }
    public function blogEditAction($id){
        return new Response($id);
    }
    public function blogAddAction(){
        $blog = new Blog();
        $form = $this->createForm( FormType::class, $blog );
        return $this->render("BlogBundle:Admin:blog-add.html.twig",[
            'form_add_blog' => $form->createView()
        ]);
    }
}
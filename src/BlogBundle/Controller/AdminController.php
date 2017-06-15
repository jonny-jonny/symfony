<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Blog;
use BlogBundle\Forms\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller{
    public function indexAction(){
        return new Response("HERE");
    }

    public function blogAction(Request $request){
        $blogRepository = $this->getDoctrine()->getRepository("BlogBundle:Blog");
        $totalBlog = $blogRepository->findAllBlogCount();
        $page = $request->query->get("page") && $request->query->get("page")  > 1 ? $request->query->get("page") : 1 ;
        $blogs = $blogRepository->findBlog(["page" => $page, "max_result" => 10]);
        $pagination = [
            "total" => array_shift($totalBlog),
            "page" => $page,
            "max_result" => 10,
            "url" => "admin_blog"
        ];
        return $this->render("BlogBundle:Admin:blog-view.html.twig", [
            "blogs" => $blogs,
            "pagination" => $pagination
        ]);
    }

    public function blogEditAction($id, Request $request){
        $em = $this->getDoctrine();
        $blog = $em->getRepository("BlogBundle:Blog")->find($id);
        if(!$blog){
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $form = $this->createForm(  FormType::class, $blog );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('admin_blog');
        }
        return $this->render("BlogBundle:Admin:blog-edit.html.twig", [
            'form_edit_blog' => $form->createView()
        ]);
    }
    public function blogAddAction( Request $request ){
        $blog = new Blog();
        $form = $this->createForm( FormType::class, $blog );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('admin_blog');
        }

        return $this->render("BlogBundle:Admin:blog-add.html.twig", [
            'form_add_blog' => $form->createView()
        ]);
    }
}
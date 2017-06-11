<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    public function homepageAction(){
        return $this->render("::base.html.twig");
    }

    public function blogViewAction($id){
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository("BlogBundle:Blog");
        $blog = $blogRepository->find($id);
        return $this->render("BlogBundle:Blog:view.html.twig", [
            'blog' => $blog
        ]);
    }

    public function teaserAction( Request $request){
        $em = $this->getDoctrine();
        $blogRepository = $em->getRepository("BlogBundle:Blog");
        $totalBlog=$blogRepository->findAllBlogCount();
        $page = $request->query->get("page") && $request->query->get("page") >1 ? $request->query->get("page") : 1;
        $blogs = $blogRepository->findBlog(["page"=>$page]);
        $pagination = [
            "total" => array_shift($totalBlog),
            "page" => $page,
            "max_result" => 5,
            "url" => "blog_teaser"
        ];
        return $this->render("BlogBundle:Blog:teaser.html.twig", [
            "blogs" => $blogs,
            "pagination" => $pagination
        ]);
    }
}
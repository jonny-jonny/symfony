<?php
namespace BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository{

    public function findAllBlogCount(){
        $qry = $this->createQueryBuilder("b");
        $qry->select("count(b)");
        return $qry->getQuery()->getOneOrNullResult();
    }

    public function findBlog(array $context = []){
        $qry = $this->createQueryBuilder("b");
        $qry->select("b");
        $maxResult = 5;
        if(isset($context["max_result"]) && $context["max_result"] > 1){
            $maxResult = $context["max_result"];
        }
        $qry->setMaxResults($maxResult);
        $qry->orderBy("b.id", "DESC");
        $page = 0;
        if(isset($context["page"]) && is_numeric($context["page"]) && $context["page"] > 1){
            $page = 5 * ($context["page"]-1);
        }
        $qry->setFirstResult($page);
        return $qry->getQuery()->getResult();
    }
}
<?php

namespace BlogBundle\DataFixtures\ORM;

use BlogBundle\Entity\Blog;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $blog = new Blog();
        $blog->setTitle("This is tenth title");
        $blog->setBody("<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>");

        $blog->setSummary("<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>");
        $manager->persist($blog);
        $manager->flush();
    }
}
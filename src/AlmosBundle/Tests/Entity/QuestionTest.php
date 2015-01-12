<?php

namespace AlmosBundle\Tests\Entity;

use AlmosBundle\Entity\Question;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $blog = new Question();

        $this->assertEquals('hello-world', $blog->slugify('Hello World'));
        $this->assertEquals('a-day-with-symfony2', $blog->slugify('A Day With Symfony2'));
        $this->assertEquals('hello-world', $blog->slugify('Hello    world'));
        $this->assertEquals('symblog', $blog->slugify('symblog '));
        $this->assertEquals('symblog', $blog->slugify(' symblog'));
    }

    public function testSetTitle()
    {
        $blog = new Question();

        $blog->setTitle('Hello World');
        $this->assertEquals('hello-world', $blog->getSlug());
    }

}
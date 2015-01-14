<?php

namespace AlmosBundle\Form;

use AlmosBundle\Entity\Comment;
use AlmosBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('comment')

        ;
    }


    public function getName()
    {
        return 'almosbundle_comment';
    }



}

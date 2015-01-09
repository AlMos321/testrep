<?php

namespace AlmosBundle\Form;

use AlmosBundle\Entity\Comment;
use AlmosBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('comment', 'entity', array(
        'multiple' => true,
        'class'    => 'AlmosBundle:Question',
        'property' => 'first',))

            ->add('approved')
            ->add('created')
            ->add('updated')
            ->add('question')

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AlmosBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'almosbundle_comment';
    }


}

<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindClan extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('region', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices' => array(
                    'EU' => 'EU',
                    'RU' => 'RU'
                ),
                'choices_as_values' => true,
            ))
            ->add('clantag', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('send', 'Symfony\Component\Form\Extension\Core\Type\SubmitType');
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundlefind_clan';
    }
}

<?php

namespace App\Form;

use App\Entity\PatternType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MotifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Motif',TextType::class,[
            'attr' => ['class' => 'form-control'],
            // 'required' => false
        ])
        

        ;
    }                            


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatternType::class,
        ]);
    }
}

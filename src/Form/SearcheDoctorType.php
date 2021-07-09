<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearcheDoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('doctor',TextType::class,[
            'required'=>false,
            'label'=>false,
            'attr'=>[
                'placeholder'=>'Searche.SearcheDoctor',
                'class' => 'form-control '

                    ]
            ])
            ->add('willaya',TextType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Searche.SearcheWilaya',
                    'class' => 'form-control',
                    'class' => 'form-control  willaya'
                        ]
                ])
                ->add('page',HiddenType::class,[
                    'required'=>false,
                    'label'=>false,
                    'data' => 1
                    ])
            
                ->add('submit',SubmitType::class ,[
                    'label' => 'Searche.Research',
                    'attr' => array('class' => 'btn btn-light btn-block')

                ])


   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' =>false,
            'attr' => [
                'class' => 'willaya'
            ]

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}

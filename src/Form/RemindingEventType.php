<?php

namespace App\Form;

use App\Entity\RemindingEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RemindingEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('username', TextType::class,['required'=>false,
             'attr' => ['class' => 'form-control'],
             'mapped' => false,

             ]
             )
            ->add('startDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control',
                'style'=> 'width:170px;margin-left: -24px'],
                'widget' => 'single_text',            
                'html5' => false,

               ])  
               ->add('endDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'html5' => false,

               ])           
            ->add('body',TextareaType::class,[
            'required'=>true,
            'attr' => ['class' => 'form-control','rows' =>4],
            
            ]
            )
            ->add('state', ChoiceType::class,[
                'attr' => ['class' => 'browser-default custom-select'],

                'choices' => [                                       
                    'calendar_Reminding.emergency' => 'urgence',
                    'calendar_Reminding.intermediate' => 'intermédiaire',
                    'calendar_Reminding.important' => 'important']
            ]
            )						


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RemindingEvent::class,
        ]);
    }
}

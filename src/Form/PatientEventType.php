<?php

namespace App\Form;

use App\Entity\PatientEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PatientEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('startDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'html5' => false,
            ])
            ->add('motifid',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'mapped' => false,

            ])
//            ->add('endDatetime')
            // ->add('allDay')
            // ->add('bgColor')
            // ->add('fgColor')
            // ->add('cssClass')
             ->add('username',TextType::class,[
                 'mapped' => false,
                 'attr' => ['class' => 'form-control']
                ])
           // ->add('calendar')
            //->add('patient')
            //->add('doctor')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatientEvent::class,
        ]);
    }
}

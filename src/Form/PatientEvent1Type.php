<?php

namespace App\Form;

use App\Entity\PatientEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PatientEvent1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('startDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'html5' => false,
        
            ])    
            ->add('motifid',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'mapped' => false,

            ])        
            //->add('endDatetime')
           // ->add('bgColor')
            // ->add('fgColor')
           // ->add('cssClass')
            /*->add('motifid',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'mapped' => false,

            ])*/
             //->add('all_day')
            // ->add('calendar')
            // ->add('submit',SubmitType::class )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PatientEvent::class,
        ]);
    }
}

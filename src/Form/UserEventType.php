<?php

namespace App\Form;

use App\Entity\UserEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class UserEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr' => ['class' => 'form-control'],
                // 'required' => false
            ])
            ->add('startDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'html5' => false,

        
            ])
            ->add('endDatetime', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'html5' => false,

        
            ])
            ->add('bgColor',ColorType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('fgColor',ColorType::class, [
                'attr' => ['class' => 'form-control']
            ]) 
                ->add('week', ChoiceType::class, array(
                    'choices' => array(
                        'Sam' => 'Saturday',
                        'Dima' => 'Sunday',
                        'Lun' => 'Monday',
                        'Mar' => 'Tuesday',
                        'Merc' => 'Wednesday',
                        'Jeu' => 'Thursday',
                        'Ven' => 'Friday',
                         ),
                    'mapped' => false,
                    'multiple' => true,
                    'expanded' => true,

                        ))
                        ->add('period', ChoiceType::class, array(
                            'choices' => array(
                                '1 jour' => '1',
                                '7 jour' => '7',
                                '15 jour' => '15',
                                '21 jour' => '21',
                                '30 jour' => '30',
                                '45 jour' => '45',
                                '60 jour' => '60',
                                '90 jour' => '90',
                                 ),
                            'mapped' => false,
                            'multiple' => false,
                            'expanded' => true,
        
                                ))

 

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserEvent::class,
        ]);
    }
}

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ProfileType extends AbstractType
{
    private $authorization;
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorization = $authorizationChecker;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
        ->remove('username')
        ->add('lastname', TextType::class)
        //->add('lastName', TextType::class)
        ->add('firstName', TextType::class)

        ->add('imageFile',FileType::class,['required'=>false])
        ->add('birthDate',DateType::class, [

            'widget' => 'single_text',
        ])
        ->add('birthPlace', TextType::class)
        ->add('address', TextType::class)
        ->add('gender', ChoiceType::class, [
            'choices' => ['ProfileType.gender.choices.Women' => 'Femme', 'ProfileType.gender.choices.Man' => 'Homme'],
            'placeholder' => 'ProfileType.gender.placeholder',
            'attr' => ['class' => 'form-control',
            'style'=> 'display: block !important'],
        ])        ->add('phone', TextType::class);

        if ($this->authorization->isGranted('ROLE_SUPER_ADMIN')) {}
            elseif ($this->authorization->isGranted('ROLE_ADMIN')) {
                $builder->add('numProf')
                ->add('company', TextType::class)
                ->add('title', TextType::class);
        }            elseif ($this->authorization->isGranted('ROLE_USER')) {
            $builder->add('numCartechifae')
            ->add('EmergencyPhone')
            ->add('profession')
            ->add('bloodGroup')
            ->add('profession')
            ->add('origin')
            ->add('referencedBy')
            ->add('fax')
            ->add('familyStatus')
;
                    };

    ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }


    
}
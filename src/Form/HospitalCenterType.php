<?php

namespace App\Form;

use App\Entity\HospitalCenter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class HospitalCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('type', ChoiceType::class, [
                     'choices' => [
                        'HospitalCenterType.gender.Type_Establishments.doctors_office' => 'cabinet',
                        'HospitalCenterType.gender.Type_Establishments.group_medical_office' => 'cabinet de groupe',
                        'HospitalCenterType.gender.Type_Establishments.clinical' => 'clinique',
                        'HospitalCenterType.gender.Type_Establishments.radiology_center' => 'centre de radiologie',
                                ],
                    'placeholder' => 'HospitalCenterType.gender.placeholder',
                    'attr' => ['class' => 'form-control',
                    'style'=> 'display: block !important'],
                 ])
            ->add('phone')
            ->add('town')
            ->add('description')
            ->add('fax')
            ->add('webSite')
            ->add('wilaya', ChoiceType::class, [
                'choices' => [
                'HospitalCenterType.gender.wilaya.Adrar'               => 'Adrar',
                'HospitalCenterType.gender.wilaya.Chlef'               => 'Chlef',
                'HospitalCenterType.gender.wilaya.Laghouat'            => 'Laghouat',
                'HospitalCenterType.gender.wilaya.Oum_bouaghi'         => 'Oum bouaghi',
                'HospitalCenterType.gender.wilaya.Batna'               => 'Batna',
                'HospitalCenterType.gender.wilaya.Bejaia'              => 'Bejaia',
                'HospitalCenterType.gender.wilaya.Biskra'              => 'Biskra',
                'HospitalCenterType.gender.wilaya.Bechar'              => 'Bechar',
                'HospitalCenterType.gender.wilaya.Blida'               => 'Blida',
                'HospitalCenterType.gender.wilaya.Bouira'              => 'Bouira',
                'HospitalCenterType.gender.wilaya.Tamanrasset'         => 'Tamanrasset',
                'HospitalCenterType.gender.wilaya.Tebessa'             => 'Tebessa',
                'HospitalCenterType.gender.wilaya.Tlemcen'             => 'Tlemcen',
                'HospitalCenterType.gender.wilaya.Tiaret'              => 'Tiaret',
                'HospitalCenterType.gender.wilaya.Tizi_ouzou'          => 'Tizi ouzou',
                'HospitalCenterType.gender.wilaya.Alger'               => 'Alger',
                'HospitalCenterType.gender.wilaya.Djelfa'              => 'Djelfa',
                'HospitalCenterType.gender.wilaya.Jijel'               => 'Jijel',
                'HospitalCenterType.gender.wilaya.Setif'               => 'Setif',
                'HospitalCenterType.gender.wilaya.Saida'               => 'Saida',
                'HospitalCenterType.gender.wilaya.Skikda'              => 'Skikda',
                'HospitalCenterType.gender.wilaya.Sidi_Bel_Abbes'      => 'Sidi Bel Abbes',
                'HospitalCenterType.gender.wilaya.Annaba'              => 'Annaba',
                'HospitalCenterType.gender.wilaya.Guelma'              => 'Guelma',
                'HospitalCenterType.gender.wilaya.Constantine'         => 'Constantine',
                'HospitalCenterType.gender.wilaya.Medea'               => 'Medea',
                'HospitalCenterType.gender.wilaya.Mostaganem'          => 'Mostaganem',
                'HospitalCenterType.gender.wilaya.Msila'               => 'M\'sila',
                'HospitalCenterType.gender.wilaya.Mascara'             => 'Mascara',
                'HospitalCenterType.gender.wilaya.Ouargla'             => 'Ouargla',
                'HospitalCenterType.gender.wilaya.Oran'                => 'Oran',
                'HospitalCenterType.gender.wilaya.El_Baydh'            => 'El Baydh',
                'HospitalCenterType.gender.wilaya.Illizi'              => 'Illizi',
                'HospitalCenterType.gender.wilaya.Bordj_Bou_Arreridj'  => 'Bordj Bou Arreridj',
                'HospitalCenterType.gender.wilaya.Boumerdes'           => 'Boumerdes',
                'HospitalCenterType.gender.wilaya.El_Taref'            => 'El Taref',
                'HospitalCenterType.gender.wilaya.Tindouf'             => 'Tindouf',
                'HospitalCenterType.gender.wilaya.Tissemsilt'          => 'Tissemsilt',
                'HospitalCenterType.gender.wilaya.El_Oued'             => 'El Oued',
                'HospitalCenterType.gender.wilaya.Khenchla'            => 'Khenchla',
                'HospitalCenterType.gender.wilaya.Souk_Ahrass'         => 'Souk Ahrass',
                'HospitalCenterType.gender.wilaya.Tipaza'              => 'Tipaza',
                'HospitalCenterType.gender.wilaya.Mila'                => 'Mila',
                'HospitalCenterType.gender.wilaya.Aïn_Defla'           => 'Aïn Defla',
                'HospitalCenterType.gender.wilaya.Nâama'               => 'Nâama',
                'HospitalCenterType.gender.wilaya.Aïn_Temouchent'      => 'Aïn Temouchent',
                'HospitalCenterType.gender.wilaya.Ghardaïa'            => 'Ghardaïa',
                'HospitalCenterType.gender.wilaya.Relizane'            => 'Relizane'
                        ],
                'placeholder' => 'HospitalCenterType.gender.placeholder',
                'attr' => ['class' => 'form-control',
                'style'=> 'display: block !important'],
            ])

  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HospitalCenter::class,
        ]);
    }
}

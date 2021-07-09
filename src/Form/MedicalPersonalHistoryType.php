<?php

namespace App\Form;

use App\Entity\MedicalPersonalHistory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MedicalPersonalHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('allergies')
            ->add('medicalHistories')
            ->add('surgicalHistories')
            ->add('traumaticHistories')
            ->add('obstetricalHistories')
            ->add('psychomotorDevelopment')
            ->add('familysurgical')
            ->add('familymedical')
            ->add('psychiatric')
            ->add('toxic')
            ->add('prison')
            ->add('trauma')
            ->add('summary')
            ->add('menarche')
            ->add('menopause')
            ->add('parity')
            ->add('gravidity')
            ->add('cycle')
            ->add('dysmenorrhea')
            ->add('dyspareunia')
            ->add('abundance')
            ->add('menstruationDuration')
            ->add('other')
            ->add('initialWeight')
            ->add('cesarean')
            ->add('abortion')
            ->add('contraceptionType')

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MedicalPersonalHistory::class,
        ]);
    }
}

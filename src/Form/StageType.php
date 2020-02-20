<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('descMission')
            ->add('mail')
            ->add('entreprise',EntrepriseType::class)
            //->add('formations')
            ->add('formations', EntityType::class, [ 'class'=>Formation::class,
                                                    'choice_label'=>'nom',
                                                    'expanded'=>true,
                                                    'multiple'=>true]
                );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}

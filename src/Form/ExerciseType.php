<?php

namespace App\Form;

use App\Entity\Exercise;
use App\Entity\ExerciseTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('intervals')
            ->add(
                'intervals',
                IntegerType::class,
                [
                    'label' => '# of intervals in 1 minute exercise',
                    'attr' => ['min' => 1, 'max' => 6],
                    'required' => false
                ]
            )
            ->add('isPrivate')
            ->add(
                'tags',
                EntityType::class,
                [
                    'class' => ExerciseTag::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'Tags',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}

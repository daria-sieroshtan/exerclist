<?php

namespace App\Form;

use App\Entity\Exercise;
use App\Entity\WorkoutExercise;
use App\Repository\ExerciseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class WorkoutExerciseEmbeddedForm extends AbstractType
{
    private $userId;

    public function __construct(Security $security)
    {
        $this->userId = $security->getUser()->getId();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'sequentialNumber',
                IntegerType::class,
                [
                    'label' => 'index',
                    'attr' => ['min' => 1],
                ]
            )
            ->add(
                'exercise',
                EntityType::class,
                [
                    'class' => Exercise::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'query_builder' => function (ExerciseRepository $repo) {
                        return $repo->findListForWorkoutCreation($this->userId);
                    }
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkoutExercise::class,
        ]);
    }
}

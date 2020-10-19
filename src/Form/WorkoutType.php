<?php

namespace App\Form;

use App\Entity\Workout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class WorkoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('workoutExercises',CollectionType::class, [
                'entry_type' => WorkoutExerciseEmbeddedForm::class,
                'allow_delete' => true,
                'allow_add' => true,
                'delete_empty' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('isPrivate')
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data['workoutExercises'] = array_values($data['workoutExercises']);
        foreach($data['workoutExercises'] as $key => $value) {
            if(!array_key_exists('exercise', $value) || $value['exercise'] == "") {
                unset($data['workoutExercises'][$key]);
            }
        }
        $event->setData($data);
    }
}

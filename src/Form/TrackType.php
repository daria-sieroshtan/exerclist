<?php

namespace App\Form;

use App\Entity\Track;
use App\Entity\TrackTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('author')
            ->add('isPrivate')
            ->add(
                'tags',
                EntityType::class,
                [
                    'class' => TrackTag::class,
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
            'data_class' => Track::class,
        ]);
    }
}

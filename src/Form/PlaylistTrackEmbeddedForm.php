<?php

namespace App\Form;

use App\Entity\PlaylistTrack;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PlaylistTrackEmbeddedForm extends AbstractType
{
    private $userId;

    public function __construct(Security $security)
    {
        $this->userId = $security->getUser()->getId();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sequentialNumber', IntegerType::class,
                [
                    'label' => 'index',
                    'attr' => ['min' => 1],
                ])
            ->add('track',EntityType::class,
                [
                    'class' => Track::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'query_builder' => function(TrackRepository $repo) {
                        return $repo->findListForPlaylistCreation($this->userId);
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlaylistTrack::class,
        ]);
    }
}

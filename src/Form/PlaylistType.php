<?php

namespace App\Form;

use App\Entity\Playlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('playlistTracks',CollectionType::class, [
                'entry_type' => PlaylistTrackEmbeddedForm::class,
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
            'data_class' => Playlist::class,
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $data['playlistTracks'] = array_values($data['playlistTracks']);
        foreach($data['playlistTracks'] as $key => $value) {
            if(!array_key_exists('track', $value) || $value['track'] == "") {
                unset($data['playlistTracks'][$key]);
            }
        }
        $event->setData($data);
    }
}

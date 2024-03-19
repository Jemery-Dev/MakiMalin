<?php

namespace App\Form;

use App\Entity\ListeCollaborative;
use App\Entity\ListeDeCourses;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListeCollaborativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('liste', EntityType::class, [
                'class' => ListeDeCourses::class,
                'choice_label' => 'id',
            ])
            ->add('utilisateur_id', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListeCollaborative::class,
        ]);
    }
}

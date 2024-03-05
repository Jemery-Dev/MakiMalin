<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'toggle' => true, // On ajoute tout ça pour pouvoir afficher/masquer le password
                'hidden_label' => 'Masquer',
                'visible_label' => 'Afficher',
                'visible_icon' => null,
                'hidden_icon' => null,
                'attr' => ['autocomplete' => 'new-password'], // On laisse l'option google pour avoir un mot de passe pré-défini
                'constraints' => [
                    new NotBlank([ // Contrainte si le mot n'existe pas
                        'message' => 'Entrer un mot de passe',
                    ]), 
                    new Length([ // Contrainte pour la taille 
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins 6 caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('plainPasswordConfirm', PasswordType::class, [ // On ajoute une confirmation de mot de passe
                'label' => 'Confirmer le mot de passe',
                'mapped' => false, // Même propriété
                'toggle' => true,
                'hidden_label' => 'Masquer',
                'visible_label' => 'Afficher',
                'visible_icon' => null,
                'hidden_icon' => null,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Confirmer votre mot de passe',
                    ]),
                    new EqualTo([ // On ajoute une contrainte EqualTo qui vérifie si plainPassword = plainPasswordConfirm
                        'propertyPath' => 'plainPassword', // La valeur qu'on compare
                        'message' => 'Les mots de passe ne correspondent pas', // Le message en cas de pas égal
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

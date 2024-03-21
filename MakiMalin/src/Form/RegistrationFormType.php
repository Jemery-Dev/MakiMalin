<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use App\Entity\Utilisateur;
use Symfony\Component\Validator\Constraints\Callback;
use ExecutionContextInterface;


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
                ],
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
        
                $plainPassword = $form["plainPassword"]->getData();
                $plainPasswordConfirm = $form["plainPasswordConfirm"]->getData();

                if ($plainPassword !== $plainPasswordConfirm) {
                    $form->get('username')->clearErrors();
                    $form->get('plainPassword')->clearErrors();
                    $form["plainPasswordConfirm"]->addError(new FormError('Les mots de passes ne correspondent pas'));
                }
            })

            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                
                if (!empty($data['username'])){
                    $form->get('username')->clearErrors();
                }

                if (!empty($data['plainPassword']) || !empty($data['plainPasswordConfirm'])) {

                    $form->get('plainPasswordConfirm')->clearErrors();
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'validation_groups'=> ['Default'],
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File as FileConstraint;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Please enter your name'),
                ],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Please enter your firstname'),
                ],
            ])
            ->add('licenceNumber', TextType::class, [
                'mapped' => false,
                'required' => false, 
                'label' => 'Votre Numéro de Licence',
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'Photo de Profil (optionnel)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new FileConstraint([
                        'maxSize' => '2M', 
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Merci d\'Uploader une image valide (Format : JPEG, PNG, WEBP)',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue(
                        message: 'You should agree to our terms.',
                    ),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter a password',
                    ),
                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        max: 4096,
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

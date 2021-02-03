<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom complet'],
                'required' => true
            ])
            ->add('email', EmailType::class, [
                "label" => false,
                "attr" => ["placeholder" => "Votre email"],
                "required" => true
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" => "Accepter les conditions d'utilisation",
                "required" => true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                "required" => true,
                'invalid_message' => 'Les mots de passe ne sont pas identiques !',
                'first_options'  => ['attr' => ["placeholder" => "Mot de passe"], "label" => false],
                'second_options' => ['attr' => ["placeholder" => "Répéter le mot de passe"], "label" => false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

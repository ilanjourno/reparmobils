<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "required" => true,
                "attr" => ['placeholder' => 'Votre nom'],
                'label' => false
            ])
            ->add('email', EmailType::class, [
                "required" => true,
                "attr" => ['placeholder' => 'Votre email'],
                'label' => false,
            ])
            ->add('subject', TextType::class, [
                "required" => true,
                "attr" => ['placeholder' => 'Entrez un sujet'],
                'label' => false
            ])
            ->add('content', TextareaType::class, [
                "required" => true,
                "attr" => ['placeholder' => 'Votre message'],
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

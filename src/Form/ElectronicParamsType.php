<?php

namespace App\Form;

use App\Entity\ElectronicParams;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElectronicParamsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom : <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                   'Couleur(s)' => 'colors',
                   'Texte' => 'text'
                ],
                'label' => 'Type de paramètre : <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'placeholder' => ''
            ])
            ->add('multipleOrNot', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Choix multiple ? <span class="text-danger">*</span>',
                'label_html' => true,
                'placeholder' => '',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElectronicParams::class,
        ]);
    }
}

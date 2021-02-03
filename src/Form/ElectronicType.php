<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Electronic;
use App\Entity\ElectronicCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElectronicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, [
                'class' => Mark::class,
                'label' => 'La marque: <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true
            ])
            ->add('category', EntityType::class, [
                'class' => ElectronicCategory::class,
                'label' => 'La catégorie : <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom : <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Electronic::class,
        ]);
    }
}

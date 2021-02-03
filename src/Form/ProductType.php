<?php

namespace App\Form;

use App\Entity\Electronic;
use App\Entity\Product;
use App\Entity\ElectronicCategory;
use App\Repository\ElectronicRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('electronics', EntityType::class, [
                'class' => Electronic::class,
                'multiple' => true,
                'query_builder' => function(ElectronicRepository $respository){
                    return $respository->createQueryBuilder('e')
                    ->where('e.id = :val')->setParameter('val', '0');
                },
                'label' => 'Appareils <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => ['class' => 'ui fluid search dropdown'],
                'required' => true
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom <span class="text-danger">*</span> :',
                'label_html' => true,
                'required' => true,
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix <span class="text-danger">*</span> :',
                'label_html' => true,
                'required' => true
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité disponible <span class="text-danger">*</span> :',
                'label_html' => true,
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Petite description :',
                'required' => false,
            ])
            ->add('complet_description', TextareaType::class, [
                'label' => 'Grande description :',
                'required' => false,
            ])
            ->add('files', FileType::class, [
                'multiple' => true,
                'row_attr' => ['class' => 'd-none'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

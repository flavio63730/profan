<?php

namespace App\Form;

use App\Entity\SupportSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SupportSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('reference', TextType::class, [
                'required' => false,
            ])*/
            ->add('quantite', IntegerType::class, [
                'required' => false,
            ])
            ->add('couleur', TextType::class, [
                'required' => false,
            ])
            ->add('format', TextType::class, [
                'required' => false,
            ])
            ->add('grammage', IntegerType::class, [
                'required' => false,
            ])
            ->add('materiel', TextType::class, [
                'required' => false,
            ])
            ->add('type', TextType::class, [
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SupportSearch::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Liquide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LiquideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, [
                'required' => true,
            ])
            ->add('nom', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('quantite', IntegerType::class, [
                'required' => true,
            ])
            ->add('couleur', TextType::class)
            ->add('format', TextType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'choix_1' =>  "choix_1",
                    'choix_2' =>  "choix_2",
                ],
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liquide::class,
        ]);
    }
}

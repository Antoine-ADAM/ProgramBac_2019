<?php

namespace App\Form;

use App\Entity\Identity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>"Titre"
            ])
            ->add('description',TextareaType::class,[
                "label"=>"Description"
            ])
            ->add('niveau',ChoiceType::class,[
                "choices"=>Identity::getChoice(Identity::Niveaux)
            ])
            ->add('matiere',ChoiceType::class,[
                "choices"=>Identity::getChoice(Identity::Matieres)
            ])
            ->add('is_public',CheckboxType::class,[
                "label"=>"Publié",
                "value"=>"1"
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}

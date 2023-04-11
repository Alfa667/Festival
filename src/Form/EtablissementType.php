<?php

namespace App\Form;

use App\Entity\Etablissement;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('tel')
            ->add('mail')
            ->add('type')
            ->add('user', UserType::class ) 
            ->add('lieu', LieuType::class ) 
            ->add('civiliteResponsable', ChoiceType::class ,[
                'choices' => [
                        'Mr' => 'Monsieur',
                        'Mme' => 'Madame',
                ],
            ] );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissement::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Bed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class BedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('size')
            ->add('price')
            ->add('timber')
            ->add('image', ChoiceType::class, [
                'choices'  => [
                    'sleigh' => 'sleigh.png',
                    'double' => 'double.png',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bed::class,
        ]);
    }
}

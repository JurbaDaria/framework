<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('name', TextType::class, [
            'label' => 'Name',
            'attr' => [
                'placeholder' => 'Введите имя',
                'id' => 'name',
            ],
        ])
        ->add('description', TextType::class, [
            'label' => 'Description',
            'attr' => [
                'placeholder' => 'Введите описание',
                'id' => 'description',
            ],
        ])
        ->add('result', CheckboxType::class, [
            'label' => 'Done',
        ])
        ->add('date', DateTimeType::class, [
            'label' => 'Day',
            'attr' => [
                'placeholder' => 'Введите дату',
                'id' => 'date',
            ],
        ])
        ->add('category', EntityType::class, [
            'label' => 'Category',
            'class' => Category::class,
            'choice_label' => 'name',
        ])
        ->add('submit', SubmitType::class);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
?>
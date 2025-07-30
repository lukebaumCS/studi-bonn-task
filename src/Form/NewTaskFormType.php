<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;

class NewTaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $team = $options['team'];

        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a Name'
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a description'
                    ]),
                ],
            ])
            ->add('user',EntityType::class, [
                'class'=> User::class,
                'choices' => $team -> getUsers(),
                'choice_label'=> fn(User $user) => $user -> getEmail(),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please Enter a User'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data-class' => Task::class,
            'team' => null, 
        ]);
    }
}
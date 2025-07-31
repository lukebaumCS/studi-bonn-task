<?php
namespace App\Form;

use App\Entity\TaskStatus;
use App\Form\NewTaskFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TaskEditFormType extends NewTaskFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // alle Felder aus der Elternklasse erben
        parent::buildForm($builder, $options);

        $builder->add('status', ChoiceType::class, [
            'choices' => [
                'Todo' => TaskStatus::TODO,
                'In Progress' => TaskStatus::IN_PROGRESS,
                'Done' => TaskStatus::DONE,
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please select a status',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
    }
}

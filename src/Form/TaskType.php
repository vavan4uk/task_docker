<?php


namespace App\Form;

use App\Entity\Task;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;


class TaskType extends AbstractType
{

    public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.title',
            ])
            ->add('comment', null, [
                'attr' => ['rows' => 20],
                'help' => 'help.task_comment',
                'label' => 'label.comment',
            ])
            ->add('dateAt', null, [
                'label' => 'label.date_at'
            ])
            ->add('timespent', null, [
                'attr' => ['min' => 0],
                'help' => 'help.task_timespent',
                'label' => 'label.timespent',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

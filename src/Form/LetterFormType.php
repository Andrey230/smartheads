<?php

namespace App\Form;

use App\Entity\Letter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Regex;

class LetterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pesel', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Your pesel',
                    'maxlength' => 11,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your PESEL',
                    ]),
                    new Length([
                        'min' => 11,
                        'max' => 11,
                        'exactMessage' => 'Your PESEL must be exactly 11 digits long',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'PESEL must contain only 11 digits',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Your email',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a email']),
                    new Email(['message' => 'Please enter a valid email address',]),
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Your name',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a name']),
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Your message',
                    'maxlength' => 255,
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'exactMessage' => 'Your message must be less that 255',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Letter::class,
        ]);
    }
}

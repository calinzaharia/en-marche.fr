<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BecomeAdherentType extends AbstractType implements FormTypeApiExposeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('comMobile')
            ->remove('firstName')
            ->remove('lastName')
            ->remove('emailAddress')
            ->remove('position')
            ->add('conditions', CheckboxType::class, [
                'required' => false,
            ])
            ->add('address', AddressType::class, [
                'label' => false,
                'child_error_bubbling' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => ['Update', 'Conditions'],
        ]);
    }

    public function getParent()
    {
        return AdherentType::class;
    }

    public static function getExposeKey(): string
    {
        return 'become-adherent';
    }
}

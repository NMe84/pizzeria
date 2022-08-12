<?php

/*
 * 706 Seating Group
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Order;
use App\Enum\NotificationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Voornaam',
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Achternaam',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mailadres',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefoonnummer',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefoonnummer',
                'required' => false,
            ])
            ->add('sendStatusUpdatesTo', ChoiceType::class, [
                'label' => 'Stuur statusupdates',
                'required' => false,
                'choices' => array_combine(NotificationType::ALL, NotificationType::ALL),
            ])
        ;
        if ($options['allow_delivery'] && $options['allow_pickup']) {
            $builder
                ->add('delivery', ChoiceType::class, [
                    'label' => 'Aflevermethode',
                    'choices' => [
                        'Ophalen' => false,
                        'Levering aan huis' => true,
                    ],
                    'required' => true,
                ])
            ;
        }

        if ($options['allow_delivery']) {
            $builder
                ->add('address', TextType::class, [
                    'label' => 'Adres',
                    'required' => !$options['allow_pickup'],
                ])
                ->add('postalCode', TextType::class, [
                    'label' => 'Postcode',
                    'required' => !$options['allow_pickup'],
                ])
                ->add('city', TextType::class, [
                    'label' => 'Plaats',
                    'required' => !$options['allow_pickup'],
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'allow_delivery' => true,
            'allow_pickup' => true,
        ]);
    }
}

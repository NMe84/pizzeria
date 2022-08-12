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

use App\Entity\PizzaBottom;
use App\Entity\PizzaTopping;
use App\Entity\Pizzeria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PizzaSelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pizzeria', EntityType::class, [
                'class' => Pizzeria::class,
                'label' => 'Pizzeria',
                'required' => true,
            ])
            ->add('bottom', EntityType::class, [
                'class' => PizzaBottom::class,
                'label' => 'Bottom',
                'required' => true,
            ])
            ->add('topping', EntityType::class, [
                'class' => PizzaTopping::class,
                'label' => 'Topping',
                'required' => true,
            ])
        ;
    }
}

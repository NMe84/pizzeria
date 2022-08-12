# Pizzeria programming skill test

## Introduction

This repository purely serves to show my programming skills and style. It is not a complete project and
it's downright inadvisable to use this as a basis for anything.

## Remarks

Because of time constraints I have not done everything that the assignment asked for in favour of better
fleshing out the things that I did do. Most notably, these things will be missing in this repository:

- Customers cannot see their order's status in the frontend. To add this I would have had to add a 
  security system with account creation and login and that seemed to be way out of scope for the
  assignment. I have instead included an in-memory user provider to protect the admin area to show
  that I know how Symfony's security works. I'm aware that it's not a good idea to store passwords
  in files that are committed to a repository, that's just something I did here to save time.
- There isn't much validation of input besides what the annotations on the entities enforce.
- I did not actually implement SMS notifications, but I put the framework for it there. Email notifications
  are present and will have to serve as an example. You'll find both in the EventSubscriber namespace.
- I put none of the logic there for switching the storage method, at least not beyond the default options
  Doctrine offers. Properly supporting a storage method that Doctrine does not natively support would
  require me to either write an entire Doctrine data provider or to make some sort of model definition that
  can proxy between Doctrine entities and the controller code, which would both have cost a lot more time
  than this assignment was meant to take.
- The unit tests are fairly pointless. I had no time left for a proper setup with DataFixtures and there
  really isn't much that is test-worthy in the system without them. But I wrote a couple assertions anyway.
- I have intentionally chosen to do a form without Symfony forms in the admin. Normally I'd have chosen
  to use Sonata Admin or something similar but I figured this would show more of what I can do.

## Requirements
My code requires PHP 8.1 to run.

## Installation
After checking out the code, run the following:

```bash
composer install
yarn install
yarn run encore production
```

Also make sure to set up your database config in a `.env.local` file or in an actual environment variable.

After that, set up the database using Doctrine or prefill it with the following (MySQL/MariaDB) for
testing purposes:

```mariadb
CREATE TABLE `order` (
    `id` int(11) NOT NULL,
    `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `delivery` tinyint(1) NOT NULL,
    `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` datetime NOT NULL,
    `send_status_updates_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `pizzeria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pizza` (
    `id` int(11) NOT NULL,
    `bottom_id` int(11) DEFAULT NULL,
    `topping_id` int(11) DEFAULT NULL,
    `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pizza_bottom` (
    `id` int(11) NOT NULL,
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pizza_bottom` (`id`, `name`) VALUES
    (1, 'Classic'),
    (2, 'Cheesy crust');

CREATE TABLE `pizza_topping` (
    `id` int(11) NOT NULL,
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pizza_topping` (`id`, `name`) VALUES
    (1, 'Margharita'),
    (2, 'Hawaii'),
    (3, 'Salami'),
    (4, 'Meat lovers'),
    (5, 'Veggie');

CREATE TABLE `pizzeria` (
    `id` int(11) NOT NULL,
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `delivery` tinyint(1) NOT NULL,
    `pickup` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pizzeria` (`id`, `name`, `delivery`, `pickup`) VALUES
    (1, 'Domino\'s', 1, 0),
    (2, 'New York Pizza', 0, 1),
    (3, 'Pizza Hut', 1, 1);

ALTER TABLE `order`
    ADD PRIMARY KEY (`id`),
    ADD KEY `IDX_F5299398F1965E46` (`pizzeria_id`);

ALTER TABLE `pizza`
    ADD PRIMARY KEY (`id`),
    ADD KEY `IDX_CFDD826F5EED6714` (`bottom_id`),
    ADD KEY `IDX_CFDD826FE9C2067C` (`topping_id`),
    ADD KEY `IDX_CFDD826F8D9F6D38` (`order_id`);

ALTER TABLE `pizza_bottom`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `pizza_topping`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `pizzeria`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `order` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pizza` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pizza_bottom` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `pizza_topping` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `pizzeria` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `order`
    ADD CONSTRAINT `FK_F5299398F1965E46` FOREIGN KEY (`pizzeria_id`) REFERENCES `pizzeria` (`id`);

ALTER TABLE `pizza`
    ADD CONSTRAINT `FK_CFDD826F5EED6714` FOREIGN KEY (`bottom_id`) REFERENCES `pizza_bottom` (`id`),
    ADD CONSTRAINT `FK_CFDD826F8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
    ADD CONSTRAINT `FK_CFDD826FE9C2067C` FOREIGN KEY (`topping_id`) REFERENCES `pizza_topping` (`id`);
```
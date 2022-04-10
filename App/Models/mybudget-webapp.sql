-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 30 Mar 2022, 20:01
-- Wersja serwera: 8.0.28
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `mybudget-webapp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `expenseCategoryAssignedToUserId` int NOT NULL,
  `paymentMethodAssignedToUserId` int NOT NULL,
  `expenseComment` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `dateOfExpense` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_assigned_to_users`
--

CREATE TABLE `expenses_category_assigned_to_users` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_assigned_to_users`
--

INSERT INTO `expenses_category_assigned_to_users` (`id`, `userId`, `name`) VALUES
(1, 1, 'food'),
(2, 1, 'house'),
(3, 1, 'transport'),
(4, 1, 'telecom'),
(8, 1, 'food'),
(9, 1, 'house'),
(10, 1, 'transport'),
(11, 1, 'telecom');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_default`
--

CREATE TABLE `expenses_category_default` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_persian_ci;

--
-- Zrzut danych tabeli `expenses_category_default`
--

INSERT INTO `expenses_category_default` (`id`, `name`) VALUES
(1, 'food'),
(2, 'house'),
(3, 'transport'),
(4, 'telecom');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `incomeCategoryAssignedToUserId` int NOT NULL,
  `incomeComment` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `dateOfIncome` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_assigned_to_users`
--

CREATE TABLE `incomes_category_assigned_to_users` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_assigned_to_users`
--

INSERT INTO `incomes_category_assigned_to_users` (`id`, `userId`, `name`) VALUES
(1, 1, 'salary'),
(2, 1, 'bank interest'),
(3, 1, 'trade'),
(4, 1, 'other'),
(8, 1, 'salary'),
(9, 1, 'bank interest'),
(10, 1, 'trade'),
(11, 1, 'other');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_default`
--

CREATE TABLE `incomes_category_default` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_default`
--

INSERT INTO `incomes_category_default` (`id`, `name`) VALUES
(1, 'salary'),
(2, 'bank interest'),
(3, 'trade'),
(4, 'other');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_assigned_to_users`
--

CREATE TABLE `payment_methods_assigned_to_users` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_assigned_to_users`
--

INSERT INTO `payment_methods_assigned_to_users` (`id`, `userId`, `name`) VALUES
(1, 1, 'cash'),
(2, 1, 'debit card'),
(3, 1, 'credit card'),
(4, 1, 'bitcoin'),
(8, 1, 'cash'),
(9, 1, 'debit card'),
(10, 1, 'credit card'),
(11, 1, 'bitcoin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_default`
--

CREATE TABLE `payment_methods_default` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_default`
--

INSERT INTO `payment_methods_default` (`id`, `name`) VALUES
(1, 'cash'),
(2, 'debit card'),
(3, 'credit card'),
(4, 'bitcoin');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `passwordResetHash` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `passwordResetExp` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `activationHash` varchar(150) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `isActive` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `passwordResetHash`, `passwordResetExp`, `email`, `activationHash`, `isActive`) VALUES
(1, 'MateuszR', '$2y$10$eZKDEPQGHRrAmxCLRqUVLewBy/numTDHAw4deSlA6upYjIyTp9MMC', NULL, NULL, 'mateuszrajczyk96@gmail.com', NULL, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

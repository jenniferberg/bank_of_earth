SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_of_earth`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounttransactions`
--

CREATE TABLE `accounttransactions` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `trans_amt` varchar(10) NOT NULL,
  `trans_date` datetime NOT NULL,
  `trans_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounttransactions`
--

INSERT INTO `accounttransactions` (`id`, `bank_id`, `trans_amt`, `trans_date`, `trans_type`) VALUES
(1, 1, '5087.39', '2017-09-01 12:30:00', 'Initial Deposit'),
(2, 2, '12000', '2017-10-08 17:45:00', 'Initial Deposit'),
(3, 1, '2.54', '2017-10-01 12:30:00', 'Interest'),
(4, 1, '2.54', '2017-10-31 12:30:00', 'Interest'),
(5, 2, '6', '2017-11-07 17:45:00', 'Interest'),
(6, 2, '400', '2017-11-15 15:34:13', 'Check Deposit'),
(7, 1, '50', '2017-11-15 15:37:47', 'Cash Deposit'),
(8, 1, '25', '2017-11-15 15:48:31', 'Withdrawal'),
(9, 1, '25', '2017-11-21 20:38:51', 'Cash Deposit'),
(10, 1, '400', '2017-11-27 00:52:04', 'Withdrawal'),
(11, 1, '1200', '2017-11-29 12:52:10', 'Transfer Withdrawal'),
(12, 2, '1200', '2017-11-29 12:52:10', 'Transfer Deposit');

-- --------------------------------------------------------

--
-- Table structure for table `bankaccounts`
--

CREATE TABLE `bankaccounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_no` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `balance` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankaccounts`
--

INSERT INTO `bankaccounts` (`id`, `user_id`, `account_no`, `type`, `balance`) VALUES
(1, 1, 101000001, 'Checking', '3542.47'),
(2, 1, 201000001, 'Savings', '13606');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `street_no` varchar(8) NOT NULL,
  `street` varchar(50) NOT NULL,
  `unit` varchar(8) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `street_no`, `street`, `unit`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 'John', 'Test', '01-987-654-3210', 'john@email.com', '$2y$10$6S5.11BXu.BBAp3SK1oa8uMVtDmTNJe4d02bH2YGCTvA/MqKqIq7W', '999', 'Sunshine Lane', 'A', 'San Diego', 'CA', 'USA', '92108');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounttransactions`
--
ALTER TABLE `accounttransactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttransactions`
--
ALTER TABLE `accounttransactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounttransactions`
--
ALTER TABLE `accounttransactions`
  ADD CONSTRAINT `accounttransactions_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `bankaccounts` (`id`);

--
-- Constraints for table `bankaccounts`
--
ALTER TABLE `bankaccounts`
  ADD CONSTRAINT `bankaccounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

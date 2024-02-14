-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 10:53 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `probasep_clientdb_ver3`
--

-- --------------------------------------------------------

--
-- Table structure for table `acquirer`
--

CREATE TABLE `acquirer` (
  `id` bigint(20) NOT NULL,
  `accessExodus` longtext DEFAULT NULL,
  `accountCreationDemoEndPoint` varchar(255) DEFAULT NULL,
  `accountCreationEndPoint` varchar(255) DEFAULT NULL,
  `acquirerCode` varchar(255) NOT NULL,
  `acquirerName` varchar(255) NOT NULL,
  `allowedCurrency` varchar(255) NOT NULL,
  `authKey` varchar(255) DEFAULT NULL,
  `balanceInquiryDemoEndPoint` varchar(255) DEFAULT NULL,
  `balanceInquiryEndPoint` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `demoAuthKey` longtext DEFAULT NULL,
  `demoServiceKey` longtext DEFAULT NULL,
  `fundsTransferDemoEndPoint` varchar(255) DEFAULT NULL,
  `fundsTransferEndPoint` varchar(255) DEFAULT NULL,
  `holdFundsYes` bit(1) NOT NULL,
  `isLive` bit(1) DEFAULT NULL,
  `serviceKey` longtext DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bank_id` bigint(20) DEFAULT NULL,
  `isDefault` tinyint(4) NOT NULL,
  `probasePayMerchantId` varchar(100) NOT NULL,
  `probasePayDeviceCode` varchar(100) NOT NULL,
  `probasePayApiKey` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_errors`
--

CREATE TABLE `app_errors` (
  `id` int(11) NOT NULL,
  `error_trace` longtext NOT NULL,
  `url` longtext NOT NULL,
  `error_dump` longtext NOT NULL,
  `user_username` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) NOT NULL,
  `access_exodus` varchar(255) DEFAULT NULL,
  `bank_code` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `countryOfOperationId` int(11) DEFAULT NULL,
  `is_funds_domiciled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billdata`
--

CREATE TABLE `billdata` (
  `id` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `token_data` longtext DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `response_data` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `isoCode` varchar(255) DEFAULT NULL,
  `mobileCode` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_requests`
--

CREATE TABLE `data_requests` (
  `id` int(11) NOT NULL,
  `request` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `response_from_server` longtext NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) NOT NULL,
  `countryId` bigint(20) DEFAULT NULL,
  `countryName` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `districtCode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `provinceId` bigint(20) DEFAULT NULL,
  `provinceName` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_price` double(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `keyword` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_purchased`
--

CREATE TABLE `item_purchased` (
  `id` int(11) NOT NULL,
  `item_key` varchar(40) NOT NULL,
  `quantity` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `card_pan` varchar(20) NOT NULL,
  `total_amount` double(10,2) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logindata`
--

CREATE TABLE `logindata` (
  `id` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` varchar(30) NOT NULL,
  `receipient_no` varchar(20) NOT NULL,
  `response` text NOT NULL,
  `message` varchar(310) NOT NULL,
  `success` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stanbic_promo_users`
--

CREATE TABLE `stanbic_promo_users` (
  `id` int(11) NOT NULL,
  `logged_by_user_id` int(11) NOT NULL,
  `customer_mobile` varchar(15) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `receipt_no` int(11) DEFAULT NULL,
  `status` enum('Uploaded','Approved') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `identity_id` int(11) NOT NULL,
  `file_data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_holders`
--

CREATE TABLE `temp_holders` (
  `id` int(11) NOT NULL,
  `temp_holder` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `datatest` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `datatest1` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_ref` varchar(20) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `payment_type` enum('Cash','Card') NOT NULL,
  `order_id` varchar(15) NOT NULL,
  `seller_user_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role_code` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remember_token` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_banking_group_member_contributions`
--

CREATE TABLE `village_banking_group_member_contributions` (
  `id` int(11) NOT NULL,
  `group_member_id` int(11) NOT NULL,
  `amount_due` double NOT NULL,
  `date_due` datetime NOT NULL,
  `status` enum('PENDING','PAID') NOT NULL DEFAULT 'PENDING',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `amount_paid` double NOT NULL DEFAULT 0,
  `charges_paid` double NOT NULL DEFAULT 0,
  `contribution_round_id` int(11) NOT NULL,
  `village_bank_group_id` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_groups`
--

CREATE TABLE `village_bank_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `group_public_key` longtext NOT NULL,
  `cooperative_code` varchar(100) NOT NULL,
  `cooperative_id` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `bg_color` varchar(20) NOT NULL,
  `is_open` tinyint(4) DEFAULT NULL,
  `groupDetails` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_contribution_receivers`
--

CREATE TABLE `village_bank_group_contribution_receivers` (
  `id` int(11) NOT NULL,
  `contribution_round_code` varchar(16) NOT NULL,
  `round_no` int(11) NOT NULL,
  `contribution_currency` varchar(6) NOT NULL,
  `payment_due_date` date NOT NULL,
  `amount_due` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `receiver_full_name` varchar(100) NOT NULL,
  `receiver_mobile_no` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_contribution_rounds`
--

CREATE TABLE `village_bank_group_contribution_rounds` (
  `id` int(11) NOT NULL,
  `contribution_round_code` varchar(10) NOT NULL,
  `amount_per_person` double NOT NULL,
  `interval_type` varchar(20) NOT NULL,
  `per_interval` int(11) NOT NULL,
  `village_banking_group_id` int(11) NOT NULL,
  `percentage_payable_to_members` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `contribution_currency` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_loans`
--

CREATE TABLE `village_bank_group_loans` (
  `id` int(11) NOT NULL,
  `group_member_id` int(11) NOT NULL,
  `group_member_full_name` varchar(30) NOT NULL,
  `group_member_mobile_number` varchar(20) NOT NULL,
  `loan_no` varchar(10) NOT NULL,
  `loan_amount` double NOT NULL,
  `interest_rate_per_day` double NOT NULL,
  `period` int(11) NOT NULL,
  `period_rate_type` varchar(10) NOT NULL,
  `expected_interest` double NOT NULL,
  `status` enum('PENDING','APPROVED','CLOSED','COMPLETED') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_loan_repayments`
--

CREATE TABLE `village_bank_group_loan_repayments` (
  `id` int(11) NOT NULL,
  `village_bank_group_id` int(11) NOT NULL,
  `village_bank_group_loan_id` int(11) NOT NULL,
  `amount_paid` double NOT NULL,
  `group_loan_repayment_structure_id` datetime NOT NULL,
  `group_member_id` int(11) NOT NULL,
  `interest_paid` double NOT NULL,
  `principal_paid` double NOT NULL,
  `village_bank_transaction_id` double NOT NULL,
  `paid_by_member_name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_loan_repayment_structure`
--

CREATE TABLE `village_bank_group_loan_repayment_structure` (
  `id` int(11) NOT NULL,
  `village_bank_group_id` int(11) NOT NULL,
  `village_bank_group_loan_id` int(11) NOT NULL,
  `amount_expected` double NOT NULL,
  `date_due` datetime NOT NULL,
  `group_member_id` int(11) NOT NULL,
  `interest_due` double NOT NULL,
  `principal_due` double NOT NULL,
  `interest_paid` double NOT NULL,
  `principal_paid` double NOT NULL,
  `group_member_name` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_members`
--

CREATE TABLE `village_bank_group_members` (
  `id` int(11) NOT NULL,
  `village_bank_group_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `role_type` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `smartcoops_member_code` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_settings`
--

CREATE TABLE `village_bank_group_settings` (
  `id` int(11) NOT NULL,
  `village_bank_group_id` int(11) NOT NULL,
  `settings` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `village_bank_group_timeline`
--

CREATE TABLE `village_bank_group_timeline` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acquirer`
--
ALTER TABLE `acquirer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mjnjjheg7n14qt13sqi047fxq` (`bank_id`);

--
-- Indexes for table `app_errors`
--
ALTER TABLE `app_errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_soonqy4whea3x538nojqh8hfd` (`countryOfOperationId`);

--
-- Indexes for table `billdata`
--
ALTER TABLE `billdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_requests`
--
ALTER TABLE `data_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_purchased`
--
ALTER TABLE `item_purchased`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logindata`
--
ALTER TABLE `logindata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stanbic_promo_users`
--
ALTER TABLE `stanbic_promo_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_holders`
--
ALTER TABLE `temp_holders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `village_banking_group_member_contributions`
--
ALTER TABLE `village_banking_group_member_contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_groups`
--
ALTER TABLE `village_bank_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_contribution_receivers`
--
ALTER TABLE `village_bank_group_contribution_receivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_contribution_rounds`
--
ALTER TABLE `village_bank_group_contribution_rounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_loans`
--
ALTER TABLE `village_bank_group_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_loan_repayments`
--
ALTER TABLE `village_bank_group_loan_repayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_loan_repayment_structure`
--
ALTER TABLE `village_bank_group_loan_repayment_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_members`
--
ALTER TABLE `village_bank_group_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_settings`
--
ALTER TABLE `village_bank_group_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `village_bank_group_timeline`
--
ALTER TABLE `village_bank_group_timeline`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acquirer`
--
ALTER TABLE `acquirer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_errors`
--
ALTER TABLE `app_errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billdata`
--
ALTER TABLE `billdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_banking_group_member_contributions`
--
ALTER TABLE `village_banking_group_member_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_groups`
--
ALTER TABLE `village_bank_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_contribution_receivers`
--
ALTER TABLE `village_bank_group_contribution_receivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_contribution_rounds`
--
ALTER TABLE `village_bank_group_contribution_rounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_loans`
--
ALTER TABLE `village_bank_group_loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_loan_repayments`
--
ALTER TABLE `village_bank_group_loan_repayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_loan_repayment_structure`
--
ALTER TABLE `village_bank_group_loan_repayment_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_members`
--
ALTER TABLE `village_bank_group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_settings`
--
ALTER TABLE `village_bank_group_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `village_bank_group_timeline`
--
ALTER TABLE `village_bank_group_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

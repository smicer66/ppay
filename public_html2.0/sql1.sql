USE [master]
GO
/****** Object:  Database [mfz_savings]    Script Date: 4/20/2021 1:19:41 PM ******/
CREATE DATABASE [mfz_savings]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'mfz_savings', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.MSSQLSERVER\MSSQL\DATA\mfz_savings.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'mfz_savings_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL13.MSSQLSERVER\MSSQL\DATA\mfz_savings_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
GO
ALTER DATABASE [mfz_savings] SET COMPATIBILITY_LEVEL = 130
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [mfz_savings].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [mfz_savings] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [mfz_savings] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [mfz_savings] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [mfz_savings] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [mfz_savings] SET ARITHABORT OFF 
GO
ALTER DATABASE [mfz_savings] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [mfz_savings] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [mfz_savings] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [mfz_savings] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [mfz_savings] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [mfz_savings] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [mfz_savings] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [mfz_savings] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [mfz_savings] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [mfz_savings] SET  ENABLE_BROKER 
GO
ALTER DATABASE [mfz_savings] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [mfz_savings] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [mfz_savings] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [mfz_savings] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [mfz_savings] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [mfz_savings] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [mfz_savings] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [mfz_savings] SET RECOVERY FULL 
GO
ALTER DATABASE [mfz_savings] SET  MULTI_USER 
GO
ALTER DATABASE [mfz_savings] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [mfz_savings] SET DB_CHAINING OFF 
GO
ALTER DATABASE [mfz_savings] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [mfz_savings] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [mfz_savings] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [mfz_savings] SET QUERY_STORE = OFF
GO
USE [mfz_savings]
GO
ALTER DATABASE SCOPED CONFIGURATION SET LEGACY_CARDINALITY_ESTIMATION = OFF;
GO
ALTER DATABASE SCOPED CONFIGURATION SET MAXDOP = 0;
GO
ALTER DATABASE SCOPED CONFIGURATION SET PARAMETER_SNIFFING = ON;
GO
ALTER DATABASE SCOPED CONFIGURATION SET QUERY_OPTIMIZER_HOTFIXES = OFF;
GO
USE [mfz_savings]
GO
/****** Object:  Table [dbo].[schema_migrations]    Script Date: 4/20/2021 1:19:41 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[schema_migrations](
	[version] [bigint] NOT NULL,
	[inserted_at] [datetime] NULL,
 CONSTRAINT [schema_migrations_pkey] PRIMARY KEY CLUSTERED 
(
	[version] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[_employer] [nvarchar](255) NULL,
	[companyId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_account]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_account](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountOfficerId] [int] NULL,
	[deactivatedReason] [nvarchar](255) NULL,
	[blockedReason] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[accountNo] [nvarchar](255) NULL,
	[externalId] [nvarchar](255) NULL,
	[productId] [int] NULL,
	[accountType] [nvarchar](255) NULL,
	[DateClosed] [date] NULL,
	[currencyId] [int] NULL,
	[currencyDecimals] [int] NULL,
	[currencyName] [nvarchar](255) NULL,
	[totalDeposits] [float] NULL,
	[totalWithdrawals] [float] NULL,
	[totalCharges] [float] NULL,
	[totalPenalties] [float] NULL,
	[totalInterestEarned] [float] NULL,
	[totalInterestPosted] [float] NULL,
	[totalTax] [float] NULL,
	[accountVersion] [float] NULL,
	[derivedAccountBalance] [float] NULL,
	[userId] [int] NULL,
	[blockedByUserId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[userRoleId] [int] NULL,
	[branchId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_account_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_account_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_account_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountId] [int] NULL,
	[chargeId] [int] NULL,
	[amountCharged] [float] NULL,
	[isPaid] [bit] NOT NULL,
	[dateCharged] [date] NULL,
	[datePaid] [date] NULL,
	[balance] [float] NULL,
	[userId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_account_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_addresses]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_addresses](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[addressLine1] [nvarchar](255) NULL,
	[addressLine2] [nvarchar](255) NULL,
	[city] [nvarchar](255) NULL,
	[districtId] [int] NULL,
	[districtName] [nvarchar](255) NULL,
	[provinceId] [int] NULL,
	[provinceName] [nvarchar](255) NULL,
	[countryId] [int] NULL,
	[countryName] [nvarchar](255) NULL,
	[isCurrent] [bit] NOT NULL,
	[userId] [int] NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_addresses_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_bank_staff_role]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_bank_staff_role](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[roleName] [nvarchar](255) NULL,
	[permissions] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_bank_staff_role_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_banks]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_banks](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[eod_url] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_banks_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_branch]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_branch](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[branchName] [nvarchar](255) NULL,
	[branchCode] [nvarchar](255) NULL,
	[isDefaultUSSDBranch] [bit] NOT NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_branch_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[chargeName] [nvarchar](255) NULL,
	[currency] [nvarchar](255) NULL,
	[currencyId] [int] NULL,
	[isPenalty] [bit] NOT NULL,
	[clientId] [int] NULL,
	[chargeType] [nvarchar](255) NULL,
	[chargeAmount] [float] NULL,
	[chargeWhen] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_client_telco]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_client_telco](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[telcoId] [int] NULL,
	[clientId] [int] NULL,
	[accountVersion] [float] NULL,
	[ussdShortCode] [nvarchar](255) NULL,
	[domain] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_client_telco_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_clients]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_clients](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[ussdCode] [nvarchar](255) NULL,
	[bankId] [int] NULL,
	[isBank] [bit] NOT NULL,
	[isDomicileAccountAtBank] [bit] NOT NULL,
	[countryId] [int] NULL,
	[accountCreationEndpoint] [nvarchar](255) NULL,
	[balanceEnquiryEndpoint] [nvarchar](255) NULL,
	[fundsTransferEndpoint] [nvarchar](255) NULL,
	[defaultCurrencyId] [int] NULL,
	[defaultCurrencyName] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[defaultCurrencyDecimals] [int] NULL,
	[clientName] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_clients_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_company]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_company](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[companyName] [nvarchar](255) NULL,
	[contactPhone] [nvarchar](255) NULL,
	[registrationNumber] [nvarchar](255) NULL,
	[taxNo] [nvarchar](255) NULL,
	[contactEmail] [nvarchar](255) NULL,
	[isEmployer] [bit] NULL,
	[isSme] [bit] NULL,
	[isOffTaker] [bit] NULL,
	[createdByUserId] [int] NULL,
	[createdByUserRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_company_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_confirmation_notification]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_confirmation_notification](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[message] [nvarchar](255) NULL,
	[read] [bit] NOT NULL,
	[recipientUserID] [int] NULL,
	[recipientUserRoleId] [int] NULL,
	[sentByUserId] [int] NULL,
	[sentByUserRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_confirmation_notification_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_country]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_country](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[country_file_name] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_country_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_currency]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_currency](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[isoCode] [nvarchar](255) NULL,
	[countryId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_currency_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_district]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_district](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[countryId] [int] NULL,
	[countryName] [nvarchar](255) NULL,
	[provinceId] [int] NULL,
	[provinceName] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_district_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_divestment_package]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_divestment_package](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[startPeriodDays] [int] NULL,
	[endPeriodDays] [int] NULL,
	[divestmentValuation] [float] NULL,
	[productId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_divestment_package_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_divestment_transactions]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_divestment_transactions](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[divestmentId] [int] NULL,
	[transactionId] [int] NULL,
	[amountDivested] [float] NULL,
	[interestAccrued] [float] NULL,
	[userId] [int] NULL,
	[userRoleId] [int] NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_divestment_transactions_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_divestments]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_divestments](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[fixedDepositId] [int] NULL,
	[principalAmount] [float] NULL,
	[fixedPeriod] [int] NULL,
	[interestRate] [float] NULL,
	[interestRateType] [nvarchar](255) NULL,
	[divestmentDate] [date] NULL,
	[divestmentDayCount] [int] NULL,
	[divestmentValuation] [float] NULL,
	[divestAmount] [float] NULL,
	[clientId] [int] NULL,
	[interestAccrued] [float] NULL,
	[userId] [int] NULL,
	[userRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_divestments_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_document_type]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_document_type](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[createdByUserId] [int] NULL,
	[deleted_at] [date] NULL,
	[description] [nvarchar](255) NULL,
	[documentFormats] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_document_type_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_employee]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_employee](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[companyId] [int] NULL,
	[employerId] [int] NULL,
	[userRoleId] [int] NULL,
	[userId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_employee_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_end_of_day]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_end_of_day](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[date_ran] [datetime] NULL,
	[total_interest_accrued] [float] NULL,
	[penalties_incurred] [float] NULL,
	[end_of_day_type] [nvarchar](255) NULL,
	[start_date] [datetime] NULL,
	[end_date] [datetime] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
	[status] [nvarchar](100) NULL,
	[currencyId] [int] NULL,
	[currencyName] [nchar](120) NULL,
 CONSTRAINT [tbl_end_of_day_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_end_of_day_entries]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_end_of_day_entries](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[end_of_day_id] [int] NULL,
	[interest_accrued] [float] NULL,
	[penalties_incurred] [float] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
	[fixed_deposit_id] [int] NULL,
	[status] [nvarchar](100) NULL,
	[currencyId] [int] NULL,
	[currencyName] [nchar](100) NULL,
	[end_of_day_date] [date] NULL,
 CONSTRAINT [tbl_end_of_day_entries_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_fixed_deposit]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_fixed_deposit](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountId] [int] NULL,
	[productId] [int] NULL,
	[principalAmount] [float] NULL,
	[fixedPeriod] [int] NULL,
	[fixedPeriodType] [nvarchar](255) NULL,
	[interestRate] [float] NULL,
	[interestRateType] [nvarchar](255) NULL,
	[expectedInterest] [float] NULL,
	[accruedInterest] [float] NULL,
	[isMatured] [bit] NOT NULL,
	[isDivested] [bit] NOT NULL,
	[divestmentPackageId] [int] NULL,
	[currencyId] [int] NULL,
	[currency] [nvarchar](255) NULL,
	[currencyDecimals] [int] NULL,
	[yearLengthInDays] [int] NULL,
	[totalDepositCharge] [float] NULL,
	[totalWithdrawalCharge] [float] NULL,
	[totalPenalties] [float] NULL,
	[userRoleId] [int] NULL,
	[userId] [int] NULL,
	[totalAmountPaidOut] [float] NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[clientId] [int] NULL,
	[divestmentId] [int] NULL,
	[branchId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
	[productInterestMode] [nvarchar](255) NULL,
 CONSTRAINT [tbl_fixed_deposit_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_fixed_deposit_transactions]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_fixed_deposit_transactions](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[fixedDepositId] [int] NULL,
	[transactionId] [int] NULL,
	[clientId] [int] NULL,
	[amountDeposited] [float] NULL,
	[userId] [int] NULL,
	[userRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_fixed_deposit_transactions_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_gl_account]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_gl_account](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountType] [nvarchar](255) NULL,
	[accountName] [nvarchar](255) NULL,
	[accountNumber] [nvarchar](255) NULL,
	[accountSubType] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[createdByUserId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_gl_account_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_journal_entry]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_journal_entry](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountId] [int] NULL,
	[userRoleId] [int] NULL,
	[userId] [int] NULL,
	[productType] [nvarchar](255) NULL,
	[isReversed] [bit] NOT NULL,
	[transactionId] [int] NULL,
	[reversedTransactionId] [int] NULL,
	[isSystemEntry] [bit] NOT NULL,
	[currency] [nvarchar](255) NULL,
	[currencyId] [int] NULL,
	[amount] [float] NULL,
	[entryDate] [datetime] NULL,
	[clientId] [int] NULL,
	[crGLAccountId] [int] NULL,
	[drGLAccountId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_journal_entry_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[charge_id] [int] NULL,
	[is_penalty] [bit] NOT NULL,
	[charge_time_enum] [nvarchar](255) NULL,
	[due_for_collection_as_of_date] [nvarchar](255) NULL,
	[charge_calculation_enum] [nvarchar](255) NULL,
	[charge_payment_mode_enum] [nvarchar](255) NULL,
	[calculation_percentage] [float] NULL,
	[calculation_on_amount] [float] NULL,
	[charge_amount_or_percentage] [float] NULL,
	[amount] [float] NULL,
	[amount_paid_derived] [float] NULL,
	[amount_waived_derived] [float] NULL,
	[amount_writtenoff_derived] [float] NULL,
	[amount_outstanding_derived] [float] NULL,
	[is_paid_derived] [bit] NOT NULL,
	[is_waived] [bit] NOT NULL,
	[is_active] [bit] NOT NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_charge_payment]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_charge_payment](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_transaction_id] [int] NULL,
	[loan_id] [int] NULL,
	[loan_charge_id] [int] NULL,
	[amount] [float] NULL,
	[installment_number] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_charge_payment_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_collateral]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_collateral](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[collateral_type] [nvarchar](255) NULL,
	[valuation] [float] NULL,
	[description] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_collateral_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_confirmation]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_confirmation](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_documentId] [int] NULL,
	[documentTypeId] [nvarchar](255) NULL,
	[companyId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[sentByUserRoleId] [int] NULL,
	[sentByUserId] [int] NULL,
	[details] [nvarchar](255) NULL,
	[submitedBy] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_confirmation_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_documents]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_documents](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loanId] [int] NULL,
	[documentName] [nvarchar](255) NULL,
	[documentLocation] [nvarchar](255) NULL,
	[updatedByUserId] [int] NULL,
	[updatedByUseroleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_documents_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_installment_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_installment_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_charge_id] [int] NULL,
	[loan_schedule_id] [int] NULL,
	[due_date] [date] NULL,
	[amount] [float] NULL,
	[amount_paid_derived] [float] NULL,
	[amount_waived_derived] [float] NULL,
	[amount_writtenoff_derived] [float] NULL,
	[amount_outstanding_derived] [float] NULL,
	[is_paid_derived] [bit] NOT NULL,
	[is_waived] [bit] NOT NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_installment_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_officer_assignment]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_officer_assignment](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[loan_officer_id] [int] NULL,
	[start_date] [date] NULL,
	[end_date] [date] NULL,
	[createdby_id] [int] NULL,
	[created_date] [date] NULL,
	[updated_date] [date] NULL,
	[lastmodifiedby_id] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_officer_assignment_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_overdue_installment_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_overdue_installment_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_charge_id] [int] NULL,
	[loan_schedule_id] [int] NULL,
	[overdue_amount] [float] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_overdue_installment_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_paid_in_advance]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_paid_in_advance](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[principal_in_advance_derived] [float] NULL,
	[interest_in_advance_derived] [float] NULL,
	[fee_charges_in_advance_derived] [float] NULL,
	[penalty_charges_in_advance_derived] [float] NULL,
	[total_in_advance_derived] [float] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_paid_in_advance_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_product_charges]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_product_charges](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_product_id] [int] NULL,
	[charge_id] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_product_charges_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_product_document_type]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_product_document_type](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[productId] [int] NULL,
	[documentTypeId] [int] NULL,
	[isRequired] [bit] NOT NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_product_document_type_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_repayment]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_repayment](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[repaymentNo] [nvarchar](255) NULL,
	[dateOfRepayment] [nvarchar](255) NULL,
	[modeOfRepayment] [nvarchar](255) NULL,
	[amountRepaid] [float] NULL,
	[chequeNo] [nvarchar](255) NULL,
	[receiptNo] [nvarchar](255) NULL,
	[registeredByUserId] [int] NULL,
	[recipientUserRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_repayment_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_repayment_schedule]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_repayment_schedule](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[fromdate] [date] NULL,
	[duedate] [date] NULL,
	[installment] [float] NULL,
	[principal_amount] [float] NULL,
	[principal_completed_derived] [float] NULL,
	[principal_writtenoff_derived] [float] NULL,
	[interest_amount] [float] NULL,
	[interest_completed_derived] [float] NULL,
	[interest_writtenoff_derived] [float] NULL,
	[interest_waived_derived] [float] NULL,
	[accrual_interest_derived] [float] NULL,
	[fee_charges_amount] [float] NULL,
	[fee_charges_completed_derived] [float] NULL,
	[fee_charges_writtenoff_derived] [float] NULL,
	[fee_charges_waived_derived] [float] NULL,
	[accrual_fee_charges_derived] [float] NULL,
	[penalty_charges_amount] [float] NULL,
	[penalty_charges_completed_derived] [float] NULL,
	[penalty_charges_writtenoff_derived] [float] NULL,
	[penalty_charges_waived_derived] [float] NULL,
	[accrual_penalty_charges_derived] [float] NULL,
	[total_paid_in_advance_derived] [float] NULL,
	[total_paid_late_derived] [float] NULL,
	[completed_derived] [float] NULL,
	[createdby_id] [int] NULL,
	[lastmodifiedby_id] [int] NULL,
	[obligations_met_on_date] [date] NULL,
	[status] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_repayment_schedule_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_transaction]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_transaction](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_id] [int] NULL,
	[branch_id] [int] NULL,
	[payment_detail_id] [int] NULL,
	[is_reversed] [bit] NOT NULL,
	[external_id] [nvarchar](255) NULL,
	[transaction_type_enum] [nvarchar](255) NULL,
	[transaction_date] [date] NULL,
	[amount] [float] NULL,
	[principal_portion_derived] [float] NULL,
	[interest_portion_derived] [float] NULL,
	[fee_charges_portion_derived] [float] NULL,
	[penalty_charges_portion_derived] [float] NULL,
	[overpayment_portion_derived] [float] NULL,
	[unrecognized_income_portion] [float] NULL,
	[outstanding_loan_balance_derived] [float] NULL,
	[submitted_on_date] [date] NULL,
	[manually_adjusted_or_reversed] [bit] NOT NULL,
	[manually_created_by_userid] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_transaction_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loan_transaction_repayment_schedule_mapping]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loan_transaction_repayment_schedule_mapping](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loan_transaction_id] [int] NULL,
	[loan_repayment_schedule_id] [int] NULL,
	[amount] [float] NULL,
	[principal_portion_derived] [float] NULL,
	[interest_portion_derived] [float] NULL,
	[fee_charges_portion_derived] [float] NULL,
	[penalty_charges_portion_derived] [float] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_loan_transaction_repayment_schedule_mapping_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_loans]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_loans](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[account_no] [nvarchar](255) NULL,
	[external_id] [nvarchar](255) NULL,
	[customer_id] [int] NULL,
	[product_id] [int] NULL,
	[loan_status] [nvarchar](255) NULL,
	[loan_type] [nvarchar](255) NULL,
	[currency_code] [nvarchar](255) NULL,
	[principal_amount_proposed] [float] NULL,
	[principal_amount] [float] NULL,
	[approved_principal] [float] NULL,
	[annual_nominal_interest_rate] [float] NULL,
	[interest_method] [nvarchar](255) NULL,
	[term_frequency] [int] NULL,
	[term_frequency_type] [nvarchar](255) NULL,
	[repay_every] [int] NULL,
	[repay_every_type] [nvarchar](255) NULL,
	[number_of_repayments] [int] NULL,
	[approvedon_date] [date] NULL,
	[approvedon_userid] [int] NULL,
	[expected_disbursedon_date] [date] NULL,
	[disbursedon_date] [date] NULL,
	[disbursedon_userid] [int] NULL,
	[expected_maturity_date] [date] NULL,
	[interest_calculated_from_date] [date] NULL,
	[closedon_date] [date] NULL,
	[closedon_userid] [int] NULL,
	[total_charges_due_at_disbursement_derived] [float] NULL,
	[principal_disbursed_derived] [float] NULL,
	[principal_repaid_derived] [float] NULL,
	[principal_writtenoff_derived] [float] NULL,
	[principal_outstanding_derived] [float] NULL,
	[interest_charged_derived] [float] NULL,
	[interest_repaid_derived] [float] NULL,
	[interest_waived_derived] [float] NULL,
	[interest_writtenoff_derived] [float] NULL,
	[interest_outstanding_derived] [float] NULL,
	[fee_charges_charged_derived] [float] NULL,
	[fee_charges_repaid_derived] [float] NULL,
	[fee_charges_waived_derived] [float] NULL,
	[fee_charges_writtenoff_derived] [float] NULL,
	[fee_charges_outstanding_derived] [float] NULL,
	[penalty_charges_charged_derived] [float] NULL,
	[penalty_charges_repaid_derived] [float] NULL,
	[penalty_charges_waived_derived] [float] NULL,
	[penalty_charges_writtenoff_derived] [float] NULL,
	[penalty_charges_outstanding_derived] [float] NULL,
	[total_expected_repayment_derived] [float] NULL,
	[total_repayment_derived] [float] NULL,
	[total_expected_costofloan_derived] [float] NULL,
	[total_costofloan_derived] [float] NULL,
	[total_waived_derived] [float] NULL,
	[total_writtenoff_derived] [float] NULL,
	[total_outstanding_derived] [float] NULL,
	[total_overpaid_derived] [float] NULL,
	[rejectedon_date] [date] NULL,
	[rejectedon_userid] [int] NULL,
	[withdrawnon_date] [date] NULL,
	[withdrawnon_userid] [int] NULL,
	[writtenoffon_date] [date] NULL,
	[loan_counter] [int] NULL,
	[is_npa] [bit] NOT NULL,
	[is_legacyloan] [bit] NOT NULL,
	[branch_id] [int] NULL,
	[branch_name] [nvarchar](255) NULL,
	[company_id] [int] NULL,
	[actual_nominal_interest_rate] [float] NULL,
	[actual_nominal_interest_rate_type] [nvarchar](255) NULL,
	[loan_userroleid] [int] NULL,
	[loan_userid] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
	[year_length_in_days] [int] NULL,
 CONSTRAINT [tbl_loans_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_next_of_kin]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_next_of_kin](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[firstName] [nvarchar](255) NULL,
	[lastName] [nvarchar](255) NULL,
	[otherName] [nvarchar](255) NULL,
	[addressLine1] [nvarchar](255) NULL,
	[addressLine2] [nvarchar](255) NULL,
	[city] [nvarchar](255) NULL,
	[districtId] [int] NULL,
	[districtName] [nvarchar](255) NULL,
	[provinceId] [int] NULL,
	[provinceName] [nvarchar](255) NULL,
	[accountId] [int] NULL,
	[userId] [int] NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_next_of_kin_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_off_taker_document_types]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_off_taker_document_types](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[companyId] [int] NULL,
	[documentTypeId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_off_taker_document_types_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_on_platform_notifications]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_on_platform_notifications](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[message] [nvarchar](255) NULL,
	[sentByUserId] [int] NULL,
	[sentByUserRoleId] [int] NULL,
	[recipientUserID] [int] NULL,
	[recipientUserRoleId] [int] NULL,
	[readYes] [bit] NOT NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_on_platform_notifications_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_product_charge]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_product_charge](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[productId] [int] NULL,
	[chargeId] [int] NULL,
	[chargeWhen] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_product_charge_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_products]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_products](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[code] [nvarchar](255) NULL,
	[details] [nvarchar](255) NULL,
	[currencyId] [int] NULL,
	[currencyName] [nvarchar](255) NULL,
	[currencyDecimals] [int] NULL,
	[interest] [float] NULL,
	[interestType] [nvarchar](255) NULL,
	[interestMode] [nvarchar](255) NULL,
	[defaultPeriod] [int] NULL,
	[periodType] [nvarchar](255) NULL,
	[productType] [nvarchar](255) NULL,
	[minimumPrincipal] [float] NULL,
	[maximumPrincipal] [float] NULL,
	[clientId] [int] NULL,
	[yearLengthInDays] [int] NULL,
	[status] [nvarchar](255) NULL,
	[minimumPeriod] [int] NULL,
	[maximumPeriod] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_products_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_province]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_province](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[countryId] [int] NULL,
	[countryName] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_province_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_refund_requests]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_refund_requests](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[loanId] [int] NULL,
	[transactionId] [int] NULL,
	[requestNo] [nvarchar](255) NULL,
	[requestedByUserId] [int] NULL,
	[requestedByUserRoleId] [int] NULL,
	[refundAmount] [float] NULL,
	[status] [nvarchar](255) NULL,
	[cancelationReason] [nvarchar](255) NULL,
	[canceledByUserRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_refund_requests_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_sms]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_sms](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[type] [nvarchar](255) NULL,
	[mobile] [nvarchar](255) NULL,
	[msg_count] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[msg] [nvarchar](255) NULL,
	[date_sent] [datetime] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_sms_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_system_directories]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_system_directories](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[bulk_trns] [nvarchar](255) NULL,
	[esb_complete] [nvarchar](255) NULL,
	[esb_downloa] [nvarchar](255) NULL,
	[failed] [nvarchar](255) NULL,
	[processed] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_system_directories_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_system_settings]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_system_settings](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[value] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_system_settings_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_telco]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_telco](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[telcoIP] [nvarchar](255) NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_telco_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_transactions]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_transactions](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[accountId] [int] NULL,
	[totalAmount] [float] NULL,
	[productId] [int] NULL,
	[productType] [nvarchar](255) NULL,
	[userId] [int] NULL,
	[userRoleId] [int] NULL,
	[referenceNo] [nvarchar](255) NULL,
	[orderRef] [nvarchar](255) NULL,
	[transactionType] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[isReversed] [bit] NOT NULL,
	[requestData] [nvarchar](255) NULL,
	[responseData] [nvarchar](255) NULL,
	[carriedOutByUserId] [int] NULL,
	[carriedOutByUserRoleId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_transactions_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_user_bio_data]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_user_bio_data](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[firstName] [nvarchar](255) NULL,
	[lastName] [nvarchar](255) NULL,
	[userId] [int] NULL,
	[otherName] [nvarchar](255) NULL,
	[dateOfBirth] [date] NULL,
	[meansOfIdentificationType] [nvarchar](255) NULL,
	[meansOfIdentificationNumber] [nvarchar](255) NULL,
	[title] [nvarchar](255) NULL,
	[gender] [nvarchar](255) NULL,
	[mobileNumber] [nvarchar](255) NULL,
	[emailAddress] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_user_bio_data_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_user_bio_data_update]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_user_bio_data_update](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[userBioData] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[approvedByUserId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_user_bio_data_update_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_user_logs]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_user_logs](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[activity] [nvarchar](255) NULL,
	[user_id] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_user_logs_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_user_roles]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_user_roles](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[userId] [int] NULL,
	[roleType] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[otp] [nvarchar](255) NULL,
	[companyId] [int] NULL,
	[netPay] [float] NULL,
	[branchId] [int] NULL,
	[isLoanOfficer] [bit] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_user_roles_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_users]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_users](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NULL,
	[password] [nvarchar](255) NULL,
	[clientId] [int] NULL,
	[createdByUserId] [int] NULL,
	[status] [nvarchar](255) NULL,
	[canOperate] [bit] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
	[ussdActive] [int] NOT NULL,
 CONSTRAINT [tbl_users_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_workflow_items]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_workflow_items](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[workFlowId] [int] NULL,
	[createdByUserId] [int] NULL,
	[workflowItemRecipientUserId] [int] NULL,
	[createdByUserRoleId] [int] NULL,
	[workflowItemRecipientUserRoleId] [int] NULL,
	[branchId] [int] NULL,
	[entityId] [int] NULL,
	[entityType] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[actionTaken] [nvarchar](255) NULL,
	[notes] [nvarchar](255) NULL,
	[offTakerId] [int] NULL,
	[currentWorkflowPosition] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_workflow_items_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_workflow_members]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_workflow_members](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[workFlowId] [int] NULL,
	[userRoleId] [int] NULL,
	[userId] [int] NULL,
	[branchId] [int] NULL,
	[orderPosition] [int] NULL,
	[deletedAt] [date] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_workflow_members_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tbl_workflows]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tbl_workflows](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[workFlowId] [int] NULL,
	[createdByUserId] [int] NULL,
	[workflowItemRecipientUserId] [int] NULL,
	[createdByUserRoleId] [int] NULL,
	[workflowItemRecipientUserRoleId] [int] NULL,
	[branchId] [int] NULL,
	[entityId] [int] NULL,
	[entityType] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[actionTaken] [nvarchar](255) NULL,
	[notes] [nvarchar](255) NULL,
	[offTakerId] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [tbl_workflows_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ussd_requests]    Script Date: 4/20/2021 1:19:42 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ussd_requests](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[mobile_number] [nvarchar](255) NULL,
	[request_data] [nvarchar](255) NULL,
	[session_ended] [int] NULL,
	[session_id] [nvarchar](255) NULL,
	[is_logged_in] [int] NULL,
	[inserted_at] [datetime] NOT NULL,
	[updated_at] [datetime] NOT NULL,
 CONSTRAINT [ussd_requests_pkey] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206150608, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206150747, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206150840, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152505, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152519, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152626, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152649, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152709, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152724, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152738, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152748, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152758, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152807, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152818, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152835, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152844, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152854, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152934, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206152944, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206153006, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206153035, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206153059, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206153121, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206153133, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210206224415, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210207111021, CAST(N'2021-04-15T08:18:32.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210211074440, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210212165318, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210215192931, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210215193000, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210215193001, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210215193002, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210215201541, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210216105101, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110651, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110715, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110722, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110740, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110811, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110825, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110841, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110858, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110914, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220110926, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220111003, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210220131000, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210223185828, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210225101745, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210301091750, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210301091828, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210301091852, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210301091910, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210301091921, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210302115225, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210302115812, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210304005840, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210304010303, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210304010557, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210304130650, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210304173438, CAST(N'2021-04-15T08:18:33.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210416231058, CAST(N'2021-04-16T23:11:27.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210419092454, CAST(N'2021-04-19T09:25:13.000' AS DateTime))
INSERT [dbo].[schema_migrations] ([version], [inserted_at]) VALUES (20210419092519, CAST(N'2021-04-19T09:25:26.000' AS DateTime))
GO
SET IDENTITY_INSERT [dbo].[tbl_account] ON 

INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (1, NULL, NULL, NULL, 2, N'260967307151', NULL, NULL, N'SAVINGS', NULL, 1, 2, N'K', 0, 0, 0, 0, 0, 0, 0, 1, 0, 2, NULL, N'ACTIVE', 10002, NULL, CAST(N'2021-02-22T13:23:43.000' AS DateTime), CAST(N'2021-02-22T13:23:43.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (2, NULL, NULL, NULL, 2, N'260978242442', NULL, NULL, N'LOANS', NULL, 1, 2, N'K', 0, 0, 0, 0, 0, 0, 0, 1, NULL, 3, NULL, N'Active', 10004, NULL, CAST(N'2021-02-22T13:37:53.000' AS DateTime), CAST(N'2021-02-22T13:37:53.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (3, NULL, NULL, NULL, 2, N'260976527271', NULL, NULL, N'LOANS', NULL, 1, 2, N'K', 0, 0, 0, 0, 0, 0, 0, 1, NULL, 4, NULL, N'Active', 10005, NULL, CAST(N'2021-02-22T13:43:31.000' AS DateTime), CAST(N'2021-02-22T13:43:31.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (4, NULL, NULL, NULL, 2, N'260976799179', NULL, NULL, N'LOANS', NULL, 1, 2, N'K', 0, 0, 0, 0, 0, 0, 0, 1, NULL, 10002, NULL, N'Active', 20003, NULL, CAST(N'2021-02-23T07:31:10.000' AS DateTime), CAST(N'2021-02-23T07:31:10.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (10001, NULL, NULL, NULL, 1, N'260967307151', NULL, NULL, N'SAVINGS', NULL, 1, 2, N'K', 0, 0, 0, 0, 0, 0, 0, 2, NULL, 9, NULL, N'Active', 10001, NULL, CAST(N'2021-04-16T22:52:09.000' AS DateTime), CAST(N'2021-04-16T22:52:09.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (10002, NULL, NULL, NULL, 1, N'260967307151', NULL, NULL, N'SAVINGS', NULL, 1, 2, N'K', 600, 0, 0, 0, 0, 0, 0, 2, 0, 22, NULL, N'ACTIVE', 10002, NULL, CAST(N'2021-04-17T08:56:12.000' AS DateTime), CAST(N'2021-04-17T12:39:40.000' AS DateTime))
INSERT [dbo].[tbl_account] ([id], [accountOfficerId], [deactivatedReason], [blockedReason], [clientId], [accountNo], [externalId], [productId], [accountType], [DateClosed], [currencyId], [currencyDecimals], [currencyName], [totalDeposits], [totalWithdrawals], [totalCharges], [totalPenalties], [totalInterestEarned], [totalInterestPosted], [totalTax], [accountVersion], [derivedAccountBalance], [userId], [blockedByUserId], [status], [userRoleId], [branchId], [inserted_at], [updated_at]) VALUES (10003, NULL, NULL, NULL, 1, N'260967307155', NULL, NULL, N'SAVINGS', NULL, 1, 2, N'K', 500, 0, 0, 0, 0, 0, 0, 2, 0, 23, NULL, N'ACTIVE', 10003, NULL, CAST(N'2021-04-27T05:30:39.000' AS DateTime), CAST(N'2021-04-27T05:39:06.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_account] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_addresses] ON 

INSERT [dbo].[tbl_addresses] ([id], [addressLine1], [addressLine2], [city], [districtId], [districtName], [provinceId], [provinceName], [countryId], [countryName], [isCurrent], [userId], [clientId], [inserted_at], [updated_at]) VALUES (1, N'Plot 56 St Pails', N'Off Lazer Road', N'Northmeads', 1, N'Lusaka', 1, N'Lusaka', 1, N'Zambia', 1, 30004, 2, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
INSERT [dbo].[tbl_addresses] ([id], [addressLine1], [addressLine2], [city], [districtId], [districtName], [provinceId], [provinceName], [countryId], [countryName], [isCurrent], [userId], [clientId], [inserted_at], [updated_at]) VALUES (2, N'Plot 56 St Pails', N'Off Lazer Road', N'Northmeads', 1, N'Lusaka', 1, N'Lusaka', 1, N'Zambia', 0, 30004, 2, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
INSERT [dbo].[tbl_addresses] ([id], [addressLine1], [addressLine2], [city], [districtId], [districtName], [provinceId], [provinceName], [countryId], [countryName], [isCurrent], [userId], [clientId], [inserted_at], [updated_at]) VALUES (3, N'Plot 56 St Pails', N'Off Lazer Road', N'Northmeads', 1, N'Lusaka', 1, NULL, 1, N'Zambia', 0, 30004, 2, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_addresses] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_branch] ON 

INSERT [dbo].[tbl_branch] ([id], [branchName], [branchCode], [isDefaultUSSDBranch], [clientId], [inserted_at], [updated_at]) VALUES (1, N'Lusaka Main Branch', N'LSK001', 0, 2, CAST(N'2021-02-20T13:46:12.000' AS DateTime), CAST(N'2021-02-20T13:46:12.000' AS DateTime))
INSERT [dbo].[tbl_branch] ([id], [branchName], [branchCode], [isDefaultUSSDBranch], [clientId], [inserted_at], [updated_at]) VALUES (2, N'Mansa Branch', N'MNS001', 0, 2, CAST(N'2021-02-20T13:46:12.000' AS DateTime), CAST(N'2021-02-20T13:46:12.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_branch] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_charge] ON 

INSERT [dbo].[tbl_charge] ([id], [chargeName], [currency], [currencyId], [isPenalty], [clientId], [chargeType], [chargeAmount], [chargeWhen], [inserted_at], [updated_at]) VALUES (1, N'Late Repayment', N'K', 2, 0, 1, N'FLAT', 10, N'AT MATURITY', CAST(N'2021-02-20T13:46:44.000' AS DateTime), CAST(N'2021-02-20T13:46:44.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_charge] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_client_telco] ON 

INSERT [dbo].[tbl_client_telco] ([id], [telcoId], [clientId], [accountVersion], [ussdShortCode], [domain], [inserted_at], [updated_at]) VALUES (1, 1, 1, 2, N'*778#', N'localhost', CAST(N'2021-02-01T00:00:00.000' AS DateTime), CAST(N'2021-01-01T00:00:00.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_client_telco] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_clients] ON 

INSERT [dbo].[tbl_clients] ([id], [ussdCode], [bankId], [isBank], [isDomicileAccountAtBank], [countryId], [accountCreationEndpoint], [balanceEnquiryEndpoint], [fundsTransferEndpoint], [defaultCurrencyId], [defaultCurrencyName], [status], [defaultCurrencyDecimals], [clientName], [inserted_at], [updated_at]) VALUES (1, N'*778#', 1, 1, 1, 1, N'localhost', N'localhost', N'localhost', 1, N'K', N'ACTIVE', 2, N'MFZ', CAST(N'2021-03-02T00:00:00.000' AS DateTime), CAST(N'2021-03-03T00:00:00.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_clients] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_company] ON 

INSERT [dbo].[tbl_company] ([id], [companyName], [contactPhone], [registrationNumber], [taxNo], [contactEmail], [isEmployer], [isSme], [isOffTaker], [createdByUserId], [createdByUserRoleId], [inserted_at], [updated_at]) VALUES (1, N'Probase Limited', N'260967307100', N'123456', N'098765634', N'contact@probase.com', 1, 0, 0, 1, 2, CAST(N'2021-03-02T01:32:08.000' AS DateTime), CAST(N'2021-03-02T01:32:08.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_company] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_confirmation_notification] ON 

INSERT [dbo].[tbl_confirmation_notification] ([id], [message], [read], [recipientUserID], [recipientUserRoleId], [sentByUserId], [sentByUserRoleId], [inserted_at], [updated_at]) VALUES (1, N'Dear customer, Your loan was approved by your company and forwarded to the bank for approval', 0, 30004, 50007, 40009, 50008, CAST(N'2021-03-03T22:53:26.000' AS DateTime), CAST(N'2021-03-03T22:53:26.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_confirmation_notification] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_country] ON 

INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (1, N'Zimbabwe', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (2, N'Zambia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (3, N'Yemen', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (4, N'Western Sahara', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (5, N'Wallis and Futuna', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (6, N'Vietnam', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (7, N'Venezuela', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (8, N'Vatican', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (9, N'Vanuatu', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (10, N'Uzbekistan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (11, N'Uruguay', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (12, N'United States', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (13, N'United Kingdom', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (14, N'United Arab Emirates', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (15, N'Ukraine', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (16, N'Uganda', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (17, N'U.S. Virgin Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (18, N'Tuvalu', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (19, N'Turks and Caicos Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (20, N'Turkmenistan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (21, N'Turkey', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (22, N'Tunisia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (23, N'Trinidad and Tobago', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (24, N'Tonga', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (25, N'Tokelau', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (26, N'Togo', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (27, N'Thailand', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (28, N'Tanzania', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (29, N'Tajikistan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (30, N'Taiwan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (31, N'Syria', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (32, N'Switzerland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (33, N'Sweden', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (34, N'Swaziland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (35, N'Svalbard and Jan Mayen', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (36, N'Suriname', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (37, N'Sudan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (38, N'Sri Lanka', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (39, N'Spain', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (40, N'South Sudan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (41, N'South Korea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (42, N'South Africa', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (43, N'Somalia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (44, N'Solomon Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (45, N'Slovenia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (46, N'Slovakia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (47, N'Sint Maarten', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (48, N'Singapore', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (49, N'Sierra Leone', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (50, N'Seychelles', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (51, N'Serbia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (52, N'Senegal', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (53, N'Saudi Arabia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (54, N'Sao Tome and Principe', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (55, N'San Marino', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (56, N'Samoa', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (57, N'Saint Vincent and the Grenadines', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (58, N'Saint Pierre and Miquelon', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (59, N'Saint Martin', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (60, N'Saint Lucia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (61, N'Saint Kitts and Nevis', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (62, N'Saint Helena', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (63, N'Saint Barthelemy', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (64, N'Rwanda', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (65, N'Russia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (66, N'Romania', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (67, N'Reunion', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (68, N'Republic of the Congo', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (69, N'Qatar', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (70, N'Puerto Rico', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (71, N'Portugal', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (72, N'Poland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (73, N'Pitcairn', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (74, N'Philippines', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (75, N'Peru', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (76, N'Paraguay', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (77, N'Papua New Guinea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (78, N'Panama', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (79, N'Palestine', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (80, N'Palau', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (81, N'Pakistan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (82, N'Oman', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (83, N'Norway', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (84, N'Northern Mariana Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (85, N'North Korea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (86, N'Niue', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (87, N'Nigeria', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (88, N'Niger', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (89, N'Nicaragua', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (90, N'New Zealand', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (91, N'New Caledonia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (92, N'Netherlands Antilles', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (93, N'Netherlands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (94, N'Nepal', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (95, N'Nauru', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (96, N'Namibia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (97, N'Myanmar', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (98, N'Mozambique', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (99, N'Morocco', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
GO
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (100, N'Montserrat', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (101, N'Montenegro', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (102, N'Mongolia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (103, N'Monaco', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (104, N'Moldova', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (105, N'Micronesia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (106, N'Mexico', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (107, N'Mayotte', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (108, N'Mauritius', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (109, N'Mauritania', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (110, N'Marshall Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (111, N'Malta', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (112, N'Mali', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (113, N'Maldives', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (114, N'Malaysia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (115, N'Malawi', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (116, N'Madagascar', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (117, N'Macedonia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (118, N'Macau', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (119, N'Luxembourg', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (120, N'Lithuania', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (121, N'Liechtenstein', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (122, N'Libya', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (123, N'Liberia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (124, N'Lesotho', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (125, N'Lebanon', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (126, N'Latvia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (127, N'Laos', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (128, N'Kyrgyzstan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (129, N'Kuwait', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (130, N'Kosovo', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (131, N'Kiribati', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (132, N'Kenya', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (133, N'Kazakhstan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (134, N'Jordan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (135, N'Jersey', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (136, N'Japan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (137, N'Jamaica', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (138, N'Ivory Coast', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (139, N'Italy', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (140, N'Israel', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (141, N'Isle of Man', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (142, N'Ireland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (143, N'Iraq', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (144, N'Iran', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (145, N'Indonesia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (146, N'India', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (147, N'Iceland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (148, N'Hungary', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (149, N'Hong Kong', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (150, N'Honduras', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (151, N'Haiti', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (152, N'Guyana', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (153, N'Guinea-Bissau', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (154, N'Guinea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (155, N'Guernsey', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (156, N'Guatemala', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (157, N'Guam', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (158, N'Grenada', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (159, N'Greenland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (160, N'Greece', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (161, N'Gibraltar', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (162, N'Ghana', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (163, N'Germany', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (164, N'Georgia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (165, N'Gambia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (166, N'Gabon', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (167, N'French Polynesia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (168, N'France', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (169, N'Finland', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (170, N'Fiji', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (171, N'Faroe Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (172, N'Falkland Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (173, N'Ethiopia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (174, N'Estonia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (175, N'Eritrea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (176, N'Equatorial Guinea', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (177, N'El Salvador', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (178, N'Egypt', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (179, N'Ecuador', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (180, N'East Timor', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (181, N'Dominican Republic', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (182, N'Dominica', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (183, N'Djibouti', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (184, N'Denmark', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (185, N'Democratic Republic of the Congo', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (186, N'Czech Republic', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (187, N'Cyprus', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (188, N'Curacao', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (189, N'Cuba', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (190, N'Croatia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (191, N'Costa Rica', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (192, N'Cook Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (193, N'Comoros', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (194, N'Colombia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (195, N'Cocos Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (196, N'Christmas Island', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (197, N'China', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (198, N'Chile', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:31.000' AS DateTime), CAST(N'2021-02-20T13:45:31.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (199, N'Chad', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
GO
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (200, N'Central African Republic', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (201, N'Cayman Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (202, N'Cape Verde', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (203, N'Canada', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (204, N'Cameroon', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (205, N'Cambodia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (206, N'Burundi', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (207, N'Burkina Faso', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (208, N'Bulgaria', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (209, N'Brunei', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (210, N'British Virgin Islands', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (211, N'British Indian Ocean Territory', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (212, N'Brazil', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (213, N'Botswana', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (214, N'Bosnia and Herzegovina', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (215, N'Bolivia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (216, N'Bhutan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (217, N'Bermuda', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (218, N'Benin', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (219, N'Belize', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (220, N'Belgium', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (221, N'Belarus', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (222, N'Barbados', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (223, N'Bangladesh', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (224, N'Bahrain', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (225, N'Bahamas', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (226, N'Azerbaijan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (227, N'Austria', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (228, N'Australia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (229, N'Aruba', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (230, N'Armenia', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (231, N'Argentina', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (232, N'Antigua and Barbuda', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (233, N'Antarctica', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (234, N'Anguilla', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (235, N'Angola', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (236, N'Andorra', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (237, N'American Samoa', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (238, N'Algeria', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (239, N'Albania', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
INSERT [dbo].[tbl_country] ([id], [name], [country_file_name], [inserted_at], [updated_at]) VALUES (240, N'Afghanistan', N'countryc32.xlsx', CAST(N'2021-02-20T13:45:32.000' AS DateTime), CAST(N'2021-02-20T13:45:32.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_country] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_currency] ON 

INSERT [dbo].[tbl_currency] ([id], [name], [isoCode], [countryId], [inserted_at], [updated_at]) VALUES (1, N'Zambian Kwacha', N'K', 2, CAST(N'2021-02-20T13:46:00.000' AS DateTime), CAST(N'2021-02-20T13:46:00.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_currency] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_divestment_package] ON 

INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (1, 0, 15, 5, 10005, N'ACTIVE', 2, CAST(N'2021-02-22T09:18:33.000' AS DateTime), CAST(N'2021-02-22T09:18:33.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (2, 16, 30, 7, 10005, N'ACTIVE', 2, CAST(N'2021-02-22T09:18:33.000' AS DateTime), CAST(N'2021-02-22T09:18:33.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (3, 0, 10, 5, 9, N'ACTIVE', 1, CAST(N'2021-04-15T12:01:53.000' AS DateTime), CAST(N'2021-04-15T12:01:53.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (4, 16, 40, 6, 9, N'ACTIVE', 1, CAST(N'2021-04-15T12:01:53.000' AS DateTime), CAST(N'2021-04-15T12:01:53.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (5, 41, 80, 10, 9, N'ACTIVE', 1, CAST(N'2021-04-15T12:01:53.000' AS DateTime), CAST(N'2021-04-15T12:01:53.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (6, 0, 15, 5, 10, N'ACTIVE', 1, CAST(N'2021-04-15T12:13:45.000' AS DateTime), CAST(N'2021-04-15T12:13:45.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (7, 16, 60, 7, 10, N'ACTIVE', 1, CAST(N'2021-04-15T12:13:45.000' AS DateTime), CAST(N'2021-04-15T12:13:45.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (8, 0, 34, 6, 13, N'ACTIVE', 1, CAST(N'2021-04-15T12:26:56.000' AS DateTime), CAST(N'2021-04-15T12:26:56.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (9, 35, 60, 10, 13, N'ACTIVE', 1, CAST(N'2021-04-15T12:26:56.000' AS DateTime), CAST(N'2021-04-15T12:26:56.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (10001, 0, 14, 5, 10001, N'ACTIVE', 1, CAST(N'2021-04-16T22:47:31.000' AS DateTime), CAST(N'2021-04-16T22:47:31.000' AS DateTime))
INSERT [dbo].[tbl_divestment_package] ([id], [startPeriodDays], [endPeriodDays], [divestmentValuation], [productId], [status], [clientId], [inserted_at], [updated_at]) VALUES (10002, 15, 29, 7, 10001, N'ACTIVE', 1, CAST(N'2021-04-16T22:47:31.000' AS DateTime), CAST(N'2021-04-16T22:47:31.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_divestment_package] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_divestment_transactions] ON 

INSERT [dbo].[tbl_divestment_transactions] ([id], [divestmentId], [transactionId], [amountDivested], [interestAccrued], [userId], [userRoleId], [clientId], [inserted_at], [updated_at]) VALUES (1, 1, 3, 100, 0, 22, 10002, 1, CAST(N'2021-04-17T14:36:38.000' AS DateTime), CAST(N'2021-04-17T14:36:38.000' AS DateTime))
INSERT [dbo].[tbl_divestment_transactions] ([id], [divestmentId], [transactionId], [amountDivested], [interestAccrued], [userId], [userRoleId], [clientId], [inserted_at], [updated_at]) VALUES (2, 2, 4, 100, 0, 22, 10002, 1, CAST(N'2021-04-17T14:44:50.000' AS DateTime), CAST(N'2021-04-17T14:44:50.000' AS DateTime))
INSERT [dbo].[tbl_divestment_transactions] ([id], [divestmentId], [transactionId], [amountDivested], [interestAccrued], [userId], [userRoleId], [clientId], [inserted_at], [updated_at]) VALUES (3, 3, 6, 100, 0, 22, 10002, 1, CAST(N'2021-04-17T14:45:29.000' AS DateTime), CAST(N'2021-04-17T14:45:29.000' AS DateTime))
INSERT [dbo].[tbl_divestment_transactions] ([id], [divestmentId], [transactionId], [amountDivested], [interestAccrued], [userId], [userRoleId], [clientId], [inserted_at], [updated_at]) VALUES (4, 4, 8, 100, 0.02, 22, 10002, 1, CAST(N'2021-04-18T14:55:39.000' AS DateTime), CAST(N'2021-04-18T14:55:39.000' AS DateTime))
INSERT [dbo].[tbl_divestment_transactions] ([id], [divestmentId], [transactionId], [amountDivested], [interestAccrued], [userId], [userRoleId], [clientId], [inserted_at], [updated_at]) VALUES (5, 5, 11, 100, 0, 23, 10003, 1, CAST(N'2021-04-27T05:42:29.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_divestment_transactions] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_divestments] ON 

INSERT [dbo].[tbl_divestments] ([id], [fixedDepositId], [principalAmount], [fixedPeriod], [interestRate], [interestRateType], [divestmentDate], [divestmentDayCount], [divestmentValuation], [divestAmount], [clientId], [interestAccrued], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (1, 1, 100, 30, 16.5, N'Years', CAST(N'2021-04-17' AS Date), 0, 5, 100, 1, 0, 22, 10002, CAST(N'2021-04-17T14:36:38.000' AS DateTime), CAST(N'2021-04-17T14:36:38.000' AS DateTime))
INSERT [dbo].[tbl_divestments] ([id], [fixedDepositId], [principalAmount], [fixedPeriod], [interestRate], [interestRateType], [divestmentDate], [divestmentDayCount], [divestmentValuation], [divestAmount], [clientId], [interestAccrued], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (2, 2, 500, 30, 16.5, N'Years', CAST(N'2021-04-17' AS Date), 0, 5, 100, 1, 0, 22, 10002, CAST(N'2021-04-17T14:44:50.000' AS DateTime), CAST(N'2021-04-17T14:44:50.000' AS DateTime))
INSERT [dbo].[tbl_divestments] ([id], [fixedDepositId], [principalAmount], [fixedPeriod], [interestRate], [interestRateType], [divestmentDate], [divestmentDayCount], [divestmentValuation], [divestAmount], [clientId], [interestAccrued], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (3, 3, 400, 30, 16.5, N'Years', CAST(N'2021-04-17' AS Date), 0, 5, 100, 1, 0, 22, 10002, CAST(N'2021-04-17T14:45:29.000' AS DateTime), CAST(N'2021-04-17T14:45:29.000' AS DateTime))
INSERT [dbo].[tbl_divestments] ([id], [fixedDepositId], [principalAmount], [fixedPeriod], [interestRate], [interestRateType], [divestmentDate], [divestmentDayCount], [divestmentValuation], [divestAmount], [clientId], [interestAccrued], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (4, 4, 300, 30, 16.5, N'Years', CAST(N'2021-04-18' AS Date), 1, 5, 100, 1, 0.02, 22, 10002, CAST(N'2021-04-18T14:55:39.000' AS DateTime), CAST(N'2021-04-18T14:55:39.000' AS DateTime))
INSERT [dbo].[tbl_divestments] ([id], [fixedDepositId], [principalAmount], [fixedPeriod], [interestRate], [interestRateType], [divestmentDate], [divestmentDayCount], [divestmentValuation], [divestAmount], [clientId], [interestAccrued], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (5, 6, 500, 30, 16.5, N'Years', CAST(N'2021-04-27' AS Date), 0, 5, 100, 1, 0, 23, 10003, CAST(N'2021-04-27T05:42:29.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_divestments] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_document_type] ON 

INSERT [dbo].[tbl_document_type] ([id], [name], [createdByUserId], [deleted_at], [description], [documentFormats], [inserted_at], [updated_at]) VALUES (1, N'PACRA Certificate', 1, NULL, N'Adsd', N'["PDF","IMAGE","WORD","EXCEL"]', CAST(N'2021-03-01T10:09:19.000' AS DateTime), CAST(N'2021-03-01T10:09:19.000' AS DateTime))
INSERT [dbo].[tbl_document_type] ([id], [name], [createdByUserId], [deleted_at], [description], [documentFormats], [inserted_at], [updated_at]) VALUES (2, N'Building Compliance Certificate', 1, NULL, N'Building Compliance Certificate', N'PDF, WORD', CAST(N'2021-03-01T10:20:28.000' AS DateTime), CAST(N'2021-03-01T10:20:28.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_document_type] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_end_of_day] ON 

INSERT [dbo].[tbl_end_of_day] ([id], [date_ran], [total_interest_accrued], [penalties_incurred], [end_of_day_type], [start_date], [end_date], [inserted_at], [updated_at], [status], [currencyId], [currencyName]) VALUES (18, CAST(N'2021-04-27T04:54:11.000' AS DateTime), 0.825000000000017, 0, N'FIXED DEPOSIT', CAST(N'2021-04-27T00:00:00.000' AS DateTime), CAST(N'2021-04-27T23:59:59.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), N'COMPLETED', 1, N'K                                                                                                                       ')
SET IDENTITY_INSERT [dbo].[tbl_end_of_day] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_end_of_day_entries] ON 

INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (53, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-19' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (54, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-20' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (55, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-21' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (56, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-22' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (57, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-23' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (58, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-24' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (59, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-25' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (60, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-26' AS Date))
INSERT [dbo].[tbl_end_of_day_entries] ([id], [end_of_day_id], [interest_accrued], [penalties_incurred], [inserted_at], [updated_at], [fixed_deposit_id], [status], [currencyId], [currencyName], [end_of_day_date]) VALUES (61, 18, 0.091666666666668561, 0, CAST(N'2021-04-27T04:54:11.000' AS DateTime), CAST(N'2021-04-27T04:54:11.000' AS DateTime), 5, N'VALID', 2, N'K                                                                                                   ', CAST(N'2021-04-27' AS Date))
SET IDENTITY_INSERT [dbo].[tbl_end_of_day_entries] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_fixed_deposit] ON 

INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (1, 1, 10001, 100, 30, N'Days', 16.5, N'Years', 1.38, 0, 0, 1, 10001, 2, N'K', 2, 360, 0, 0, 0, 10002, 22, 0, CAST(N'2021-04-17' AS Date), CAST(N'2021-05-17' AS Date), 1, 1, NULL, CAST(N'2021-04-17T12:37:33.000' AS DateTime), CAST(N'2021-04-17T14:36:38.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (2, 1, 10001, 500, 30, N'Days', 16.5, N'Years', 6.88, 0, 0, 1, 10001, 2, N'K', 2, 360, 0, 0, 0, 10002, 22, 0, CAST(N'2021-04-17' AS Date), CAST(N'2021-05-17' AS Date), 1, 2, NULL, CAST(N'2021-04-17T12:39:40.000' AS DateTime), CAST(N'2021-04-17T14:44:50.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (3, 1, 10001, 400, 30, N'Days', 16.5, N'Years', 5.5, 0, 0, 1, 10001, 2, N'K', 2, 360, 0, 0, 0, 10002, 22, 0, CAST(N'2021-04-17' AS Date), CAST(N'2021-05-17' AS Date), 1, 3, NULL, CAST(N'2021-04-17T14:44:50.000' AS DateTime), CAST(N'2021-04-17T14:45:29.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (4, 1, 10001, 300, 30, N'Days', 16.5, N'Years', 4.13, 0, 0, 1, 10001, 2, N'K', 2, 360, 0, 0, 0, 10002, 22, 0, CAST(N'2021-04-17' AS Date), CAST(N'2021-05-17' AS Date), 1, 4, NULL, CAST(N'2021-04-17T14:45:29.000' AS DateTime), CAST(N'2021-04-18T14:55:40.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (5, 1, 10001, 200, 30, N'Days', 16.5, N'Years', 2.75, 0, 0, 0, NULL, 2, N'K', 2, 360, 0, 0, 0, 10002, 22, 0, CAST(N'2021-04-18' AS Date), CAST(N'2021-05-18' AS Date), 1, NULL, NULL, CAST(N'2021-04-18T14:55:40.000' AS DateTime), CAST(N'2021-04-18T14:55:40.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (6, 10003, 10001, 500, 30, N'Days', 16.5, N'Years', 6.88, 0, 0, 1, 10001, 2, N'K', 2, 360, 0, 0, 0, 10003, 23, 100, CAST(N'2021-04-27' AS Date), CAST(N'2021-05-27' AS Date), 1, 5, NULL, CAST(N'2021-04-27T05:39:06.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime), N'FLAT')
INSERT [dbo].[tbl_fixed_deposit] ([id], [accountId], [productId], [principalAmount], [fixedPeriod], [fixedPeriodType], [interestRate], [interestRateType], [expectedInterest], [accruedInterest], [isMatured], [isDivested], [divestmentPackageId], [currencyId], [currency], [currencyDecimals], [yearLengthInDays], [totalDepositCharge], [totalWithdrawalCharge], [totalPenalties], [userRoleId], [userId], [totalAmountPaidOut], [startDate], [endDate], [clientId], [divestmentId], [branchId], [inserted_at], [updated_at], [productInterestMode]) VALUES (7, 10003, 10001, 400, 30, N'Days', 16.5, N'Years', 5.5, 0, 0, 0, NULL, 2, N'K', 2, 360, 0, 0, 0, 10003, 23, 0, CAST(N'2021-04-27' AS Date), CAST(N'2021-05-27' AS Date), 1, NULL, NULL, CAST(N'2021-04-27T05:42:29.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime), N'FLAT')
SET IDENTITY_INSERT [dbo].[tbl_fixed_deposit] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_fixed_deposit_transactions] ON 

INSERT [dbo].[tbl_fixed_deposit_transactions] ([id], [fixedDepositId], [transactionId], [clientId], [amountDeposited], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (1, 1, 1, 1, 100, 22, 10002, CAST(N'2021-04-17T12:37:33.000' AS DateTime), CAST(N'2021-04-17T12:37:33.000' AS DateTime))
INSERT [dbo].[tbl_fixed_deposit_transactions] ([id], [fixedDepositId], [transactionId], [clientId], [amountDeposited], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (2, 2, 2, 1, 500, 22, 10002, CAST(N'2021-04-17T12:39:40.000' AS DateTime), CAST(N'2021-04-17T12:39:40.000' AS DateTime))
INSERT [dbo].[tbl_fixed_deposit_transactions] ([id], [fixedDepositId], [transactionId], [clientId], [amountDeposited], [userId], [userRoleId], [inserted_at], [updated_at]) VALUES (3, 6, 10, 1, 500, 23, 10003, CAST(N'2021-04-27T05:39:06.000' AS DateTime), CAST(N'2021-04-27T05:39:06.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_fixed_deposit_transactions] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_loan_charge] ON 

INSERT [dbo].[tbl_loan_charge] ([id], [loan_id], [charge_id], [is_penalty], [charge_time_enum], [due_for_collection_as_of_date], [charge_calculation_enum], [charge_payment_mode_enum], [calculation_percentage], [calculation_on_amount], [charge_amount_or_percentage], [amount], [amount_paid_derived], [amount_waived_derived], [amount_writtenoff_derived], [amount_outstanding_derived], [is_paid_derived], [is_waived], [is_active], [inserted_at], [updated_at]) VALUES (1, 4, 1, 0, N'AT DISBURSEMENT', NULL, N'FLAT', NULL, NULL, 1000, 10, 10, 0, 0, 0, 10, 0, 0, 0, CAST(N'2021-02-28T13:25:11.000' AS DateTime), CAST(N'2021-02-28T13:25:11.000' AS DateTime))
INSERT [dbo].[tbl_loan_charge] ([id], [loan_id], [charge_id], [is_penalty], [charge_time_enum], [due_for_collection_as_of_date], [charge_calculation_enum], [charge_payment_mode_enum], [calculation_percentage], [calculation_on_amount], [charge_amount_or_percentage], [amount], [amount_paid_derived], [amount_waived_derived], [amount_writtenoff_derived], [amount_outstanding_derived], [is_paid_derived], [is_waived], [is_active], [inserted_at], [updated_at]) VALUES (2, 5, 1, 0, N'AT DISBURSEMENT', NULL, N'FLAT', NULL, NULL, 2000, 10, 10, 0, 0, 0, 10, 0, 0, 0, CAST(N'2021-03-01T01:11:16.000' AS DateTime), CAST(N'2021-03-01T01:11:16.000' AS DateTime))
INSERT [dbo].[tbl_loan_charge] ([id], [loan_id], [charge_id], [is_penalty], [charge_time_enum], [due_for_collection_as_of_date], [charge_calculation_enum], [charge_payment_mode_enum], [calculation_percentage], [calculation_on_amount], [charge_amount_or_percentage], [amount], [amount_paid_derived], [amount_waived_derived], [amount_writtenoff_derived], [amount_outstanding_derived], [is_paid_derived], [is_waived], [is_active], [inserted_at], [updated_at]) VALUES (3, 6, 1, 0, N'AT DISBURSEMENT', NULL, N'FLAT', NULL, NULL, 2000, 10, 10, 0, 0, 0, 10, 0, 0, 0, CAST(N'2021-03-02T09:05:46.000' AS DateTime), CAST(N'2021-03-02T09:05:46.000' AS DateTime))
INSERT [dbo].[tbl_loan_charge] ([id], [loan_id], [charge_id], [is_penalty], [charge_time_enum], [due_for_collection_as_of_date], [charge_calculation_enum], [charge_payment_mode_enum], [calculation_percentage], [calculation_on_amount], [charge_amount_or_percentage], [amount], [amount_paid_derived], [amount_waived_derived], [amount_writtenoff_derived], [amount_outstanding_derived], [is_paid_derived], [is_waived], [is_active], [inserted_at], [updated_at]) VALUES (4, 7, 1, 0, N'AT DISBURSEMENT', NULL, N'FLAT', NULL, NULL, 2000, 10, 10, 0, 0, 0, 10, 0, 0, 0, CAST(N'2021-03-03T12:45:44.000' AS DateTime), CAST(N'2021-03-03T12:45:44.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_loan_charge] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_loans] ON 

INSERT [dbo].[tbl_loans] ([id], [account_no], [external_id], [customer_id], [product_id], [loan_status], [loan_type], [currency_code], [principal_amount_proposed], [principal_amount], [approved_principal], [annual_nominal_interest_rate], [interest_method], [term_frequency], [term_frequency_type], [repay_every], [repay_every_type], [number_of_repayments], [approvedon_date], [approvedon_userid], [expected_disbursedon_date], [disbursedon_date], [disbursedon_userid], [expected_maturity_date], [interest_calculated_from_date], [closedon_date], [closedon_userid], [total_charges_due_at_disbursement_derived], [principal_disbursed_derived], [principal_repaid_derived], [principal_writtenoff_derived], [principal_outstanding_derived], [interest_charged_derived], [interest_repaid_derived], [interest_waived_derived], [interest_writtenoff_derived], [interest_outstanding_derived], [fee_charges_charged_derived], [fee_charges_repaid_derived], [fee_charges_waived_derived], [fee_charges_writtenoff_derived], [fee_charges_outstanding_derived], [penalty_charges_charged_derived], [penalty_charges_repaid_derived], [penalty_charges_waived_derived], [penalty_charges_writtenoff_derived], [penalty_charges_outstanding_derived], [total_expected_repayment_derived], [total_repayment_derived], [total_expected_costofloan_derived], [total_costofloan_derived], [total_waived_derived], [total_writtenoff_derived], [total_outstanding_derived], [total_overpaid_derived], [rejectedon_date], [rejectedon_userid], [withdrawnon_date], [withdrawnon_userid], [writtenoffon_date], [loan_counter], [is_npa], [is_legacyloan], [branch_id], [branch_name], [company_id], [actual_nominal_interest_rate], [actual_nominal_interest_rate_type], [loan_userroleid], [loan_userid], [inserted_at], [updated_at], [year_length_in_days]) VALUES (1, NULL, NULL, NULL, 10002, N'PENDING', N'INDIVIDUAL', N'ZMW', 1000, 1000, NULL, 60, N'FLAT', 10, N'Months', 1, N'Months', 10, NULL, NULL, CAST(N'2021-02-28' AS Date), NULL, NULL, CAST(N'2021-12-25' AS Date), CAST(N'2021-02-28' AS Date), NULL, NULL, 10, NULL, 0, 0, 1000, 295.05, 0, 0, 0, 295.05, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1295.05, 1295.05, 10, 10, 0, 0, 1295.05, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, N'Lusaka Main Branch', NULL, 5, N'Months', 40005, 30004, CAST(N'2021-02-28T13:25:11.000' AS DateTime), CAST(N'2021-02-28T13:25:11.000' AS DateTime), NULL)
INSERT [dbo].[tbl_loans] ([id], [account_no], [external_id], [customer_id], [product_id], [loan_status], [loan_type], [currency_code], [principal_amount_proposed], [principal_amount], [approved_principal], [annual_nominal_interest_rate], [interest_method], [term_frequency], [term_frequency_type], [repay_every], [repay_every_type], [number_of_repayments], [approvedon_date], [approvedon_userid], [expected_disbursedon_date], [disbursedon_date], [disbursedon_userid], [expected_maturity_date], [interest_calculated_from_date], [closedon_date], [closedon_userid], [total_charges_due_at_disbursement_derived], [principal_disbursed_derived], [principal_repaid_derived], [principal_writtenoff_derived], [principal_outstanding_derived], [interest_charged_derived], [interest_repaid_derived], [interest_waived_derived], [interest_writtenoff_derived], [interest_outstanding_derived], [fee_charges_charged_derived], [fee_charges_repaid_derived], [fee_charges_waived_derived], [fee_charges_writtenoff_derived], [fee_charges_outstanding_derived], [penalty_charges_charged_derived], [penalty_charges_repaid_derived], [penalty_charges_waived_derived], [penalty_charges_writtenoff_derived], [penalty_charges_outstanding_derived], [total_expected_repayment_derived], [total_repayment_derived], [total_expected_costofloan_derived], [total_costofloan_derived], [total_waived_derived], [total_writtenoff_derived], [total_outstanding_derived], [total_overpaid_derived], [rejectedon_date], [rejectedon_userid], [withdrawnon_date], [withdrawnon_userid], [writtenoffon_date], [loan_counter], [is_npa], [is_legacyloan], [branch_id], [branch_name], [company_id], [actual_nominal_interest_rate], [actual_nominal_interest_rate_type], [loan_userroleid], [loan_userid], [inserted_at], [updated_at], [year_length_in_days]) VALUES (2, NULL, NULL, NULL, 10002, N'PENDING', N'INDIVIDUAL', N'ZMW', 2000, 2000, NULL, 60, N'FLAT', 10, N'Months', 1, N'Months', 10, NULL, NULL, CAST(N'2021-03-01' AS Date), NULL, NULL, CAST(N'2021-12-26' AS Date), CAST(N'2021-03-01' AS Date), NULL, NULL, 10, NULL, 0, 0, 2000, 590.1, 0, 0, 0, 590.1, 10, 0, 0, 0, 10, 0, 0, 0, 0, 0, 2590.1, 2590.1, 10, 10, 0, 0, 2590.1, 0, NULL, NULL, NULL, NULL, NULL, 2, 0, 0, 1, N'Lusaka Main Branch', NULL, 5, N'Months', 40005, 30004, CAST(N'2021-03-01T01:11:16.000' AS DateTime), CAST(N'2021-03-01T01:11:16.000' AS DateTime), NULL)
INSERT [dbo].[tbl_loans] ([id], [account_no], [external_id], [customer_id], [product_id], [loan_status], [loan_type], [currency_code], [principal_amount_proposed], [principal_amount], [approved_principal], [annual_nominal_interest_rate], [interest_method], [term_frequency], [term_frequency_type], [repay_every], [repay_every_type], [number_of_repayments], [approvedon_date], [approvedon_userid], [expected_disbursedon_date], [disbursedon_date], [disbursedon_userid], [expected_maturity_date], [interest_calculated_from_date], [closedon_date], [closedon_userid], [total_charges_due_at_disbursement_derived], [principal_disbursed_derived], [principal_repaid_derived], [principal_writtenoff_derived], [principal_outstanding_derived], [interest_charged_derived], [interest_repaid_derived], [interest_waived_derived], [interest_writtenoff_derived], [interest_outstanding_derived], [fee_charges_charged_derived], [fee_charges_repaid_derived], [fee_charges_waived_derived], [fee_charges_writtenoff_derived], [fee_charges_outstanding_derived], [penalty_charges_charged_derived], [penalty_charges_repaid_derived], [penalty_charges_waived_derived], [penalty_charges_writtenoff_derived], [penalty_charges_outstanding_derived], [total_expected_repayment_derived], [total_repayment_derived], [total_expected_costofloan_derived], [total_costofloan_derived], [total_waived_derived], [total_writtenoff_derived], [total_outstanding_derived], [total_overpaid_derived], [rejectedon_date], [rejectedon_userid], [withdrawnon_date], [withdrawnon_userid], [writtenoffon_date], [loan_counter], [is_npa], [is_legacyloan], [branch_id], [branch_name], [company_id], [actual_nominal_interest_rate], [actual_nominal_interest_rate_type], [loan_userroleid], [loan_userid], [inserted_at], [updated_at], [year_length_in_days]) VALUES (3, NULL, NULL, NULL, 10002, N'PENDING', N'INDIVIDUAL', N'ZMW', 2000, 2000, NULL, 60, N'FLAT', 10, N'Months', 1, N'Months', 10, NULL, NULL, CAST(N'2021-03-02' AS Date), NULL, NULL, CAST(N'2021-12-27' AS Date), CAST(N'2021-03-02' AS Date), NULL, NULL, 10, NULL, 0, 0, 2000, 590.1, 0, 0, 0, 590.1, 10, 0, 0, 0, 10, 0, 0, 0, 0, 0, 2590.1, 2590.1, 10, 10, 0, 0, 2590.1, 0, NULL, NULL, NULL, NULL, NULL, 3, 0, 0, 1, N'Lusaka Main Branch', NULL, 5, N'Months', 40005, 30004, CAST(N'2021-03-02T09:05:46.000' AS DateTime), CAST(N'2021-03-02T09:05:46.000' AS DateTime), NULL)
INSERT [dbo].[tbl_loans] ([id], [account_no], [external_id], [customer_id], [product_id], [loan_status], [loan_type], [currency_code], [principal_amount_proposed], [principal_amount], [approved_principal], [annual_nominal_interest_rate], [interest_method], [term_frequency], [term_frequency_type], [repay_every], [repay_every_type], [number_of_repayments], [approvedon_date], [approvedon_userid], [expected_disbursedon_date], [disbursedon_date], [disbursedon_userid], [expected_maturity_date], [interest_calculated_from_date], [closedon_date], [closedon_userid], [total_charges_due_at_disbursement_derived], [principal_disbursed_derived], [principal_repaid_derived], [principal_writtenoff_derived], [principal_outstanding_derived], [interest_charged_derived], [interest_repaid_derived], [interest_waived_derived], [interest_writtenoff_derived], [interest_outstanding_derived], [fee_charges_charged_derived], [fee_charges_repaid_derived], [fee_charges_waived_derived], [fee_charges_writtenoff_derived], [fee_charges_outstanding_derived], [penalty_charges_charged_derived], [penalty_charges_repaid_derived], [penalty_charges_waived_derived], [penalty_charges_writtenoff_derived], [penalty_charges_outstanding_derived], [total_expected_repayment_derived], [total_repayment_derived], [total_expected_costofloan_derived], [total_costofloan_derived], [total_waived_derived], [total_writtenoff_derived], [total_outstanding_derived], [total_overpaid_derived], [rejectedon_date], [rejectedon_userid], [withdrawnon_date], [withdrawnon_userid], [writtenoffon_date], [loan_counter], [is_npa], [is_legacyloan], [branch_id], [branch_name], [company_id], [actual_nominal_interest_rate], [actual_nominal_interest_rate_type], [loan_userroleid], [loan_userid], [inserted_at], [updated_at], [year_length_in_days]) VALUES (4, NULL, NULL, NULL, 10002, N'PENDING', N'SALARY', N'ZMW', 2000, 2000, NULL, 60, N'FLAT', 10, N'Months', 1, N'Months', 10, NULL, NULL, CAST(N'2021-03-03' AS Date), NULL, NULL, CAST(N'2021-12-28' AS Date), CAST(N'2021-03-03' AS Date), NULL, NULL, 10, NULL, 0, 0, 2000, 590.1, 0, 0, 0, 590.1, 10, 0, 0, 0, 10, 0, 0, 0, 0, 0, 2590.1, 2590.1, 10, 10, 0, 0, 2590.1, 0, NULL, NULL, NULL, NULL, NULL, 4, 0, 0, 1, N'Lusaka Main Branch', 1, 5, N'Months', 50007, 30004, CAST(N'2021-03-03T12:45:44.000' AS DateTime), CAST(N'2021-03-03T22:53:26.000' AS DateTime), NULL)
SET IDENTITY_INSERT [dbo].[tbl_loans] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_next_of_kin] ON 

INSERT [dbo].[tbl_next_of_kin] ([id], [firstName], [lastName], [otherName], [addressLine1], [addressLine2], [city], [districtId], [districtName], [provinceId], [provinceName], [accountId], [userId], [clientId], [inserted_at], [updated_at]) VALUES (1, N'Jadon', N'Akujua', N'Obinna', N'Plot 110 Cadastral Zone', N'White Crescent', N'Northmead', 1, N'Lusaka', 1, N'Lusaka', NULL, 30004, 2, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_next_of_kin] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_product_charge] ON 

INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (1, 1, 1, N'AT DISBURSEMENT', CAST(N'2021-02-20T13:54:42.000' AS DateTime), CAST(N'2021-02-20T13:54:42.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (2, 2, 1, N'AT DISBURSEMENT', CAST(N'2021-02-20T14:31:58.000' AS DateTime), CAST(N'2021-02-20T14:31:58.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (3, 3, 1, N'AT DISBURSEMENT', CAST(N'2021-02-20T14:32:50.000' AS DateTime), CAST(N'2021-02-20T14:32:50.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (4, 4, 1, N'AT DISBURSEMENT', CAST(N'2021-02-20T14:33:43.000' AS DateTime), CAST(N'2021-02-20T14:33:43.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (5, 10002, 1, N'AT DISBURSEMENT', CAST(N'2021-02-22T08:27:00.000' AS DateTime), CAST(N'2021-02-22T08:27:00.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (6, 10003, 1, N'AT DISBURSEMENT', CAST(N'2021-02-22T08:28:31.000' AS DateTime), CAST(N'2021-02-22T08:28:31.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (7, 10004, 1, N'AT DISBURSEMENT', CAST(N'2021-02-22T08:31:35.000' AS DateTime), CAST(N'2021-02-22T08:31:35.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (8, 10005, 1, N'AT DISBURSEMENT', CAST(N'2021-02-22T09:18:33.000' AS DateTime), CAST(N'2021-02-22T09:18:33.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (9, 13, 1, N'AT MATURITY', CAST(N'2021-04-15T12:26:56.000' AS DateTime), CAST(N'2021-04-15T12:26:56.000' AS DateTime))
INSERT [dbo].[tbl_product_charge] ([id], [productId], [chargeId], [chargeWhen], [inserted_at], [updated_at]) VALUES (10001, 10001, 1, N'AT MATURITY', CAST(N'2021-04-16T22:47:31.000' AS DateTime), CAST(N'2021-04-16T22:47:31.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_product_charge] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_products] ON 

INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (1, N'Marketers Capital Loan', N'MCL009', N'Marketers Capital Loan', 1, N'K', 2, 5, N'Months', N'FLAT', 12, N'Months', N'LOANS', 10, 1000, 2, 360, N'INACTIVE', 30, 90, CAST(N'2021-02-20T13:54:42.000' AS DateTime), CAST(N'2021-02-20T13:54:42.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (2, N'Test Loan', N'01', N'10,000 Loans', 1, N'K', 2, 5, N'Months', N'FLAT', 6, N'Months', N'LOANS', 10, 2000, 2, 360, N'INACTIVE', 30, 90, CAST(N'2021-02-20T14:31:58.000' AS DateTime), CAST(N'2021-02-20T14:31:58.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (3, N'Test Loan', N'01', N'10,000 Loans', 1, N'K', 2, 5, N'Months', N'FLAT', 3, N'Months', N'LOANS', 10, 2000, 2, 360, N'INACTIVE', 30, 90, CAST(N'2021-02-20T14:32:50.000' AS DateTime), CAST(N'2021-02-20T14:32:50.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (4, N'Test 2', N'082089', N'10,000 Loans', 1, N'K', 2, 5, N'Months', N'FLAT', 9, N'Months', N'LOANS', 10, 3000, 2, 360, N'INACTIVE', 30, 90, CAST(N'2021-02-20T14:33:43.000' AS DateTime), CAST(N'2021-02-20T14:33:43.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (5, N'Test Data', N'08', N'10,000 Loans', 1, N'K', 2, 5, N'Months', N'FLAT', 8, N'Months', N'LOANS', 20, 2000, 2, 360, N'INACTIVE', 10, 90, CAST(N'2021-02-22T08:27:00.000' AS DateTime), CAST(N'2021-02-22T08:27:00.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (6, N'Test Loan 5', N'082089', N'kjjkkkj', 1, N'K', 2, 5, N'Months', N'FLAT', 7, N'Months', N'LOANS', 20, 3000, 2, 360, N'INACTIVE', 30, 90, CAST(N'2021-02-22T08:28:31.000' AS DateTime), CAST(N'2021-02-22T08:28:31.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (7, N'Test Loan 6', N'082089', N'Farmers Loans For Planting', 1, N'K', 2, 5, N'Months', N'FLAT', 5, N'Months', N'LOANS', 30, 5000, 2, 360, N'INACTIVE', 20, 120, CAST(N'2021-02-22T08:31:35.000' AS DateTime), CAST(N'2021-02-22T08:31:35.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (8, N'Test Savings', N'SV01', N'Zipake Savings Product 001', 1, N'ZMW', 2, 4, N'Days', N'FLAT', 30, N'Months', N'SAVINGS', 20, 2000, 2, 360, N'INACTIVE', NULL, NULL, CAST(N'2021-02-22T09:18:33.000' AS DateTime), CAST(N'2021-02-22T09:18:33.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (9, N'Zipake 002', N'ZP2', N'Farmers Savings For Planting', 1, N'K', 2, 5, N'Days', N'FLAT', 30, N'Days', N'SAVINGS', 10, 10000, 1, 360, N'INACTIVE', NULL, NULL, CAST(N'2021-04-15T12:01:53.000' AS DateTime), CAST(N'2021-04-15T12:01:53.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (10, N'Zipake Special Package ', N'ZMW10', N'Savings', 1, N'K', 2, 5, N'Days', N'FLAT', 30, N'Days', N'SAVINGS', 10, 5000, 1, 360, N'INACTIVE', NULL, NULL, CAST(N'2021-04-15T12:13:45.000' AS DateTime), CAST(N'2021-04-15T12:13:45.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (13, N'Zambian Kwacha', N'ZP010', N'Zipake Savings Product', 1, N'K', 3, 6.5, N'Days', N'FLAT', 30, N'Days', N'SAVINGS', 5, 3500, 1, 360, N'INACTIVE', NULL, NULL, CAST(N'2021-04-15T12:26:56.000' AS DateTime), CAST(N'2021-04-15T13:41:43.000' AS DateTime))
INSERT [dbo].[tbl_products] ([id], [name], [code], [details], [currencyId], [currencyName], [currencyDecimals], [interest], [interestType], [interestMode], [defaultPeriod], [periodType], [productType], [minimumPrincipal], [maximumPrincipal], [clientId], [yearLengthInDays], [status], [minimumPeriod], [maximumPeriod], [inserted_at], [updated_at]) VALUES (10001, N'Zipake 2021', N'ZPK2021', N'Zipake 2021', 1, N'K', 2, 16.5, N'Years', N'FLAT', 30, N'Days', N'SAVINGS', 100, 1000, 1, 360, N'ACTIVE', NULL, NULL, CAST(N'2021-04-16T22:47:31.000' AS DateTime), CAST(N'2021-04-16T22:47:31.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_products] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_transactions] ON 

INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (1, 1, 100, 10001, N'SAVINGS', 22, 10002, N'2220159757', N'1291146910', N'CR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T12:37:33.000' AS DateTime), CAST(N'2021-04-17T12:37:33.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (2, 1, 500, 10001, N'SAVINGS', 22, 10002, N'2702424930', N'9721725345', N'CR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T12:39:40.000' AS DateTime), CAST(N'2021-04-17T12:39:40.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (3, 1, 100, 10001, N'SAVINGS', 22, 10002, N'9279594165', N'3247296248', N'DR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T14:36:38.000' AS DateTime), CAST(N'2021-04-17T14:36:38.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (4, 1, 100, 10001, N'SAVINGS', 22, 10002, N'2349751709', N'2787074167', N'DR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T14:44:50.000' AS DateTime), CAST(N'2021-04-17T14:44:50.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (5, 1, 100, 10001, N'SAVINGS', 22, 10002, N'5073204906', N'7150297213', N'CR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T14:44:50.000' AS DateTime), CAST(N'2021-04-17T14:44:50.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (6, 1, 100, 10001, N'SAVINGS', 22, 10002, N'6247847267', N'5461946202', N'DR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T14:45:29.000' AS DateTime), CAST(N'2021-04-17T14:45:29.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (7, 1, 100, 10001, N'SAVINGS', 22, 10002, N'7139409865', N'9226824658', N'CR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-17T14:45:29.000' AS DateTime), CAST(N'2021-04-17T14:45:29.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (8, 1, 100, 10001, N'SAVINGS', 22, 10002, N'4870271635', N'9192109349', N'DR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-18T14:55:39.000' AS DateTime), CAST(N'2021-04-18T14:55:39.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (9, 1, 100, 10001, N'SAVINGS', 22, 10002, N'5860390675', N'9651912976', N'CR', N'Success', 0, NULL, NULL, 22, 10002, CAST(N'2021-04-18T14:55:40.000' AS DateTime), CAST(N'2021-04-18T14:55:40.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (10, 10003, 500, 10001, N'SAVINGS', 23, 10003, N'6108218168', N'6036623749', N'CR', N'Success', 0, NULL, NULL, 23, 10003, CAST(N'2021-04-27T05:39:06.000' AS DateTime), CAST(N'2021-04-27T05:39:06.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (11, 10003, 100, 10001, N'SAVINGS', 23, 10003, N'8626881889', N'3708662637', N'DR', N'Success', 0, NULL, NULL, 23, 10003, CAST(N'2021-04-27T05:42:29.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime))
INSERT [dbo].[tbl_transactions] ([id], [accountId], [totalAmount], [productId], [productType], [userId], [userRoleId], [referenceNo], [orderRef], [transactionType], [status], [isReversed], [requestData], [responseData], [carriedOutByUserId], [carriedOutByUserRoleId], [inserted_at], [updated_at]) VALUES (12, 10003, 100, 10001, N'SAVINGS', 23, 10003, N'8167455803', N'6955740358', N'CR', N'Success', 0, NULL, NULL, 23, 10003, CAST(N'2021-04-27T05:42:29.000' AS DateTime), CAST(N'2021-04-27T05:42:29.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_transactions] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_user_bio_data] ON 

INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (1, N'Davies', N'Phiri', 1, N'Dolben', CAST(N'2020-01-01' AS Date), N'NRC', N'365924101', N'Mr.', N'Male', N'0978242442', N'davies@probasegroup.com', 1, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (2, N'John', N'Doe', 2, NULL, NULL, N'NRC', N'11111', NULL, NULL, N'260967307152', NULL, 2, CAST(N'2021-02-22T13:23:43.000' AS DateTime), CAST(N'2021-02-22T13:23:43.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (3, N'Judas', N'Iscariot', 3, NULL, NULL, N'NRC', N'1111', NULL, NULL, N'260978242442', NULL, 2, CAST(N'2021-02-22T13:35:21.000' AS DateTime), CAST(N'2021-02-22T13:35:21.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (4, N'QRuss', N'Kay', 10002, NULL, NULL, N'NRC', N'11111', NULL, NULL, N'260976799179', NULL, 2, CAST(N'2021-02-23T07:31:03.000' AS DateTime), CAST(N'2021-02-23T07:31:03.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (5, N'Test ', N'Walkin', 20004, N'weweewe', CAST(N'2021-02-03' AS Date), N'NRC', N'343434', NULL, N'MALE', NULL, N'pma@gmail.com', 20004, CAST(N'2021-02-23T19:59:27.000' AS DateTime), CAST(N'2021-02-23T19:59:27.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (6, N'Davies', N'Phiri', 20006, N'weweewe', CAST(N'2021-02-19' AS Date), N'NRC', N'343434', NULL, N'MALE', NULL, N'dolben800@gmail.com', 20006, CAST(N'2021-02-23T20:02:48.000' AS DateTime), CAST(N'2021-02-23T20:02:48.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T01:03:29.000' AS DateTime), CAST(N'2021-02-24T01:03:29.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T01:03:35.000' AS DateTime), CAST(N'2021-02-24T01:03:35.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T01:05:09.000' AS DateTime), CAST(N'2021-02-24T01:05:09.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T01:05:40.000' AS DateTime), CAST(N'2021-02-24T01:05:40.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T08:06:35.000' AS DateTime), CAST(N'2021-02-24T08:06:35.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T08:06:58.000' AS DateTime), CAST(N'2021-02-24T08:06:58.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T08:07:25.000' AS DateTime), CAST(N'2021-02-24T08:07:25.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T09:09:22.000' AS DateTime), CAST(N'2021-02-24T09:09:22.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (15, N'Test 2', N'jhjh', 30002, N'The S', CAST(N'2021-02-17' AS Date), N'NRC', N'34343434', NULL, N'FEMALE', NULL, N'davies@probasegroup.com', 30002, CAST(N'2021-02-24T09:40:06.000' AS DateTime), CAST(N'2021-02-24T09:40:06.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (16, N'kjkj', N'jhjh', 30003, N'The S', CAST(N'2021-02-25' AS Date), N'NRC', N'343434', NULL, N'MALE', NULL, N'davies@probasegroup.com', 30003, CAST(N'2021-02-24T09:44:05.000' AS DateTime), CAST(N'2021-02-24T09:44:05.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (17, N'Kachi', N'Akujua', 30004, N'Obinna', CAST(N'2021-02-11' AS Date), N'NRC', N'123456', N'Ms', N'MALE', N'260967307151', N'smicer66@gmail.com', 2, CAST(N'2021-02-24T09:55:52.000' AS DateTime), CAST(N'2021-02-24T09:55:52.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (18, N'fsdfdsf', N'fdsfdsf', 7, N'fdsfds', CAST(N'2021-02-21' AS Date), N'NRC', N'4324234324', N'Mr', N'MALE', N'260976527271', N'fsdfsd@sfsdfdf.com', 2, CAST(N'2021-02-24T10:31:21.000' AS DateTime), CAST(N'2021-02-24T10:31:21.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (19, N'Davies', N'Phiri', NULL, N'Dolben', CAST(N'2020-07-02' AS Date), N'NRC', N'365924', NULL, N'MALE', N'+260978242442', N'dolben800@gmail.com', NULL, CAST(N'2021-02-24T13:45:35.000' AS DateTime), CAST(N'2021-02-24T13:45:35.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (20, N'Davies', N'Phiri', NULL, N'Dolben', CAST(N'2020-07-02' AS Date), N'NRC', N'365924', NULL, N'MALE', N'+260978242442', N'dolben800@gmail.com', NULL, CAST(N'2021-02-24T13:47:27.000' AS DateTime), CAST(N'2021-02-24T13:47:27.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (21, N'David', N'Luswata', 40009, NULL, CAST(N'2021-03-03' AS Date), N'NRC', N'3454545', N'Mr', N'MALE', N'260965507151', N'david.luswata@gmail.com', 1, CAST(N'2021-03-03T15:13:29.000' AS DateTime), CAST(N'2021-03-03T15:13:29.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (22, N'Jeremiah', N'Jeremy', 40010, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'24554545', N'Mr', N'MALE', N'260987938191', N'jeremiah.jeremy@gmail.com', 1, CAST(N'2021-03-04T23:38:18.000' AS DateTime), CAST(N'2021-03-04T23:38:18.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (23, N'Tony', N'Abbas', 40011, NULL, CAST(N'2021-03-03' AS Date), N'NRC', N'34245544', N'Mr', N'MALE', N'260965327151', N'tony.abbas@gmail.com', 1, CAST(N'2021-03-04T23:38:52.000' AS DateTime), CAST(N'2021-03-04T23:38:52.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (24, N'Taonga', N'Shamach', 40012, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'45455667', N'Mr', N'MALE', N'260978398391', N'taonga.shamach@gmai.com', 1, CAST(N'2021-03-04T23:39:33.000' AS DateTime), CAST(N'2021-03-04T23:39:33.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (25, N'Susan', N'Berkley', 40013, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'32495060623', N'Mr', N'MALE', N'260998385151', N'susan.berkley@gmail.com', 1, CAST(N'2021-03-04T23:40:08.000' AS DateTime), CAST(N'2021-03-04T23:40:08.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (26, N'Kachinga', N'Nkhata', 40014, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'34662356', N'Mr', N'MALE', N'260978491724', N'kachinga.nkhata@gmail.com', 1, CAST(N'2021-03-04T23:40:45.000' AS DateTime), CAST(N'2021-03-04T23:40:45.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (27, N'Chiza', N'Mhalanga', 40015, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'39599120044', N'Mr', N'MALE', N'260978372841', N'chiza.mhalanga@gmail.com', 1, CAST(N'2021-03-04T23:41:15.000' AS DateTime), CAST(N'2021-03-04T23:41:15.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (28, N'Pamela', N'Sally', 40016, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'2354554512323', N'Mr', N'MALE', N'260967389581', N'pamela.sally@gmail.com', 1, CAST(N'2021-03-04T23:41:47.000' AS DateTime), CAST(N'2021-03-04T23:41:47.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (29, N'Amvii', N'Laravinge', 40017, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'23535555', N'Mr', N'MALE', N'260963481912', N'amvii@gmail.com', 1, CAST(N'2021-03-04T23:42:20.000' AS DateTime), CAST(N'2021-03-04T23:42:20.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (30, N'James', N'Henry', 40018, NULL, CAST(N'2021-03-04' AS Date), N'NRC', N'23343434', N'Mr', N'MALE', N'260964872151', N'james@gmail.com', 1, CAST(N'2021-03-04T23:50:09.000' AS DateTime), CAST(N'2021-03-04T23:50:09.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (31, N'Jordan', N'Manny', 40019, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'32356623233', N'Mr', N'MALE', N'260937293190', N'jordan@gmail.com', 1, CAST(N'2021-03-05T01:10:37.000' AS DateTime), CAST(N'2021-03-05T01:10:37.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (32, N'Jordan', N'Manny', 40020, NULL, CAST(N'2021-03-05' AS Date), N'NRC', N'32356623233', N'Mr', N'MALE', N'260937293190', N'jordan@gmail.com', 1, CAST(N'2021-03-05T01:13:34.000' AS DateTime), CAST(N'2021-03-05T01:13:34.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (10002, N'Kachi', N'Akujua', 22, NULL, NULL, N'NRC', N'124560', NULL, NULL, N'260967307151', NULL, 1, CAST(N'2021-04-17T08:56:12.000' AS DateTime), CAST(N'2021-04-17T08:56:12.000' AS DateTime))
INSERT [dbo].[tbl_user_bio_data] ([id], [firstName], [lastName], [userId], [otherName], [dateOfBirth], [meansOfIdentificationType], [meansOfIdentificationNumber], [title], [gender], [mobileNumber], [emailAddress], [clientId], [inserted_at], [updated_at]) VALUES (10003, N'Jar', N'JALO', 23, NULL, NULL, N'NRC', N'23568', NULL, NULL, N'260967307155', NULL, 1, CAST(N'2021-04-27T05:30:39.000' AS DateTime), CAST(N'2021-04-27T05:30:39.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_user_bio_data] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_user_logs] ON 

INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (1, N'logged in', 1, CAST(N'2021-04-15T09:45:39.000' AS DateTime), CAST(N'2021-04-15T09:45:39.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (2, N'logged in', 1, CAST(N'2021-04-15T09:45:59.000' AS DateTime), CAST(N'2021-04-15T09:45:59.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (3, N'logged in', 1, CAST(N'2021-04-15T09:48:24.000' AS DateTime), CAST(N'2021-04-15T09:48:24.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (4, N'logged in', 1, CAST(N'2021-04-15T09:48:40.000' AS DateTime), CAST(N'2021-04-15T09:48:40.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (5, N'logged in', 1, CAST(N'2021-04-15T09:49:24.000' AS DateTime), CAST(N'2021-04-15T09:49:24.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (6, N'logged in', 1, CAST(N'2021-04-15T09:50:29.000' AS DateTime), CAST(N'2021-04-15T09:50:29.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (7, N'logged in', 1, CAST(N'2021-04-15T09:51:52.000' AS DateTime), CAST(N'2021-04-15T09:51:52.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (8, N'logged in', 1, CAST(N'2021-04-15T09:52:56.000' AS DateTime), CAST(N'2021-04-15T09:52:56.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (9, N'logged in', 1, CAST(N'2021-04-15T09:54:53.000' AS DateTime), CAST(N'2021-04-15T09:54:53.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10, N'logged in', 1, CAST(N'2021-04-15T09:55:49.000' AS DateTime), CAST(N'2021-04-15T09:55:49.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (11, N'logged out', 1, CAST(N'2021-04-15T10:22:14.000' AS DateTime), CAST(N'2021-04-15T10:22:14.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (12, N'logged in', 1, CAST(N'2021-04-15T10:33:14.000' AS DateTime), CAST(N'2021-04-15T10:33:14.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (13, N'Created new Savings Product with code "ZP2"', 1, CAST(N'2021-04-15T12:01:53.000' AS DateTime), CAST(N'2021-04-15T12:01:53.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (14, N'Created new Savings Product with code "ZMW10"', 1, CAST(N'2021-04-15T12:13:45.000' AS DateTime), CAST(N'2021-04-15T12:13:45.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (15, N'Created new Savings Product with code "ZP009"', 1, CAST(N'2021-04-15T12:24:34.000' AS DateTime), CAST(N'2021-04-15T12:24:34.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (16, N'Created new Savings Product with code "ZP009"', 1, CAST(N'2021-04-15T12:25:29.000' AS DateTime), CAST(N'2021-04-15T12:25:29.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (17, N'Created new Savings Product with code "ZP009"', 1, CAST(N'2021-04-15T12:26:56.000' AS DateTime), CAST(N'2021-04-15T12:26:56.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (18, N'Updated Savings Product with code "13"', 1, CAST(N'2021-04-15T13:39:37.000' AS DateTime), CAST(N'2021-04-15T13:39:37.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (19, N'Updated Savings Product with code "13"', 1, CAST(N'2021-04-15T13:41:43.000' AS DateTime), CAST(N'2021-04-15T13:41:43.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (20, N'logged in', 1, CAST(N'2021-04-15T14:01:01.000' AS DateTime), CAST(N'2021-04-15T14:01:01.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (21, N'logged in', 1, CAST(N'2021-04-15T15:01:06.000' AS DateTime), CAST(N'2021-04-15T15:01:06.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (22, N'logged out', 1, CAST(N'2021-04-15T15:01:23.000' AS DateTime), CAST(N'2021-04-15T15:01:23.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (23, N'logged in', 1, CAST(N'2021-04-15T15:20:04.000' AS DateTime), CAST(N'2021-04-15T15:20:04.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (24, N'logged out', 1, CAST(N'2021-04-15T15:20:42.000' AS DateTime), CAST(N'2021-04-15T15:20:42.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (25, N'logged in', 1, CAST(N'2021-04-15T15:28:51.000' AS DateTime), CAST(N'2021-04-15T15:28:51.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10001, N'logged in', 1, CAST(N'2021-04-16T22:24:29.000' AS DateTime), CAST(N'2021-04-16T22:24:29.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10002, N'Created new Savings Product with code "ZPK2021"', 1, CAST(N'2021-04-16T22:47:31.000' AS DateTime), CAST(N'2021-04-16T22:47:31.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10003, N'logged in', 1, CAST(N'2021-04-18T17:37:06.000' AS DateTime), CAST(N'2021-04-18T17:37:06.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10004, N'logged in', 1, CAST(N'2021-04-18T18:56:20.000' AS DateTime), CAST(N'2021-04-18T18:56:20.000' AS DateTime))
INSERT [dbo].[tbl_user_logs] ([id], [activity], [user_id], [inserted_at], [updated_at]) VALUES (10005, N'logged in', 1, CAST(N'2021-04-27T04:43:28.000' AS DateTime), CAST(N'2021-04-27T04:43:28.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_user_logs] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_user_roles] ON 

INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (1, 1, N'BACKOFFICE_ADMIN', 1, N'ACTIVE', NULL, NULL, NULL, 1, NULL, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (2, 2, N'INDIVIDUAL', 2, N'ACTIVE', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-22T13:23:43.000' AS DateTime), CAST(N'2021-02-22T13:30:52.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (3, 3, N'INDIVIDUAL', 3, N'ACTIVE', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-22T13:37:53.000' AS DateTime), CAST(N'2021-02-22T13:40:33.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (4, 10002, N'INDIVIDUAL', 2, N'Active', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-23T07:31:10.000' AS DateTime), CAST(N'2021-02-23T07:34:02.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (5, 20004, N'INDIVIDUAL', 20004, N'ACTIVE', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-23T19:59:27.000' AS DateTime), CAST(N'2021-02-23T19:59:27.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (6, 20006, N'INDIVIDUAL', 20006, N'ACTIVE', N'9789      ', NULL, NULL, NULL, NULL, CAST(N'2021-02-23T20:02:48.000' AS DateTime), CAST(N'2021-02-23T20:02:48.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (7, 30002, N'INDIVIDUAL', 30002, N'ACTIVE', N'6958      ', NULL, NULL, NULL, NULL, CAST(N'2021-02-24T09:40:06.000' AS DateTime), CAST(N'2021-02-24T09:40:06.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (8, 30003, N'INDIVIDUAL', 2, N'ACTIVE', N'8496      ', NULL, NULL, NULL, NULL, CAST(N'2021-02-24T09:44:05.000' AS DateTime), CAST(N'2021-02-24T09:44:05.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (9, 30004, N'INDIVIDUAL', 2, N'ACTIVE', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T09:55:52.000' AS DateTime), CAST(N'2021-02-27T10:50:16.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (10, 1, N'INDIVIDUAL', 2, N'ACTIVE', NULL, NULL, NULL, NULL, NULL, CAST(N'2021-02-24T10:34:16.000' AS DateTime), CAST(N'2021-04-15T09:49:10.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (11, 30004, N'COMPANY ADMIN', 2, N'ACTIVE', N'7838      ', 1, NULL, NULL, NULL, CAST(N'2021-03-02T12:59:14.000' AS DateTime), CAST(N'2021-03-02T12:59:14.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (12, 30004, N'EMPLOYEE', 2, N'ACTIVE', NULL, 1, 70000, NULL, NULL, CAST(N'2021-03-02T21:21:02.000' AS DateTime), CAST(N'2021-03-03T11:12:04.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (13, 40009, N'COMPANY ADMIN', 2, N'ACTIVE', NULL, 1, NULL, NULL, NULL, CAST(N'2021-03-03T15:13:29.000' AS DateTime), CAST(N'2021-03-03T15:14:16.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (14, 40010, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', NULL, NULL, NULL, 1, NULL, CAST(N'2021-03-04T23:38:18.000' AS DateTime), CAST(N'2021-03-05T08:54:08.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (15, 40011, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', NULL, NULL, NULL, 1, NULL, CAST(N'2021-03-04T23:38:52.000' AS DateTime), CAST(N'2021-03-05T09:00:05.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (16, 40012, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', NULL, NULL, NULL, 2, NULL, CAST(N'2021-03-04T23:39:33.000' AS DateTime), CAST(N'2021-03-05T01:33:27.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (17, 40013, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', N'9595      ', NULL, NULL, 2, NULL, CAST(N'2021-03-04T23:40:09.000' AS DateTime), CAST(N'2021-03-04T23:40:09.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (18, 40014, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', N'4011      ', NULL, NULL, 2, NULL, CAST(N'2021-03-04T23:40:45.000' AS DateTime), CAST(N'2021-03-04T23:40:45.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (19, 40015, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', NULL, NULL, NULL, 1, 1, CAST(N'2021-03-04T23:41:15.000' AS DateTime), CAST(N'2021-03-05T01:40:42.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (20, 40016, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', N'1744      ', NULL, NULL, 1, NULL, CAST(N'2021-03-04T23:41:47.000' AS DateTime), CAST(N'2021-03-04T23:41:47.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (21, 40017, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', N'5477      ', NULL, NULL, 2, NULL, CAST(N'2021-03-04T23:42:20.000' AS DateTime), CAST(N'2021-03-04T23:42:20.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (22, 40018, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', N'3745      ', NULL, NULL, 1, NULL, CAST(N'2021-03-04T23:50:10.000' AS DateTime), CAST(N'2021-03-04T23:50:10.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (23, 40020, N'BACKOFFICE_ADMIN', 2, N'ACTIVE', NULL, NULL, NULL, 2, 1, CAST(N'2021-03-05T01:13:34.000' AS DateTime), CAST(N'2021-03-05T01:15:17.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (10001, 9, N'INDIVIDUAL', 1, N'Active', N'6225', NULL, NULL, NULL, NULL, CAST(N'2021-04-16T22:52:09.000' AS DateTime), CAST(N'2021-04-16T22:52:09.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (10002, 22, N'INDIVIDUAL', 1, N'ACTIVE', N'1518', NULL, NULL, NULL, NULL, CAST(N'2021-04-17T08:56:12.000' AS DateTime), CAST(N'2021-04-17T08:56:12.000' AS DateTime))
INSERT [dbo].[tbl_user_roles] ([id], [userId], [roleType], [clientId], [status], [otp], [companyId], [netPay], [branchId], [isLoanOfficer], [inserted_at], [updated_at]) VALUES (10003, 23, N'INDIVIDUAL', 1, N'ACTIVE', N'5140', NULL, NULL, NULL, NULL, CAST(N'2021-04-27T05:30:39.000' AS DateTime), CAST(N'2021-04-27T05:30:39.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_user_roles] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_users] ON 

INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (1, N'260976527271', N'4E563F840910B76119E397D84420B822E13C01B5CB261B5FF0B18D48F1BCD736D3DC391F99DC62606BF653FED7F43B854CF0C4E5EDF78F5341621F6CC8396C5C', 1, NULL, N'ACTIVE', NULL, CAST(N'2020-01-01T00:00:00.000' AS DateTime), CAST(N'2020-01-01T00:00:00.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (2, N'260967307152', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 2, NULL, N'DISABLED', NULL, CAST(N'2021-02-22T13:23:43.000' AS DateTime), CAST(N'2021-04-15T14:46:39.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (3, N'260978242442', N'4E563F840910B76119E397D84420B822E13C01B5CB261B5FF0B18D48F1BCD736D3DC391F99DC62606BF653FED7F43B854CF0C4E5EDF78F5341621F6CC8396C5C', 2, NULL, N'ACTIVE', NULL, CAST(N'2021-02-22T13:35:21.000' AS DateTime), CAST(N'2021-02-22T13:40:48.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (4, N'260976799179', N'4E563F840910B76119E397D84420B822E13C01B5CB261B5FF0B18D48F1BCD736D3DC391F99DC62606BF653FED7F43B854CF0C4E5EDF78F5341621F6CC8396C5C', 2, NULL, N'ACTIVE', NULL, CAST(N'2021-02-23T07:31:03.000' AS DateTime), CAST(N'2021-02-23T07:34:19.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (5, N'0978242446', NULL, NULL, NULL, N'ACTIVE', NULL, CAST(N'2021-02-23T19:59:27.000' AS DateTime), CAST(N'2021-02-23T19:59:27.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (6, N'260978242442', NULL, NULL, NULL, N'ACTIVE', NULL, CAST(N'2021-02-23T20:02:48.000' AS DateTime), CAST(N'2021-02-23T20:02:48.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (7, N'260978242446', NULL, NULL, NULL, N'ACTIVE', NULL, CAST(N'2021-02-24T09:40:06.000' AS DateTime), CAST(N'2021-02-24T09:40:06.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (8, N'260978242499', NULL, NULL, NULL, N'ACTIVE', NULL, CAST(N'2021-02-24T09:44:05.000' AS DateTime), CAST(N'2021-02-24T09:44:05.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (9, N'260967307151A', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 2, 1, N'ACTIVE', NULL, CAST(N'2021-02-24T09:55:52.000' AS DateTime), CAST(N'2021-02-27T10:50:38.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (10, N'260965507151', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-03T15:13:29.000' AS DateTime), CAST(N'2021-03-03T15:14:29.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (11, N'260987938191', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:38:18.000' AS DateTime), CAST(N'2021-03-05T08:54:17.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (12, N'260965327151', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:38:52.000' AS DateTime), CAST(N'2021-03-05T09:00:15.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (13, N'260978398391', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:39:33.000' AS DateTime), CAST(N'2021-03-05T01:33:38.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (14, N'260998385151', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:40:08.000' AS DateTime), CAST(N'2021-03-04T23:40:08.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (15, N'260978491724', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:40:44.000' AS DateTime), CAST(N'2021-03-04T23:40:44.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (16, N'260978372841', N'517ED6270D2BBA21CAC8258FD7D06391224F8E9FE269943DB00530D33BD859DFDAF4DBE9F34B5EC0478B95C0059D3B985F2134F76514C0C7165EC5B35E63D97E', 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:41:15.000' AS DateTime), CAST(N'2021-03-05T01:40:53.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (17, N'260967389581', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:41:47.000' AS DateTime), CAST(N'2021-03-04T23:41:47.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (18, N'260963481912', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:42:20.000' AS DateTime), CAST(N'2021-03-04T23:42:20.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (19, N'260964872151', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-04T23:50:09.000' AS DateTime), CAST(N'2021-03-04T23:50:09.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (20, N'260937293190', NULL, 1, 1, N'ACTIVE', NULL, CAST(N'2021-03-05T01:13:34.000' AS DateTime), CAST(N'2021-03-05T01:13:34.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (22, N'260967307151', NULL, 1, NULL, N'ACTIVE', NULL, CAST(N'2021-04-17T08:56:12.000' AS DateTime), CAST(N'2021-04-17T08:56:12.000' AS DateTime), 1)
INSERT [dbo].[tbl_users] ([id], [username], [password], [clientId], [createdByUserId], [status], [canOperate], [inserted_at], [updated_at], [ussdActive]) VALUES (23, N'260967307155', NULL, 1, NULL, N'ACTIVE', NULL, CAST(N'2021-04-27T05:30:39.000' AS DateTime), CAST(N'2021-04-27T05:30:39.000' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[tbl_users] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_workflow_items] ON 

INSERT [dbo].[tbl_workflow_items] ([id], [workFlowId], [createdByUserId], [workflowItemRecipientUserId], [createdByUserRoleId], [workflowItemRecipientUserRoleId], [branchId], [entityId], [entityType], [status], [actionTaken], [notes], [offTakerId], [currentWorkflowPosition], [inserted_at], [updated_at]) VALUES (1, 7, 40015, 1, 50014, 2, 1, 4, N'LOANS', N'APPROVED & FORWARDED WORKFLOW ITEM', N'APPROVED & FORWARDED WORKFLOW ITEM', N'Please review and approve', NULL, 1, CAST(N'2021-03-05T08:11:12.000' AS DateTime), CAST(N'2021-03-05T08:49:50.000' AS DateTime))
INSERT [dbo].[tbl_workflow_items] ([id], [workFlowId], [createdByUserId], [workflowItemRecipientUserId], [createdByUserRoleId], [workflowItemRecipientUserRoleId], [branchId], [entityId], [entityType], [status], [actionTaken], [notes], [offTakerId], [currentWorkflowPosition], [inserted_at], [updated_at]) VALUES (2, 7, 1, 40010, 2, 50009, 1, 4, N'LOANS', N'APPROVED & FORWARDED WORKFLOW ITEM', N'APPROVED & FORWARDED WORKFLOW ITEM', N'Please forwarded for approval', NULL, 2, CAST(N'2021-03-05T08:49:50.000' AS DateTime), CAST(N'2021-03-05T08:54:57.000' AS DateTime))
INSERT [dbo].[tbl_workflow_items] ([id], [workFlowId], [createdByUserId], [workflowItemRecipientUserId], [createdByUserRoleId], [workflowItemRecipientUserRoleId], [branchId], [entityId], [entityType], [status], [actionTaken], [notes], [offTakerId], [currentWorkflowPosition], [inserted_at], [updated_at]) VALUES (3, 7, 40010, 40011, 50009, 50010, 1, 4, N'LOANS', N'APPROVED & FORWARDED WORKFLOW ITEM', NULL, N'Please view and approve', NULL, 3, CAST(N'2021-03-05T08:54:57.000' AS DateTime), CAST(N'2021-03-05T08:54:57.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_workflow_items] OFF
GO
SET IDENTITY_INSERT [dbo].[tbl_workflow_members] ON 

INSERT [dbo].[tbl_workflow_members] ([id], [workFlowId], [userRoleId], [userId], [branchId], [orderPosition], [deletedAt], [inserted_at], [updated_at]) VALUES (1, 7, 2, 1, 1, 1, NULL, CAST(N'2021-03-05T00:22:25.000' AS DateTime), CAST(N'2021-03-05T00:22:25.000' AS DateTime))
INSERT [dbo].[tbl_workflow_members] ([id], [workFlowId], [userRoleId], [userId], [branchId], [orderPosition], [deletedAt], [inserted_at], [updated_at]) VALUES (2, 7, 50009, 40010, 1, 2, NULL, CAST(N'2021-03-05T00:22:25.000' AS DateTime), CAST(N'2021-03-05T00:22:25.000' AS DateTime))
INSERT [dbo].[tbl_workflow_members] ([id], [workFlowId], [userRoleId], [userId], [branchId], [orderPosition], [deletedAt], [inserted_at], [updated_at]) VALUES (3, 7, 50010, 40011, 1, 3, NULL, CAST(N'2021-03-05T00:22:25.000' AS DateTime), CAST(N'2021-03-05T00:22:25.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[tbl_workflow_members] OFF
GO
SET IDENTITY_INSERT [dbo].[ussd_requests] ON 

INSERT [dbo].[ussd_requests] ([id], [mobile_number], [request_data], [session_ended], [session_id], [is_logged_in], [inserted_at], [updated_at]) VALUES (1, N'260967307155', N'*778#*', 0, N'5ekyhk4kkrhm0bd5', NULL, CAST(N'2021-04-27T05:11:47.000' AS DateTime), CAST(N'2021-04-27T05:11:47.000' AS DateTime))
INSERT [dbo].[ussd_requests] ([id], [mobile_number], [request_data], [session_ended], [session_id], [is_logged_in], [inserted_at], [updated_at]) VALUES (2, N'260967307155', N'*778#*', 0, N'zs0osxefiqojy9wy', NULL, CAST(N'2021-04-27T05:23:42.000' AS DateTime), CAST(N'2021-04-27T05:23:42.000' AS DateTime))
INSERT [dbo].[ussd_requests] ([id], [mobile_number], [request_data], [session_ended], [session_id], [is_logged_in], [inserted_at], [updated_at]) VALUES (3, N'260967307155', N'*778#*Jar*JALO*23568*b*1*500*1*1*b*2*b*3*', 0, N'iz0wxdxlketwuhat', NULL, CAST(N'2021-04-27T05:30:09.000' AS DateTime), CAST(N'2021-04-27T05:39:40.000' AS DateTime))
INSERT [dbo].[ussd_requests] ([id], [mobile_number], [request_data], [session_ended], [session_id], [is_logged_in], [inserted_at], [updated_at]) VALUES (4, N'260967307155', N'*778#*4*1*1*100*1*b*5*b*0*', 0, N'lg0rb1q4ouxzects', NULL, CAST(N'2021-04-27T05:41:38.000' AS DateTime), CAST(N'2021-04-27T05:42:58.000' AS DateTime))
SET IDENTITY_INSERT [dbo].[ussd_requests] OFF
GO
ALTER TABLE [dbo].[tbl_account_charge] ADD  CONSTRAINT [DF__tbl_account_charge_isPaid]  DEFAULT ((0)) FOR [isPaid]
GO
ALTER TABLE [dbo].[tbl_addresses] ADD  CONSTRAINT [DF__tbl_addresses_isCurrent]  DEFAULT ((0)) FOR [isCurrent]
GO
ALTER TABLE [dbo].[tbl_branch] ADD  CONSTRAINT [DF__tbl_branch_isDefaultUSSDBranch]  DEFAULT ((0)) FOR [isDefaultUSSDBranch]
GO
ALTER TABLE [dbo].[tbl_charge] ADD  CONSTRAINT [DF__tbl_charge_isPenalty]  DEFAULT ((0)) FOR [isPenalty]
GO
ALTER TABLE [dbo].[tbl_clients] ADD  CONSTRAINT [DF__tbl_clients_isBank]  DEFAULT ((0)) FOR [isBank]
GO
ALTER TABLE [dbo].[tbl_clients] ADD  CONSTRAINT [DF__tbl_clients_isDomicileAccountAtBank]  DEFAULT ((0)) FOR [isDomicileAccountAtBank]
GO
ALTER TABLE [dbo].[tbl_confirmation_notification] ADD  CONSTRAINT [DF__tbl_confirmation_notification_read]  DEFAULT ((0)) FOR [read]
GO
ALTER TABLE [dbo].[tbl_fixed_deposit] ADD  CONSTRAINT [DF__tbl_fixed_deposit_isMatured]  DEFAULT ((0)) FOR [isMatured]
GO
ALTER TABLE [dbo].[tbl_fixed_deposit] ADD  CONSTRAINT [DF__tbl_fixed_deposit_isDivested]  DEFAULT ((0)) FOR [isDivested]
GO
ALTER TABLE [dbo].[tbl_fixed_deposit] ADD  CONSTRAINT [DF_tbl_fixed_deposit_productInterestMode]  DEFAULT (N'FLAT') FOR [productInterestMode]
GO
ALTER TABLE [dbo].[tbl_journal_entry] ADD  CONSTRAINT [DF__tbl_journal_entry_isReversed]  DEFAULT ((0)) FOR [isReversed]
GO
ALTER TABLE [dbo].[tbl_journal_entry] ADD  CONSTRAINT [DF__tbl_journal_entry_isSystemEntry]  DEFAULT ((0)) FOR [isSystemEntry]
GO
ALTER TABLE [dbo].[tbl_loan_charge] ADD  CONSTRAINT [DF__tbl_loan_charge_is_penalty]  DEFAULT ((0)) FOR [is_penalty]
GO
ALTER TABLE [dbo].[tbl_loan_charge] ADD  CONSTRAINT [DF__tbl_loan_charge_is_paid_derived]  DEFAULT ((0)) FOR [is_paid_derived]
GO
ALTER TABLE [dbo].[tbl_loan_charge] ADD  CONSTRAINT [DF__tbl_loan_charge_is_waived]  DEFAULT ((0)) FOR [is_waived]
GO
ALTER TABLE [dbo].[tbl_loan_charge] ADD  CONSTRAINT [DF__tbl_loan_charge_is_active]  DEFAULT ((0)) FOR [is_active]
GO
ALTER TABLE [dbo].[tbl_loan_installment_charge] ADD  CONSTRAINT [DF__tbl_loan_installment_charge_is_paid_derived]  DEFAULT ((0)) FOR [is_paid_derived]
GO
ALTER TABLE [dbo].[tbl_loan_installment_charge] ADD  CONSTRAINT [DF__tbl_loan_installment_charge_is_waived]  DEFAULT ((0)) FOR [is_waived]
GO
ALTER TABLE [dbo].[tbl_loan_product_document_type] ADD  CONSTRAINT [DF__tbl_loan_product_document_type_isRequired]  DEFAULT ((0)) FOR [isRequired]
GO
ALTER TABLE [dbo].[tbl_loan_transaction] ADD  CONSTRAINT [DF__tbl_loan_transaction_is_reversed]  DEFAULT ((0)) FOR [is_reversed]
GO
ALTER TABLE [dbo].[tbl_loan_transaction] ADD  CONSTRAINT [DF__tbl_loan_transaction_manually_adjusted_or_reversed]  DEFAULT ((0)) FOR [manually_adjusted_or_reversed]
GO
ALTER TABLE [dbo].[tbl_loans] ADD  CONSTRAINT [DF__tbl_loans_is_npa]  DEFAULT ((0)) FOR [is_npa]
GO
ALTER TABLE [dbo].[tbl_loans] ADD  CONSTRAINT [DF__tbl_loans_is_legacyloan]  DEFAULT ((0)) FOR [is_legacyloan]
GO
ALTER TABLE [dbo].[tbl_on_platform_notifications] ADD  CONSTRAINT [DF__tbl_on_platform_notifications_readYes]  DEFAULT ((0)) FOR [readYes]
GO
ALTER TABLE [dbo].[tbl_transactions] ADD  CONSTRAINT [DF__tbl_transactions_isReversed]  DEFAULT ((0)) FOR [isReversed]
GO
ALTER TABLE [dbo].[tbl_users] ADD  CONSTRAINT [DF_tbl_users_inserted_at]  DEFAULT ((1)) FOR [inserted_at]
GO
ALTER TABLE [dbo].[tbl_users] ADD  CONSTRAINT [DF_tbl_users_ussdActive]  DEFAULT ((1)) FOR [ussdActive]
GO
USE [master]
GO
ALTER DATABASE [mfz_savings] SET  READ_WRITE 
GO

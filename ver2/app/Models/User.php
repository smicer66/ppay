<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends MyModel implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
	protected $primaryKey = 'id';
    public $id;
    public $username;
    public $userEmail;
    public $token;
    public $role_code;
    public $all_banks;
    public $all_device_types;
    public $all_provinces;
    public $all_districts;
    public $all_countries;
    public $all_card_schemes;
    public $all_merchant_schemes;
    public $profile_pix;
    public $wallet_code;
    public $firstName;
    public $lastName;
    public $otherName;
    public $walletaccounts;
    public $balance;
    public $status;
    public $totalCredit;
    public $totalDebit;
    public $transactionCount;
    public $staff_bank_code;
    public $mobileno;
    public $merchant_dec_key;
    public $merchant_id;
    public $dashboardStatistics;
    public $passportImage;
    public $customerVerificationNo;



    /**
     * @return mixed
     */




    public function __construct(){
        parent::__construct();
    }


    public function getJWTIdentifier() {
        return $this->getKey();
    }


    public function getJWTCustomClaims() {
        return [];
    }


    public function getKey()
    {
        return $this->id;
    }


    public function setUser($id, $username, $token, $role_code, $all_banks,
                            $all_device_types, $all_provinces, $all_card_schemes, $all_merchant_schemes, $profile_pix,
                            $wallet_code, $firstName, $lastName, $otherName, $walletaccounts, $balance, $status, $totalCredit,
                            $totalDebit, $transactionCount, $staff_bank_code, $merchant_dec_key, $merchant_id, $dashboardStatistics,
                            $all_countries, $all_districts, $userEmail=NULL)
    {
        $this->id = $id;
        $this->username = $username;
        $this->userEmail = $userEmail;
        $this->token = $token;
        $this->role_code = $role_code;
        $this->all_banks = $all_banks;
        $this->all_device_types = $all_device_types;
        $this->all_countries = $all_countries;
        $this->all_provinces = $all_provinces;
        $this->all_districts = $all_districts;
        $this->all_card_schemes = $all_card_schemes;
        $this->all_merchant_schemes = $all_merchant_schemes;
        $this->profile_pix = $profile_pix;
        $this->wallet_code = $wallet_code;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->otherName = $otherName;
        $this->walletaccounts = $walletaccounts;
        $this->balance = $balance;
        $this->status = $status;
        $this->totalCredit = $totalCredit;
        $this->totalDebit = $totalDebit;
        $this->transactionCount = $transactionCount;
        $this->staff_bank_code = $staff_bank_code;
        $this->merchant_dec_key = $merchant_dec_key;
        $this->merchant_id = $merchant_id;
        $this->dashboardStatistics = $dashboardStatistics;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionCount()
    {
        return $this->transactionCount;
    }

    /**
     * @param mixed $transactionCount
     */
    public function setTransactionCount($transactionCount)
    {
        $this->transactionCount = $transactionCount;
    }

    /**
     * @return mixed
     */
    public function getTotalCredit()
    {
        return $this->totalCredit;
    }

    /**
     * @param mixed $totalCredit
     */
    public function setTotalCredit($totalCredit)
    {
        $this->totalCredit = $totalCredit;
    }

    /**
     * @return mixed
     */
    public function getTotalDebit()
    {
        return $this->totalDebit;
    }

    /**
     * @param mixed $totalDebit
     */
    public function setTotalDebit($totalDebit)
    {
        $this->totalDebit = $totalDebit;
    }

    /**
     * @return mixed
     */
    public function getWalletaccounts()
    {
        return $this->walletaccounts;
    }

    /**
     * @param mixed $walletaccounts
     */
    public function setWalletaccounts($walletaccounts)
    {
        $this->walletaccounts = $walletaccounts;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getOtherName()
    {
        return $this->otherName;
    }

    /**
     * @param mixed $otherName
     */
    public function setOtherName($otherName)
    {
        $this->otherName = $otherName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getWalletCode()
    {
        return $this->wallet_code;
    }

    /**
     * @param mixed $wallet_code
     */
    public function setWalletCode($wallet_code)
    {
        $this->wallet_code = $wallet_code;
    }

    /**
     * @return mixed
     */
    public function getAllBanks()
    {
        return $this->all_banks;
    }

    /**
     * @param mixed $all_banks
     */
    public function setAllBanks($all_banks)
    {
        $this->all_banks = $all_banks;
    }

    /**
     * @return mixed
     */
    public function getAllDeviceTypes()
    {
        return $this->all_device_types;
    }

    /**
     * @param mixed $all_device_types
     */
    public function setAllDeviceTypes($all_device_types)
    {
        $this->all_device_types = $all_device_types;
    }

    /**
     * @return mixed
     */
    public function getAllProvinces()
    {
        return $this->all_provinces;
    }

    /**
     * @param mixed $all_provinces
     */
    public function setAllProvinces($all_provinces)
    {
        $this->all_provinces = $all_provinces;
    }

    /**
     * @return mixed
     */
    public function getAllDistricts()
    {
        return $this->all_districts;
    }

    /**
     * @param mixed $all_provinces
     */
    public function setAllDistricts($all_districts)
    {
        $this->all_districts = $all_districts;
    }

    /**
     * @return mixed
     */
    public function getAllCardSchemes()
    {
        return $this->all_card_schemes;
    }

    /**
     * @param mixed $all_card_schemes
     */
    public function setAllCardSchemes($all_card_schemes)
    {
        $this->all_card_schemes = $all_card_schemes;
    }

    /**
     * @return mixed
     */
    public function getAllMerchantSchemes()
    {
        return $this->all_merchant_schemes;
    }

    /**
     * @param mixed $all_merchant_schemes
     */
    public function setAllMerchantSchemes($all_merchant_schemes)
    {
        $this->all_merchant_schemes = $all_merchant_schemes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getRoleCode()
    {
        return $this->role_code;
    }

    /**
     * @param mixed $role_code
     */
    public function setRoleCode($role_code)
    {
        $this->role_code = $role_code;
    }


    public function setMobileno($mobileno)
    {
        $this->mobileno = $mobileno;
    }

    public function getMobileno()
    {
        return $this->mobileno;
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array

    protected $fillable = ['id', 'username', 'token', 'role_code'];*/

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function setProfilePix($profile_pix)
    {
        $this->profile_pix = $profile_pix;
    }

    public function getProfilePix()
    {
        return $this->profile_pix;
    }


    public function getStaffBankCode()
    {
        return $this->staff_bank_code;
    }


    public function setStaffBankCode($staff_bank_code)
    {
        $this->staff_bank_code = $staff_bank_code;
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getMerchantDecKey()
    {
        return $this->merchant_dec_key;
    }

    /**
     * @param mixed $merchant_dec_key
     */
    public function setMerchantDecKey($merchant_dec_key)
    {
        $this->merchant_dec_key = $merchant_dec_key;
    }


    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param mixed $merchant_id
     */
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
    }

    /**
     * @return mixed
     */
    public function getDashboardStatistics()
    {
        return $this->dashboardStatistics;
    }

    /**
     * @param mixed $dashboardStatistics
     */
    public function setDashboardStatistics($dashboardStatistics)
    {
        $this->dashboardStatistics = $dashboardStatistics;
    }


    /**
     * @return mixed
     */
    public function getAllCountries()
    {
        return $this->all_countries;
    }

    /**
     * @param mixed $all_countries
     */
    public function setAllCountries($all_countries)
    {
        $this->all_countries = $all_countries;
    }

    /**
     * @param mixed
     */
    public function getCustomerVerification()
    {
        return $this->customerVerificationNo;
    }

    /**
     * @param mixed $customerVerificationNo
     */
    public function setCustomerVerification($customerVerificationNo)
    {
        $this->customerVerificationNo = $customerVerificationNo;
    }
}

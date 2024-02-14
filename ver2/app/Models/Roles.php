<?php

namespace App\Models;

class Roles extends MyModel
{
    public static $BANK_TELLER      = 'BANK_STAFF';
    public static $MERCHANT      = 'MERCHANT';
    public static $CUSTOMER      = 'CUSTOMER';
    public static $POTZR_STAFF      = 'POTZR_STAFF';
    public static $ACCOUNTANT = 'ACCOUNTANT';
    public static $ADMIN_USER = 'ADMIN_USER';
    public static $AGENT = 'AGENT';
    public static $EXCO_STAFF = 'EXCO_STAFF';

    function getRolesList()
    {
        return [
            'BANK_STAFF' => 'BANK TELLER',
            'MERCHANT' => 'MERCHANT',
            'CUSTOMER' => 'CUSTOMER',
            'POTZR_STAFF' => 'POTZR STAFF',
	     'ACCOUNTANT' => 'ACCOUNTANT',
	     'AGENT' => 'AGENT',
            'EXCO_STAFF' => 'EXCO STAFF',
        ];
    }

    function getAdminCreationRolesList()
    {
        return [
            'BANK_STAFF' => 'BANK TELLER',
            'POTZR_STAFF' => 'POTZR STAFF',
	     'ACCOUNTANT' => 'ACCOUNTANT',
	     'AGENT' => 'AGENT',
            'CUSTOMER' => 'CUSTOMER',
            'EXCO_STAFF' => 'EXCO STAFF',

        ];
    }

}

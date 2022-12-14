<?php

return [

     //Specify tanda environment, sandbox or production
     'env' => env('TANDA_ENV', 'sandbox'),

    /*-----------------------------------------
    |The App CLIENT ID
    |------------------------------------------
    */
    'client_id'   => env('TANDA_CLIENT_ID', ''),

    /*-----------------------------------------
    |The App CLIENT Secret
    |------------------------------------------
    */
    'client_secret' => env('TANDA_CLIENT_SECRET', ''),

    /*-----------------------------------------
    |The ORG ID
    |------------------------------------------
    */
    'org_id'         => env('TANDA_ORG_ID', ''),

    /*-----------------------------------------
    |Airtime callback
    |------------------------------------------
    */
    'topup_callback'  => '',

    /*-----------------------------------------
    |Billpay callback
    |------------------------------------------
    */
    'billpay_callback' => '',

    /*-----------------------------------------
    |Paytv callback
    |------------------------------------------
    */
    'paytv_callback' => '',

    /*-----------------------------------------
    |Airtime voucherfix callback
    |------------------------------------------
    */
    'voucher_callback' => '',

];

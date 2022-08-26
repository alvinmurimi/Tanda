<?php

return [

     //Specify tanda environment, sandbox or production
     'env' => env('TANDA_ENV', 'sandbox'),

    /*-----------------------------------------
    |The App CLIENT ID
    |------------------------------------------
    */
    'client_id'   => env('TANDA_CLIENT_ID', '5fcd60dc-a281-4616-9da1-5a6324c45ec7'),

    /*-----------------------------------------
    |The App CLIENT Secret
    |------------------------------------------
    */
    'client_secret' => env('TANDA_CLIENT_SECRET', '8OKXu0mcumfnyFhWOO4QzprA'),

    /*-----------------------------------------
    |The ORG ID
    |------------------------------------------
    */
    'org_id'         => env('TANDA_ORG_ID', 'c60aec89-eae9-4230-b48a-347f0f13fd95'),

    /*-----------------------------------------
    |Airtime callback
    |------------------------------------------
    */
    'topup_callback'  => 'https://webhook.site/f7c195aa-9b8f-4819-902e-64f86d47f4dd',

    /*-----------------------------------------
    |Billpay callback
    |------------------------------------------
    */
    'billpay_callback' => 'https://webhook.site/f7c195aa-9b8f-4819-902e-64f86d47f4dd',

    /*-----------------------------------------
    |Paytv callback
    |------------------------------------------
    */
    'paytv_callback' => 'https://webhook.site/f7c195aa-9b8f-4819-902e-64f86d47f4dd',

    /*-----------------------------------------
    |KPLC Tokens callback
    |------------------------------------------
    */
    'tokens_callback' => 'https://webhook.site/f7c195aa-9b8f-4819-902e-64f86d47f4dd',

    /*-----------------------------------------
    |Airtime voucherfix callback
    |------------------------------------------
    */
    'voucher_callback' => 'https://webhook.site/f7c195aa-9b8f-4819-902e-64f86d47f4dd',

];
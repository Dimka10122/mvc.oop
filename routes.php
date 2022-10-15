<?php
declare(strict_types=1);
/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

return (function(){
    $intGT0 = '[1-9]+\d*';
    $text = '[0-9aA-zZ_-]+';

    return [
        /** MESSAGES */
        [
            'regex' => '/^$/',
            'controller' => 'Messages/Index'
        ],
        [
            'regex' => '/^messages\/?$/',
            'controller' => 'Messages/Index'
        ],
        [
            'regex' => '/^messages\/add\/?$/',
            'controller' => 'Messages/Add'
        ],
        [
            'regex' => "/^messages\/($intGT0)\/delete\/?$/",
            'controller' => 'Messages/Delete',
            'params' => [
                'id' => 1
            ]
        ],
        [
            'regex' => "/^messages\/($intGT0)\/edit\/?$/",
            'controller' => 'Messages/Edit',
            'params' => [
                'id' => 1
            ]
        ],
        /** AUTHORIZE */
        [
            'regex' => '/^register\/?$/',
            'controller' => 'Authorize/Register'
        ],
        [
            'regex' => '/^login\/?$/',
            'controller' => 'Authorize/Login'
        ],
        [
            'regex' => '/^logout\/?$/',
            'controller' => 'Authorize/Logout'
        ],
        [
            'regex' => '/^forgot_pass\/?$/',
            'controller' => 'Authorize/ForgotPass'
        ],
        [
            'regex' => '/^forgot_pass_confirm\/?$/',
            'controller' => 'Authorize/ForgotPassConfirm'
        ],
        [
            'regex' => '/^change_pass\/?$/',
            'controller' => 'Authorize/ChangePass'
        ],
        [
            'regex' => "/^contacts\/?$/",
            'controller' => 'Contacts/Contacts'
        ],
        /** ROLES */
        [
            'regex' => '/^roles\/?$/',
            'controller' => 'Admin/Roles'
        ],
        [
            'regex' => "/^roles\/user\/($intGT0)\/edit\/?$/",
            'controller' => 'Admin/EditRole',
            'params' => [
                'id' => 1
            ]
        ],
        [
            'regex' => "/^roles\/($intGT0)\/modify\/?$/",
            'controller' => 'Admin/ModifyRole',
            'params' => [
                'id' => 1
            ]
        ],
        [
            'regex' => "/^roles\/($intGT0)\/delete\/?$/",
            'controller' => 'Admin/DeleteRole',
            'params' => [
                'id' => 1
            ]
        ],
        /** STATISTICS */
        [
            'regex' => "/^statistics\/?$/",
            'controller' => 'Admin/Statistics',
            'params' => [
                'id' => 1
            ]
        ],
        /** BLOCK */
        [
            'regex' => '/^block_users\/?$/',
            'controller' => 'Admin/BlockUsers'
        ],
        /** RISE */
        [
            'regex' => '/^rise\/request\/?$/',
            'controller' => 'Rise/Request'
        ],
        [
            'regex' => '/^rise\/change_rises\/?$/',
            'controller' => 'Rise/ChangeRises'
        ],
        [
            'regex' => "/^rise\/($intGT0)\/change_rise\/?$/",
            'controller' => 'Rise/ChangeRise',
            'params' => [
                'id' => 1
            ]
        ],
        /** CLI */
        [
            'regex' => '/^CLI$/',
            'controller' => 'CLI/CLI'
        ],
        /** PAGES */
        [
            'regex' => '/^pages\/?$/',
            'controller' => 'Pages/PagesList'
        ],
        [
            'regex' => '/^pages\/create_page\/?$/',
            'controller' => 'Pages/CreatePage'
        ],
        [
            'regex' => "/^pages\/($intGT0)\/edit$\/?$/",
            'controller' => 'Pages/EditPage',
            'params' => [
                'id' => 1
            ]
        ],
        [
            'regex' => "/^pages\/($intGT0)\/delete$\/?$/",
            'controller' => 'Pages/DeletePage',
            'params' => [
                'id' => 1
            ]
        ],
        [
            'regex' => "/^($text)\/?$/",
            'controller' => 'Pages/Page',
            'params' => [
                'url_key' => 1
            ]
        ],
        /** ERROR PAGE*/
        [
            'regex' => '/^error404$/',
            'controller' => 'Errors/E404'
        ]
    ];
})();
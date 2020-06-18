<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => env('APP_NAME'),

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Timber</b>Reception',

    'logo_mini' => '<b>TR</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'yellow-light',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/dashboard',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MENIU PRINCIPAL',
        // [
        //     'text' => 'Blog',
        //     'url'  => 'admin/blog',
        //     'can'  => 'manage-blog',
        // ],
        [
            'text'        => 'Dashboard',
            'url'         => 'dashboard',
            'icon'        => 'dashboard',
            'can'         => 'viewer',
        ],
        [
            'text'        => 'NIR an curent',
            'url'         => 'nir',
            'icon'        => 'list',
            'can'         => 'viewer',
        ],
        [
            'text' => 'Toate NIR',
            'url'  => 'nir/all',
            'icon' => 'list',
            'can'  => 'admin',
        ],
        [
            'text'        => 'Printeaza NIR',
            'url'         => '/nir/print_multiple',
            'icon'        => 'print',
            'can'         => 'user',
        ],
        [
            'text'        => 'Exporta NIR',
            'url'         => '/nir/export',
            'icon'        => 'table',
            'can'         => 'viewer',
        ],
        [
            'text'        => 'Facturi',
            'url'         => '/nir/invoices',
            'icon'        => 'file',
            'can'         => 'user',
        ],
        [
            'text'        => 'Reclamatii',
            'url'         => 'claims',
            'icon'        => 'file',
            'can'         => 'user',
        ],
        [
            'text'        => 'Ambalaje',
            'url'         => 'packaging',
            'icon'        => 'recycle',
            'can'         => 'user',
        ],
        [
            'text'        => 'Furnizori',
            'url'         => 'suppliers',
            'icon'        => 'link',
            'can'         => 'user',
        ],
        [
            'text'        => 'Subfurnizori',
            'url'         => 'sub_suppliers',
            'icon'        => 'tree',
            'can'         => 'user',
        ],
        'SETARI',
        [
            'text' => 'Profil utilizator',
            'url'  => 'profile',
            'icon' => 'user',
            'can'  => 'viewer',
        ],
        [
            'text'    => 'Nomenclator',
            'icon'    => 'cogs',
            'can' => 'user',
            'submenu' => [
                [
                    'text' => 'Date firma',
                    'url'  => 'companies',
                    'can'  => 'superadmin',
                ],
                [
                    'text' => 'Numere NIR',
                    'url'  => 'numbers',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Tari',
                    'url'  => 'countries',
                    'can'  => 'user',
                ],
                [
                    'text' => 'Mijloace de transport',
                    'url'  => 'vehicles',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Certificari',
                    'url'  => 'certifications',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Grup furnizori',
                    'url'  => 'supplier_group',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Status furnizori',
                    'url'  => 'supplier_status',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Articole',
                    'url'  => 'articles',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Specii',
                    'url'  => 'species',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Umiditati',
                    'url'  => 'moisture',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Comisii de receptie',
                    'url'  => '#',
                    'can'  => 'admin',
                    'submenu' => [
                        [
                            'text' => 'Comisii',
                            'url'  => 'reception',
                            'can'  => 'admin',
                        ],
                        [
                            'text' => 'Membri comisie',
                            'url'  => 'reception/members',
                            'can'  => 'admin',
                        ],

                    ],
                ],
                [
                    'text'    => 'Ambalaje',
                    'url'     => '#',
                    'can'     => 'user',
                    'submenu' => [
                        [
                            'text' => 'Grupa principala ambalaj',
                            'url'  => 'packaging/main',
                            'can'  => 'superadmin',
                        ],
                        [
                            'text'    => 'Subgrupa ambalaj',
                            'url'     => 'packaging/sub',
                            'can'     => 'admin',
                        ],[
                            'text'    => 'Cantitati per furnizor',
                            'url'     => 'packaging/supplier',
                            'can'     => 'user',
                        ],
                    ],
                ],
                [
                    'text' => 'Status reclamatii',
                    'url'  => 'claim_status',
                    'can'  => 'superadmin',
                ],
            ],
        ],
        [
            'text'    => 'Management utilizatori',
            'icon'    => 'users',
            'can' => 'superadmin',
            'submenu' => [
                [
                    'text' => 'Lista utilizatori',
                    'url'  => '/users/',
                    'icon' => 'check',
                    'can'  => 'superadmin',
                ],
                [
                    'text' => 'Drepturi acces companie',
                    'url'  => '/companies/assign/',
                    'icon' => 'check',
                    'can'  => 'superadmin',
                ]
            ]
        ]
        // 'LABELS',
        // [
        //     'text'       => 'Important',
        //     'icon_color' => 'red',
        // ],
        // [
        //     'text'       => 'Warning',
        //     'icon_color' => 'yellow',
        // ],
        // [
        //     'text'       => 'Information',
        //     'icon_color' => 'aqua',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];

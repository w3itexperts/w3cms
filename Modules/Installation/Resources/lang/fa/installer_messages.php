<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'نسخه',
    'title' => 'نصبکننده لاراول',
    'next' => 'مرحله بعد',
    'back' => 'قبلی',
    'finish' => 'نصب',
    'forms' => [
        'errorTitle' => 'خطاهای زیر رخ داده است:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'خوش آمدید',
        'title'   => 'نصبکننده لاراول',
        'message' => 'دستیار ساده نصب و راهاندازی.',
        'next'    => 'بررسی پیشنیازها',
        'choose_language'    => 'انتخاب زبان',
        'verify_requirements'    => 'بررسی پیشنیازها',
        'setup_environment'    => 'راهاندازی محیط',
        'configure_site'    => 'پیکربندی سایت',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'مرحله ۱ | پیشنیازهای سرور',
        'title' => 'پیشنیازها و مجوزهای سرور',
        'next'    => 'بعدی',
        'prev'    => 'قبلی',
        'required'    => 'الزامی',
        'error'     => 'لطفاً پیشنیازهای سرور را بررسی کرده و مجوزهای لازم را اعطا کنید.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'مرحله ۲ | مجوزها',
        'title' => 'مجوزها',
        'next' => 'پیکربندی محیط',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'تنظیمات محیط',
            'title' => 'تنظیمات محیط',
            'wizard-button' => 'راهاندازی با دستیار',
            'classic-button' => 'ویرایشگر متنی کلاسیک',
        ],
        'wizard' => [
            'templateTitle' => 'مرحله ۳ | تنظیمات محیط | دستیار راهاندازی',
            'step3_title' => 'تنظیمات محیط',
            'step4_title' => 'تنظیمات پایگاه داده',
            'step5_title' => 'تنظیمات برنامه',
            'step6_title' => 'تنظیمات مدیر',
            'step7_title' => 'موفقیت',
            'step3_description' => 'لطفاً نحوه پیکربندی فایل <code>.env</code> برنامه را انتخاب کنید.',
            'step4_description' => 'اطلاعات اتصال به پایگاه داده را در قسمت زیر وارد کنید. اگر از این اطلاعات مطمئن نیستید، با شرکت میزبان خود تماس بگیرید.',
            'step5_description' => 'لطفاً نحوه پیکربندی فایل <code>.env</code> برنامه را انتخاب کنید.',
            'step6_description' => 'اطلاعات مدیر را در قسمت زیر وارد کنید.',
            'step7_description' => 'W3cms با موفقیت نصب شد. از شما متشکریم و امیدواریم از آن لذت ببرید.',
            'tabs' => [
                'environment' => 'محیط',
                'database' => 'پایگاه داده',
                'application' => 'برنامه',
            ],
            'form' => [
                'name_required' => 'نام محیط الزامی است.',
                'app_name_label' => 'نام برنامه',
                'app_name_placeholder' => 'نام برنامه',
                'app_environment_label' => 'محیط برنامه',
                'app_environment_label_local' => 'محلی',
                'app_environment_label_developement' => 'توسعه',
                'app_environment_label_qa' => 'کنترل کیفیت',
                'app_environment_label_production' => 'تولید',
                'app_environment_label_other' => 'سایر',
                'app_environment_placeholder_other' => 'محیط خود را وارد کنید...',
                'app_debug_label' => 'اشکالزدایی برنامه',
                'app_debug_label_true' => 'فعال',
                'app_debug_label_false' => 'غیرفعال',
                'app_log_level_label' => 'سطح گزارش برنامه',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'آدرس برنامه',
                'app_url_placeholder' => 'آدرس برنامه',
                'asset_url_label' => 'آدرس منابع',
                'asset_url_placeholder' => 'آدرس منابع',
                'db_connection_failed' => 'اتصال به پایگاه داده امکانپذیر نبود.',
                'db_connection_label' => 'اتصال پایگاه داده',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'میزبان پایگاه داده',
                'db_host_placeholder' => 'میزبان پایگاه داده',
                'db_port_label' => 'پورت پایگاه داده',
                'db_port_placeholder' => 'پورت پایگاه داده',
                'db_name_label' => 'نام پایگاه داده',
                'db_name_placeholder' => 'نام پایگاه داده',
                'db_username_label' => 'نام کاربری پایگاه داده',
                'db_username_placeholder' => 'نام کاربری پایگاه داده',
                'db_password_label' => 'رمز عبور پایگاه داده',
                'db_password_placeholder' => 'رمز عبور پایگاه داده',

                'app_tabs' => [
                    'more_info' => 'اطلاعات بیشتر',
                    'broadcasting_title' => 'Broadcasting، کش، نشست و صف',
                    'broadcasting_label' => 'درایور Broadcast',
                    'broadcasting_placeholder' => 'درایور Broadcast',
                    'cache_label' => 'درایور کش',
                    'cache_placeholder' => 'درایور کش',
                    'filesystem_driver_label' => 'درایور سیستم فایل',
                    'filesystem_driver_placeholder' => 'درایور سیستم فایل',
                    'session_label' => 'درایور نشست',
                    'session_placeholder' => 'درایور نشست',
                    'queue_connection_label' => 'اتصال صف',
                    'queue_connection_placeholder' => 'اتصال صف',
                    'redis_label' => 'درایور Redis',
                    'redis_host' => 'میزبان Redis',
                    'redis_password' => 'رمز عبور Redis',
                    'redis_port' => 'پورت Redis',

                    'mail_label' => 'ایمیل',
                    'mail_driver_label' => 'درایور ایمیل',
                    'mail_driver_placeholder' => 'درایور ایمیل',
                    'mail_host_label' => 'میزبان ایمیل',
                    'mail_host_placeholder' => 'میزبان ایمیل',
                    'mail_port_label' => 'پورت ایمیل',
                    'mail_port_placeholder' => 'پورت ایمیل',
                    'mail_username_label' => 'نام کاربری ایمیل',
                    'mail_username_placeholder' => 'نام کاربری ایمیل',
                    'mail_password_label' => 'رمز عبور ایمیل',
                    'mail_password_placeholder' => 'رمز عبور ایمیل',
                    'mail_encryption_label' => 'رمزنگاری ایمیل',
                    'mail_encryption_placeholder' => 'رمزنگاری ایمیل',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'شناسه کلید دسترسی AWS',
                    'aws_access_key_placeholder' => 'شناسه کلید دسترسی AWS',
                    'aws_secret_key_label' => 'کلید دسترسی AWS',
                    'aws_secret_key_placeholder' => 'کلید دسترسی AWS',
                    'aws_default_region_label' => 'منطقه پیشفرض AWS',
                    'aws_default_region_placeholder' => 'منطقه پیشفرض AWS',
                    'aws_bucket_label' => 'Bucket مربوط به AWS',
                    'aws_bucket_placeholder' => 'Bucket مربوط به AWS',
                    'aws_endpoint_label' => 'استفاده از Endpoint با ساختار مسیر AWS',
                    'aws_endpoint_placeholder' => 'استفاده از Endpoint با ساختار مسیر AWS',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'شناسه برنامه Pusher',
                    'pusher_app_id_palceholder' => 'شناسه برنامه Pusher',
                    'pusher_app_key_label' => 'کلید برنامه Pusher',
                    'pusher_app_key_palceholder' => 'کلید برنامه Pusher',
                    'pusher_app_secret_label' => 'کلید مخفی برنامه Pusher',
                    'pusher_app_secret_palceholder' => 'کلید مخفی برنامه Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'نام برنامه را تعیین کنید.',
                    'app_environment' => 'محیطی که میخواهید در برنامه استفاده کنید.',
                    'app_debug' => 'تعیین میکند چه مقدار از جزئیات خطا به کاربر نمایش داده شود.',
                    'app_log_level' => 'سطح گزارش برنامه را تعیین کنید.',
                    'app_url' => 'آدرس موردنظر برنامه را تعیین کنید.',
                    'db_connection' => 'اتصال پایگاه داده برنامه.',
                    'db_host' => 'میزبان پایگاه داده برنامه را تعیین کنید.',
                    'db_port' => 'پورت پایگاه داده برنامه را تعیین کنید.',
                    'db_name' => 'نام پایگاه دادهای که میخواهید با W3mcs استفاده کنید.',
                    'db_user_name' => 'نام کاربری پایگاه داده شما.',
                    'db_password' => 'رمز عبور پایگاه داده شما.',
                ],
                'buttons' => [
                    'setup_database' => 'راهاندازی پایگاه داده',
                    'setup_application' => 'راهاندازی برنامه',
                    'save' => 'ذخیره',
                    'installation' => 'اجرای نصب',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'مرحله ۳ | تنظیمات محیط | ویرایشگر کلاسیک',
            'title' => 'ویرایشگر کلاسیک محیط',
            'save' => 'ذخیره .env',
            'back' => 'استفاده از دستیار',
            'install' => 'ذخیره و نصب',
        ],
        'success' => 'تنظیمات فایل .env با موفقیت ذخیره شد.',
        'errors' => 'ذخیره فایل .env امکانپذیر نبود. لطفاً آن را به صورت دستی ایجاد کنید.',
    ],

    'install' => 'نصب',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer با موفقیت نصب شد در ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'نصب به پایان رسید',
        'templateTitle' => 'نصب به پایان رسید',
        'finished' => 'برنامه با موفقیت نصب شد.',
        'migration' => 'خروجی کنسول Migration و Seed:',
        'console' => 'خروجی کنسول برنامه:',
        'log' => 'ورودی گزارش نصب:',
        'env' => 'فایل نهایی .env:',
        'exit' => 'برای ورود اینجا کلیک کنید',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'راهاندازی مدیر'
        ],
        'name' => 'نام کامل',
        'name_description' => 'نام کامل کاربر را وارد کنید. نام کامل میتواند شامل حروف، اعداد و سایر کاراکترها باشد.',
        'email' => 'ایمیل',
        'email_description' => 'قبل از ادامه، آدرس ایمیل خود را به دقت بررسی کنید.',
        'password' => 'رمز عبور',
        'password_description' => 'مهم: برای ورود به این رمز عبور نیاز خواهید داشت. لطفاً آن را در مکانی امن نگهداری کنید.',
        'confirm_password' => 'تأیید رمز عبور',
        'confirm_password_description' => 'رمز عبور خود را مجدداً در این قسمت تأیید کنید.',
        'save' => 'ذخیره و ورود',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'برای اتصال به پایگاه داده، روی دکمه اجرای نصب کلیک کنید.'
        ],
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'بهروزرسان لاراول',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'به بهروزرسان خوش آمدید',
            'message' => 'به دستیار بهروزرسانی خوش آمدید.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'نمای کلی',
            'message' => '۱ بهروزرسانی وجود دارد.|:number بهروزرسانی وجود دارد.',
            'install_updates' => 'نصب بهروزرسانیها',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'پایان',
            'finished' => 'پایگاه داده برنامه با موفقیت بهروزرسانی شد.',
            'exit' => 'برای خروج اینجا کلیک کنید',
        ],

        'log' => [
            'success_message' => 'Laravel Installer با موفقیت بهروزرسانی شد در ',
        ],
    ],
];

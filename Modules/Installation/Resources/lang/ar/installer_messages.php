<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'الإصدار',
    'title' => 'مثبّت Laravel',
    'next' => 'الخطوة التالية',
    'back' => 'السابق',
    'finish' => 'تثبيت',
    'forms' => [
        'errorTitle' => 'حدثت الأخطاء التالية:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'مرحباً',
        'title'   => 'مثبّت Laravel',
        'message' => 'معالج سهل للتثبيت والإعداد.',
        'next'    => 'التحقق من المتطلبات',
        'choose_language'    => 'اختر اللغة',
        'verify_requirements'    => 'التحقق من المتطلبات',
        'setup_environment'    => 'إعداد البيئة',
        'configure_site'    => 'إعداد الموقع',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'الخطوة 1 | متطلبات الخادم',
        'title' => 'متطلبات الخادم والصلاحيات',
        'next'    => 'التالي',
        'prev'    => 'السابق',
        'required'    => 'مطلوب',
        'error'     => 'يرجى التحقق من متطلبات الخادم ومنح الصلاحيات المطلوبة.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'الخطوة 2 | الصلاحيات',
        'title' => 'الصلاحيات',
        'next' => 'إعداد البيئة',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'إعدادات البيئة',
            'title' => 'إعدادات البيئة',
            'wizard-button' => 'الإعداد باستخدام المعالج',
            'classic-button' => 'المحرر النصي التقليدي',
        ],

        'wizard' => [
            'templateTitle' => 'الخطوة 3 | إعدادات البيئة | المعالج',
            'step3_title' => 'إعدادات البيئة',
            'step4_title' => 'إعدادات قاعدة البيانات',
            'step5_title' => 'إعدادات التطبيق',
            'step6_title' => 'إعدادات المسؤول',
            'step7_title' => 'تم بنجاح',
            'step3_description' => 'يرجى اختيار الطريقة التي تريد استخدامها لإعداد ملف <code>.env</code> الخاص بالتطبيق.',
            'step4_description' => 'أدخل أدناه بيانات الاتصال بقاعدة البيانات. إذا لم تكن متأكداً منها، يرجى التواصل مع مزود الاستضافة.',
            'step5_description' => 'يرجى اختيار الطريقة التي تريد استخدامها لإعداد ملف <code>.env</code> الخاص بالتطبيق.',
            'step6_description' => 'أدخل أدناه بيانات المسؤول.',
            'step7_description' => 'تم تثبيت W3cms بنجاح. شكراً لك ونتمنى لك تجربة ممتعة.',
            'tabs' => [
                'environment' => 'البيئة',
                'database' => 'قاعدة البيانات',
                'application' => 'التطبيق',
            ],

            'form' => [
                'name_required' => 'اسم البيئة مطلوب.',
                'app_name_label' => 'اسم التطبيق',
                'app_name_placeholder' => 'اسم التطبيق',
                'app_environment_label' => 'بيئة التطبيق',
                'app_environment_label_local' => 'محلي',
                'app_environment_label_developement' => 'تطوير',
                'app_environment_label_qa' => 'اختبار الجودة',
                'app_environment_label_production' => 'إنتاج',
                'app_environment_label_other' => 'أخرى',
                'app_environment_placeholder_other' => 'أدخل بيئة التطبيق...',
                'app_debug_label' => 'تصحيح أخطاء التطبيق',
                'app_debug_label_true' => 'مفعّل',
                'app_debug_label_false' => 'معطّل',
                'app_log_level_label' => 'مستوى سجل التطبيق',
                'app_log_level_label_debug' => 'تصحيح',
                'app_log_level_label_info' => 'معلومات',
                'app_log_level_label_notice' => 'إشعار',
                'app_log_level_label_warning' => 'تحذير',
                'app_log_level_label_error' => 'خطأ',
                'app_log_level_label_critical' => 'حرج',
                'app_log_level_label_alert' => 'تنبيه',
                'app_log_level_label_emergency' => 'طوارئ',
                'app_url_label' => 'رابط التطبيق',
                'app_url_placeholder' => 'رابط التطبيق',
                'asset_url_label' => 'رابط الأصول',
                'asset_url_placeholder' => 'رابط الأصول',

                'db_connection_failed' => 'تعذر الاتصال بقاعدة البيانات.',
                'db_connection_label' => 'اتصال قاعدة البيانات',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'مضيف قاعدة البيانات',
                'db_host_placeholder' => 'مضيف قاعدة البيانات',
                'db_port_label' => 'منفذ قاعدة البيانات',
                'db_port_placeholder' => 'منفذ قاعدة البيانات',
                'db_name_label' => 'اسم قاعدة البيانات',
                'db_name_placeholder' => 'اسم قاعدة البيانات',
                'db_username_label' => 'اسم مستخدم قاعدة البيانات',
                'db_username_placeholder' => 'اسم مستخدم قاعدة البيانات',
                'db_password_label' => 'كلمة مرور قاعدة البيانات',
                'db_password_placeholder' => 'كلمة مرور قاعدة البيانات',

                'app_tabs' => [
                    'more_info' => 'معلومات إضافية',

                    'broadcasting_title' => 'البث والتخزين المؤقت والجلسات وقائمة الانتظار',
                    'broadcasting_label' => 'مشغل البث',
                    'broadcasting_placeholder' => 'مشغل البث',
                    'cache_label' => 'مشغل التخزين المؤقت',
                    'cache_placeholder' => 'مشغل التخزين المؤقت',
                    'filesystem_driver_label' => 'مشغل نظام الملفات',
                    'filesystem_driver_placeholder' => 'مشغل نظام الملفات',
                    'session_label' => 'مشغل الجلسات',
                    'session_placeholder' => 'مشغل الجلسات',
                    'queue_connection_label' => 'اتصال قائمة الانتظار',
                    'queue_connection_placeholder' => 'اتصال قائمة الانتظار',
                    'redis_label' => 'مشغل Redis',
                    'redis_host' => 'مضيف Redis',
                    'redis_password' => 'كلمة مرور Redis',
                    'redis_port' => 'منفذ Redis',

                    'mail_label' => 'البريد الإلكتروني',
                    'mail_driver_label' => 'مشغل البريد',
                    'mail_driver_placeholder' => 'مشغل البريد',
                    'mail_host_label' => 'مضيف البريد',
                    'mail_host_placeholder' => 'مضيف البريد',
                    'mail_port_label' => 'منفذ البريد',
                    'mail_port_placeholder' => 'منفذ البريد',
                    'mail_username_label' => 'اسم مستخدم البريد',
                    'mail_username_placeholder' => 'اسم مستخدم البريد',
                    'mail_password_label' => 'كلمة مرور البريد',
                    'mail_password_placeholder' => 'كلمة مرور البريد',
                    'mail_encryption_label' => 'تشفير البريد',
                    'mail_encryption_placeholder' => 'تشفير البريد',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'معرّف مفتاح وصول AWS',
                    'aws_access_key_placeholder' => 'معرّف مفتاح وصول AWS',
                    'aws_secret_key_label' => 'مفتاح وصول AWS السري',
                    'aws_secret_key_placeholder' => 'مفتاح وصول AWS السري',
                    'aws_default_region_label' => 'المنطقة الافتراضية لـ AWS',
                    'aws_default_region_placeholder' => 'المنطقة الافتراضية لـ AWS',
                    'aws_bucket_label' => 'حاوية AWS',
                    'aws_bucket_placeholder' => 'حاوية AWS',
                    'aws_endpoint_label' => 'استخدام نمط المسار لنقطة نهاية AWS',
                    'aws_endpoint_placeholder' => 'استخدام نمط المسار لنقطة نهاية AWS',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'معرّف تطبيق Pusher',
                    'pusher_app_id_palceholder' => 'معرّف تطبيق Pusher',
                    'pusher_app_key_label' => 'مفتاح تطبيق Pusher',
                    'pusher_app_key_palceholder' => 'مفتاح تطبيق Pusher',
                    'pusher_app_secret_label' => 'المفتاح السري لتطبيق Pusher',
                    'pusher_app_secret_palceholder' => 'المفتاح السري لتطبيق Pusher',
                ],

                'input_labels' => [
                    'app_name' => 'حدد اسم التطبيق.',
                    'app_environment' => 'حدد البيئة التي تريد استخدامها في التطبيق.',
                    'app_debug' => 'يحدد مقدار تفاصيل الخطأ التي يتم عرضها للمستخدم.',
                    'app_log_level' => 'حدد مستوى سجل التطبيق.',
                    'app_url' => 'حدد رابط التطبيق الذي تريده.',
                    'db_connection' => 'اتصال قاعدة البيانات الخاص بالتطبيق.',
                    'db_host' => 'حدد مضيف قاعدة البيانات الخاص بالتطبيق.',
                    'db_port' => 'حدد منفذ قاعدة البيانات الخاص بالتطبيق.',
                    'db_name' => 'اسم قاعدة البيانات التي تريد استخدامها مع W3cms.',
                    'db_user_name' => 'اسم مستخدم قاعدة البيانات.',
                    'db_password' => 'كلمة مرور قاعدة البيانات.',
                ],

                'buttons' => [
                    'setup_database' => 'إعداد قاعدة البيانات',
                    'setup_application' => 'إعداد التطبيق',
                    'save' => 'حفظ',
                    'installation' => 'تشغيل التثبيت',
                ],
            ],
        ],

        'classic' => [
            'templateTitle' => 'الخطوة 3 | إعدادات البيئة | المحرر التقليدي',
            'title' => 'محرر البيئة التقليدي',
            'save' => 'حفظ ملف .env',
            'back' => 'استخدام المعالج',
            'install' => 'حفظ وتثبيت',
        ],

        'success' => 'تم حفظ إعدادات ملف .env بنجاح.',
        'errors' => 'تعذر حفظ ملف .env، يرجى إنشاؤه يدوياً.',
    ],

    'install' => 'تثبيت',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'تم تثبيت Laravel Installer بنجاح في ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'اكتمل التثبيت',
        'templateTitle' => 'اكتمل التثبيت',
        'finished' => 'تم تثبيت التطبيق بنجاح.',
        'migration' => 'مخرجات وحدة تحكم الترحيل والبذر:',
        'console' => 'مخرجات وحدة تحكم التطبيق:',
        'log' => 'إدخال سجل التثبيت:',
        'env' => 'ملف .env النهائي:',
        'exit' => 'اضغط هنا لتسجيل الدخول',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'إعداد المسؤول'
        ],
        'name' => 'الاسم الكامل',
        'name_description' => 'أدخل الاسم الكامل للمستخدم. يمكن أن يحتوي الاسم الكامل على أحرف وأرقام وغيرها.',
        'email' => 'البريد الإلكتروني',
        'email_description' => 'تأكد من صحة عنوان بريدك الإلكتروني قبل المتابعة.',
        'password' => 'كلمة المرور',
        'password_description' => 'مهم: ستحتاج إلى كلمة المرور هذه لتسجيل الدخول. يرجى حفظها في مكان آمن.',
        'confirm_password' => 'تأكيد كلمة المرور',
        'confirm_password_description' => 'يرجى تأكيد كلمة المرور مرة أخرى.',
        'save' => 'حفظ وتسجيل الدخول',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'للاتصال بقاعدة البيانات، اضغط على زر تشغيل التثبيت.'
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
        'title' => 'محدّث Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'مرحباً بك في المحدّث',
            'message' => 'مرحباً بك في معالج التحديث.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'نظرة عامة',
            'message' => 'يوجد تحديث واحد.|يوجد :number تحديثات.',
            'install_updates' => 'تثبيت التحديثات',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'اكتمل',
            'finished' => 'تم تحديث قاعدة بيانات التطبيق بنجاح.',
            'exit' => 'اضغط هنا للخروج',
        ],

        'log' => [
            'success_message' => 'تم تحديث Laravel Installer بنجاح في ',
        ],
    ],
];
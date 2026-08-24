<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versioon',
    'title' => 'Laravel Installer',
    'next' => 'Järgmine samm',
    'back' => 'Eelmine',
    'finish' => 'Installi',
    'forms' => [
        'errorTitle' => 'Esinesid järgmised vead:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Tere tulemast',
        'title'   => 'Laravel Installer',
        'message' => 'Lihtne paigaldus- ja seadistusviisard.',
        'next'    => 'Kontrolli nõudeid',
        'choose_language'    => 'Vali keel',
        'verify_requirements'    => 'Kontrolli nõudeid',
        'setup_environment'    => 'Seadista keskkond',
        'configure_site'    => 'Seadista sait',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Samm 1 | Serveri nõuded',
        'title' => 'Serveri nõuded ja õigused',
        'next'    => 'Edasi',
        'prev'    => 'Tagasi',
        'required'    => 'nõutud',
        'error'     => 'Palun kontrollige serveri nõudeid ja andke vajalikud õigused.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Samm 2 | Õigused',
        'title' => 'Õigused',
        'next' => 'Seadista keskkond',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Keskkonna seadete seadistamine',
            'title' => 'Keskkonna seadete seadistamine',
            'wizard-button' => 'Seadistusviisard',
            'classic-button' => 'Klassikaline tekstiredaktor',
        ],
        'wizard' => [
            'templateTitle' => 'Samm 3 | Keskkonna seaded | Juhendatud viisard',
            'step3_title' => 'Keskkonna seadete seadistamine',
            'step4_title' => 'Andmebaasi seadete seadistamine',
            'step5_title' => 'Rakenduse seadete seadistamine',
            'step6_title' => 'Administraatori seadete seadistamine',
            'step7_title' => 'Õnnestus',
            'step3_description' => 'Palun valige, kuidas soovite rakenduse <code>.env</code>-faili seadistada.',
            'step4_description' => 'Sisestage allpool oma andmebaasi ühenduse andmed. Kui te pole nendes kindel, võtke ühendust oma hostingu pakkujaga.',
            'step5_description' => 'Palun valige, kuidas soovite rakenduse <code>.env</code>-faili seadistada.',
            'step6_description' => 'Sisestage allpool administraatori andmed.',
            'step7_description' => 'W3cms on installitud. Täname ja soovime meeldivat kasutamist.',
            'tabs' => [
                'environment' => 'Keskkond',
                'database' => 'Andmebaas',
                'application' => 'Rakendus',
            ],
            'form' => [
                'name_required' => 'Keskkonna nimi on kohustuslik.',
                'app_name_label' => 'Rakenduse nimi',
                'app_name_placeholder' => 'Rakenduse nimi',
                'app_environment_label' => 'Rakenduse keskkond',
                'app_environment_label_local' => 'Kohalik',
                'app_environment_label_developement' => 'Arendus',
                'app_environment_label_qa' => 'Kvaliteedikontroll',
                'app_environment_label_production' => 'Tootmine',
                'app_environment_label_other' => 'Muu',
                'app_environment_placeholder_other' => 'Sisestage oma keskkond...',
                'app_debug_label' => 'Rakenduse silumine',
                'app_debug_label_true' => 'Jah',
                'app_debug_label_false' => 'Ei',
                'app_log_level_label' => 'Rakenduse logitaseme',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Rakenduse URL',
                'app_url_placeholder' => 'Rakenduse URL',
                'asset_url_label' => 'Varade URL',
                'asset_url_placeholder' => 'Varade URL',
                'db_connection_failed' => 'Andmebaasiga ei õnnestunud ühendust luua.',
                'db_connection_label' => 'Andmebaasi ühendus',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Andmebaasi host',
                'db_host_placeholder' => 'Andmebaasi host',
                'db_port_label' => 'Andmebaasi port',
                'db_port_placeholder' => 'Andmebaasi port',
                'db_name_label' => 'Andmebaasi nimi',
                'db_name_placeholder' => 'Andmebaasi nimi',
                'db_username_label' => 'Andmebaasi kasutajanimi',
                'db_username_placeholder' => 'Andmebaasi kasutajanimi',
                'db_password_label' => 'Andmebaasi parool',
                'db_password_placeholder' => 'Andmebaasi parool',

                'app_tabs' => [
                    'more_info' => 'Lisateave',
                    'broadcasting_title' => 'Edastus, vahemälu, seanss ja järjekord',
                    'broadcasting_label' => 'Edastuse draiver',
                    'broadcasting_placeholder' => 'Edastuse draiver',
                    'cache_label' => 'Vahemälu draiver',
                    'cache_placeholder' => 'Vahemälu draiver',
                    'filesystem_driver_label' => 'Failisüsteemi draiver',
                    'filesystem_driver_placeholder' => 'Failisüsteemi draiver',
                    'session_label' => 'Seansi draiver',
                    'session_placeholder' => 'Seansi draiver',
                    'queue_connection_label' => 'Järjekorra ühendus',
                    'queue_connection_placeholder' => 'Järjekorra ühendus',
                    'redis_label' => 'Redis draiver',
                    'redis_host' => 'Redis host',
                    'redis_password' => 'Redis parool',
                    'redis_port' => 'Redis port',

                    'mail_label' => 'E-post',
                    'mail_driver_label' => 'E-posti draiver',
                    'mail_driver_placeholder' => 'E-posti draiver',
                    'mail_host_label' => 'E-posti host',
                    'mail_host_placeholder' => 'E-posti host',
                    'mail_port_label' => 'E-posti port',
                    'mail_port_placeholder' => 'E-posti port',
                    'mail_username_label' => 'E-posti kasutajanimi',
                    'mail_username_placeholder' => 'E-posti kasutajanimi',
                    'mail_password_label' => 'E-posti parool',
                    'mail_password_placeholder' => 'E-posti parool',
                    'mail_encryption_label' => 'E-posti krüpteerimine',
                    'mail_encryption_placeholder' => 'E-posti krüpteerimine',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS juurdepääsuvõtme ID',
                    'aws_access_key_placeholder' => 'AWS juurdepääsuvõtme ID',
                    'aws_secret_key_label' => 'AWS juurdepääsuvõti',
                    'aws_secret_key_placeholder' => 'AWS juurdepääsuvõti',
                    'aws_default_region_label' => 'AWS vaikimisi piirkond',
                    'aws_default_region_placeholder' => 'AWS vaikimisi piirkond',
                    'aws_bucket_label' => 'AWS ämber',
                    'aws_bucket_placeholder' => 'AWS ämber',
                    'aws_endpoint_label' => 'Kasuta AWS-i teekonnastiilis lõpp-punkti',
                    'aws_endpoint_placeholder' => 'Kasuta AWS-i teekonnastiilis lõpp-punkti',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusheri rakenduse ID',
                    'pusher_app_id_palceholder' => 'Pusheri rakenduse ID',
                    'pusher_app_key_label' => 'Pusheri rakenduse võti',
                    'pusher_app_key_palceholder' => 'Pusheri rakenduse võti',
                    'pusher_app_secret_label' => 'Pusheri rakenduse saladusvõti',
                    'pusher_app_secret_palceholder' => 'Pusheri rakenduse saladusvõti',
                ],
                'input_labels' => [
                    'app_name' => 'Määrake rakenduse nimi.',
                    'app_environment' => 'Keskkond, mida soovite rakenduses kasutada.',
                    'app_debug' => 'Määrab, kui palju veateavet kasutajale kuvatakse.',
                    'app_log_level' => 'Määrake rakenduse logitase.',
                    'app_url' => 'Määrake rakenduse soovitud URL.',
                    'db_connection' => 'Rakenduse andmebaasiühendus.',
                    'db_host' => 'Määrake rakenduse andmebaasi host.',
                    'db_port' => 'Määrake rakenduse andmebaasi port.',
                    'db_name' => 'Selle andmebaasi nimi, mida soovite W3mcs-iga kasutada.',
                    'db_user_name' => 'Teie andmebaasi kasutajanimi.',
                    'db_password' => 'Teie andmebaasi parool.',
                ],
                'buttons' => [
                    'setup_database' => 'Seadista andmebaas',
                    'setup_application' => 'Seadista rakendus',
                    'save' => 'Salvesta',
                    'installation' => 'Käivita installimine',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Samm 3 | Keskkonna seaded | Klassikaline redaktor',
            'title' => 'Klassikaline keskkonnaredaktor',
            'save' => 'Salvesta .env',
            'back' => 'Kasuta seadistusviisardit',
            'install' => 'Salvesta ja installi',
        ],
        'success' => '.env-faili seaded on salvestatud.',
        'errors' => '.env-faili ei õnnestunud salvestada. Palun looge see käsitsi.',
    ],

    'install' => 'Installi',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer installiti edukalt ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installimine lõpetatud',
        'templateTitle' => 'Installimine lõpetatud',
        'finished' => 'Rakendus on edukalt installitud.',
        'migration' => 'Migratsiooni ja seemnete konsooliväljund:',
        'console' => 'Rakenduse konsooliväljund:',
        'log' => 'Installimise logikirje:',
        'env' => 'Lõplik .env-fail:',
        'exit' => 'Sisselogimiseks klõpsake siin',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Administraatori seadistamine'
        ],
        'name' => 'Täisnimi',
        'name_description' => 'Sisestage kasutaja täisnimi. Täisnimi võib sisaldada tähti, numbreid ja muid märke.',
        'email' => 'E-post',
        'email_description' => 'Kontrollige enne jätkamist oma e-posti aadressi hoolikalt.',
        'password' => 'Parool',
        'password_description' => 'Oluline: vajate seda parooli sisselogimiseks. Hoidke seda turvalises kohas.',
        'confirm_password' => 'Kinnita parool',
        'confirm_password_description' => 'Kinnitage siin oma parool uuesti.',
        'save' => 'Salvesta ja logi sisse',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Andmebaasiga ühenduse loomiseks klõpsake nupul Käivita installimine.'
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
        'title' => 'Laravel Updater',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Tere tulemast uuendajasse',
            'message' => 'Tere tulemast uuendusviisardisse.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Ülevaade',
            'message' => 'Saadaval on 1 uuendus.|Saadaval on :number uuendust.',
            'install_updates' => 'Installi uuendused',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Lõpetatud',
            'finished' => 'Rakenduse andmebaas on edukalt uuendatud.',
            'exit' => 'Väljumiseks klõpsake siin',
        ],

        'log' => [
            'success_message' => 'Laravel Installer uuendati edukalt ',
        ],
    ],
];

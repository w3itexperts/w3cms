<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versiune',
    'title' => 'Program de instalare Laravel',
    'next' => 'Pasul următor',
    'back' => 'Anterior',
    'finish' => 'Instalează',
    'forms' => [
        'errorTitle' => 'Au apărut următoarele erori:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Bun venit',
        'title'   => 'Program de instalare Laravel',
        'message' => 'Asistent simplu pentru instalare și configurare.',
        'next'    => 'Verifică cerințele',
        'choose_language'    => 'Alege limba',
        'verify_requirements'    => 'Verifică cerințele',
        'setup_environment'    => 'Configurează mediul',
        'configure_site'    => 'Configurează site-ul',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Pasul 1 | Cerințele serverului',
        'title' => 'Cerințele și permisiunile serverului',
        'next'    => 'Următorul',
        'prev'    => 'Anterior',
        'required'    => 'obligatoriu',
        'error'     => 'Verificați cerințele serverului și acordați permisiunile necesare.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Pasul 2 | Permisiuni',
        'title' => 'Permisiuni',
        'next' => 'Configurează mediul',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Configurarea setărilor mediului',
            'title' => 'Configurarea setărilor mediului',
            'wizard-button' => 'Configurare cu asistent',
            'classic-button' => 'Editor de text clasic',
        ],
        'wizard' => [
            'templateTitle' => 'Pasul 3 | Setările mediului | Asistent ghidat',
            'step3_title' => 'Configurarea setărilor mediului',
            'step4_title' => 'Configurarea setărilor bazei de date',
            'step5_title' => 'Configurarea setărilor aplicației',
            'step6_title' => 'Configurarea setărilor administratorului',
            'step7_title' => 'Succes',
            'step3_description' => 'Selectați modul în care doriți să configurați fișierul <code>.env</code> al aplicației.',
            'step4_description' => 'Introduceți mai jos detaliile conexiunii la baza de date. Dacă nu sunteți sigur de acestea, contactați furnizorul de găzduire.',
            'step5_description' => 'Selectați modul în care doriți să configurați fișierul <code>.env</code> al aplicației.',
            'step6_description' => 'Introduceți mai jos detaliile administratorului.',
            'step7_description' => 'W3cms a fost instalat. Vă mulțumim și vă dorim o utilizare plăcută.',
            'tabs' => [
                'environment' => 'Mediu',
                'database' => 'Bază de date',
                'application' => 'Aplicație',
            ],
            'form' => [
                'name_required' => 'Este necesar un nume pentru mediu.',
                'app_name_label' => 'Numele aplicației',
                'app_name_placeholder' => 'Numele aplicației',
                'app_environment_label' => 'Mediul aplicației',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Dezvoltare',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Producție',
                'app_environment_label_other' => 'Altul',
                'app_environment_placeholder_other' => 'Introduceți mediul...',
                'app_debug_label' => 'Depanare aplicație',
                'app_debug_label_true' => 'Adevărat',
                'app_debug_label_false' => 'Fals',
                'app_log_level_label' => 'Nivelul jurnalului aplicației',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL-ul aplicației',
                'app_url_placeholder' => 'URL-ul aplicației',
                'asset_url_label' => 'URL-ul resurselor',
                'asset_url_placeholder' => 'URL-ul resurselor',
                'db_connection_failed' => 'Nu s-a putut realiza conexiunea la baza de date.',
                'db_connection_label' => 'Conexiunea la baza de date',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Gazda bazei de date',
                'db_host_placeholder' => 'Gazda bazei de date',
                'db_port_label' => 'Portul bazei de date',
                'db_port_placeholder' => 'Portul bazei de date',
                'db_name_label' => 'Numele bazei de date',
                'db_name_placeholder' => 'Numele bazei de date',
                'db_username_label' => 'Numele de utilizator al bazei de date',
                'db_username_placeholder' => 'Numele de utilizator al bazei de date',
                'db_password_label' => 'Parola bazei de date',
                'db_password_placeholder' => 'Parola bazei de date',

                'app_tabs' => [
                    'more_info' => 'Mai multe informații',
                    'broadcasting_title' => 'Broadcasting, cache, sesiune și coadă',
                    'broadcasting_label' => 'Driver Broadcasting',
                    'broadcasting_placeholder' => 'Driver Broadcasting',
                    'cache_label' => 'Driver cache',
                    'cache_placeholder' => 'Driver cache',
                    'filesystem_driver_label' => 'Driver sistem de fișiere',
                    'filesystem_driver_placeholder' => 'Driver sistem de fișiere',
                    'session_label' => 'Driver sesiune',
                    'session_placeholder' => 'Driver sesiune',
                    'queue_connection_label' => 'Conexiune coadă',
                    'queue_connection_placeholder' => 'Conexiune coadă',
                    'redis_label' => 'Driver Redis',
                    'redis_host' => 'Gazdă Redis',
                    'redis_password' => 'Parolă Redis',
                    'redis_port' => 'Port Redis',

                    'mail_label' => 'E-mail',
                    'mail_driver_label' => 'Driver e-mail',
                    'mail_driver_placeholder' => 'Driver e-mail',
                    'mail_host_label' => 'Gazdă e-mail',
                    'mail_host_placeholder' => 'Gazdă e-mail',
                    'mail_port_label' => 'Port e-mail',
                    'mail_port_placeholder' => 'Port e-mail',
                    'mail_username_label' => 'Nume utilizator e-mail',
                    'mail_username_placeholder' => 'Nume utilizator e-mail',
                    'mail_password_label' => 'Parolă e-mail',
                    'mail_password_placeholder' => 'Parolă e-mail',
                    'mail_encryption_label' => 'Criptare e-mail',
                    'mail_encryption_placeholder' => 'Criptare e-mail',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID cheie de acces AWS',
                    'aws_access_key_placeholder' => 'ID cheie de acces AWS',
                    'aws_secret_key_label' => 'Cheie de acces AWS',
                    'aws_secret_key_placeholder' => 'Cheie de acces AWS',
                    'aws_default_region_label' => 'Regiune AWS implicită',
                    'aws_default_region_placeholder' => 'Regiune AWS implicită',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Folosește endpoint AWS în stil cale',
                    'aws_endpoint_placeholder' => 'Folosește endpoint AWS în stil cale',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID aplicație Pusher',
                    'pusher_app_id_palceholder' => 'ID aplicație Pusher',
                    'pusher_app_key_label' => 'Cheie aplicație Pusher',
                    'pusher_app_key_palceholder' => 'Cheie aplicație Pusher',
                    'pusher_app_secret_label' => 'Secret aplicație Pusher',
                    'pusher_app_secret_palceholder' => 'Secret aplicație Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Setați numele aplicației.',
                    'app_environment' => 'Mediul pe care doriți să îl utilizați în aplicație.',
                    'app_debug' => 'Definește cât de multe detalii despre eroare sunt afișate utilizatorului.',
                    'app_log_level' => 'Setați nivelul jurnalului aplicației.',
                    'app_url' => 'Setați URL-ul dorit pentru aplicație.',
                    'db_connection' => 'Conexiunea la baza de date a aplicației.',
                    'db_host' => 'Setați gazda bazei de date a aplicației.',
                    'db_port' => 'Setați portul bazei de date a aplicației.',
                    'db_name' => 'Numele bazei de date pe care doriți să o utilizați cu W3mcs.',
                    'db_user_name' => 'Numele de utilizator al bazei de date.',
                    'db_password' => 'Parola bazei de date.',
                ],
                'buttons' => [
                    'setup_database' => 'Configurează baza de date',
                    'setup_application' => 'Configurează aplicația',
                    'save' => 'Salvează',
                    'installation' => 'Rulează instalarea',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Pasul 3 | Setările mediului | Editor clasic',
            'title' => 'Editor clasic pentru mediu',
            'save' => 'Salvează .env',
            'back' => 'Folosește asistentul de configurare',
            'install' => 'Salvează și instalează',
        ],
        'success' => 'Setările fișierului .env au fost salvate.',
        'errors' => 'Nu s-a putut salva fișierul .env. Creați-l manual.',
    ],

    'install' => 'Instalează',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer a fost instalat cu succes la ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Instalare finalizată',
        'templateTitle' => 'Instalare finalizată',
        'finished' => 'Aplicația a fost instalată cu succes.',
        'migration' => 'Ieșirea consolei pentru migrare și seed:',
        'console' => 'Ieșirea consolei aplicației:',
        'log' => 'Înregistrarea din jurnalul instalării:',
        'env' => 'Fișierul .env final:',
        'exit' => 'Faceți clic aici pentru autentificare',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configurare administrator'
        ],
        'name' => 'Nume complet',
        'name_description' => 'Introduceți numele complet al utilizatorului. Numele complet poate conține doar caractere alfanumerice etc.',
        'email' => 'E-mail',
        'email_description' => 'Verificați cu atenție adresa de e-mail înainte de a continua.',
        'password' => 'Parolă',
        'password_description' => 'Important: veți avea nevoie de această parolă pentru autentificare. Păstrați-o într-un loc sigur.',
        'confirm_password' => 'Confirmă parola',
        'confirm_password_description' => 'Confirmați din nou parola aici.',
        'save' => 'Salvează și autentifică-te',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Pentru a comunica acum cu baza de date, faceți clic pe butonul Rulează instalarea.'
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
        'title' => 'Actualizator Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Bun venit în actualizator',
            'message' => 'Bun venit în asistentul de actualizare.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Prezentare generală',
            'message' => 'Există 1 actualizare.|Există :number actualizări.',
            'install_updates' => 'Instalează actualizările',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finalizat',
            'finished' => 'Baza de date a aplicației a fost actualizată cu succes.',
            'exit' => 'Faceți clic aici pentru a ieși',
        ],

        'log' => [
            'success_message' => 'Laravel Installer a fost actualizat cu succes la ',
        ],
    ],
];

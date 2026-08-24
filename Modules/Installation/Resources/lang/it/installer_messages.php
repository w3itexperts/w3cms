<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versione',
    'title' => 'Installatore Laravel',
    'next' => 'Passaggio successivo',
    'back' => 'Precedente',
    'finish' => 'Installa',
    'forms' => [
        'errorTitle' => 'Si sono verificati i seguenti errori:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Benvenuto',
        'title'   => 'Installatore Laravel',
        'message' => 'Procedura guidata semplice per l’installazione e la configurazione.',
        'next'    => 'Verifica requisiti',
        'choose_language'    => 'Scegli lingua',
        'verify_requirements'    => 'Verifica requisiti',
        'setup_environment'    => 'Configura ambiente',
        'configure_site'    => 'Configura sito',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Passaggio 1 | Requisiti del server',
        'title' => 'Requisiti e autorizzazioni del server',
        'next'    => 'Avanti',
        'prev'    => 'Indietro',
        'required'    => 'obbligatorio',
        'error'     => 'Controlla i requisiti del server e assegna le autorizzazioni necessarie.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Passaggio 2 | Autorizzazioni',
        'title' => 'Autorizzazioni',
        'next' => 'Configura ambiente',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Configura impostazioni ambiente',
            'title' => 'Configura impostazioni ambiente',
            'wizard-button' => 'Configurazione guidata',
            'classic-button' => 'Editor di testo classico',
        ],
        'wizard' => [
            'templateTitle' => 'Passaggio 3 | Impostazioni ambiente | Procedura guidata',
            'step3_title' => 'Configura impostazioni ambiente',
            'step4_title' => 'Configura impostazioni database',
            'step5_title' => 'Configura impostazioni applicazione',
            'step6_title' => 'Configura impostazioni amministratore',
            'step7_title' => 'Operazione riuscita',
            'step3_description' => 'Seleziona come desideri configurare il file <code>.env</code> dell’applicazione.',
            'step4_description' => 'Inserisci di seguito i dati di connessione al database. Se non sei sicuro di questi dati, contatta il tuo provider di hosting.',
            'step5_description' => 'Seleziona come desideri configurare il file <code>.env</code> dell’applicazione.',
            'step6_description' => 'Inserisci di seguito i dati dell’amministratore.',
            'step7_description' => 'W3cms è stato installato. Grazie e buon utilizzo.',
            'tabs' => [
                'environment' => 'Ambiente',
                'database' => 'Database',
                'application' => 'Applicazione',
            ],
            'form' => [
                'name_required' => 'È richiesto un nome per l’ambiente.',
                'app_name_label' => 'Nome applicazione',
                'app_name_placeholder' => 'Nome applicazione',
                'app_environment_label' => 'Ambiente applicazione',
                'app_environment_label_local' => 'Locale',
                'app_environment_label_developement' => 'Sviluppo',
                'app_environment_label_qa' => 'Controllo qualità',
                'app_environment_label_production' => 'Produzione',
                'app_environment_label_other' => 'Altro',
                'app_environment_placeholder_other' => 'Inserisci il tuo ambiente...',
                'app_debug_label' => 'Debug applicazione',
                'app_debug_label_true' => 'Attivo',
                'app_debug_label_false' => 'Disattivo',
                'app_log_level_label' => 'Livello di log applicazione',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL applicazione',
                'app_url_placeholder' => 'URL applicazione',
                'asset_url_label' => 'URL risorse',
                'asset_url_placeholder' => 'URL risorse',
                'db_connection_failed' => 'Impossibile connettersi al database.',
                'db_connection_label' => 'Connessione database',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host database',
                'db_host_placeholder' => 'Host database',
                'db_port_label' => 'Porta database',
                'db_port_placeholder' => 'Porta database',
                'db_name_label' => 'Nome database',
                'db_name_placeholder' => 'Nome database',
                'db_username_label' => 'Nome utente database',
                'db_username_placeholder' => 'Nome utente database',
                'db_password_label' => 'Password database',
                'db_password_placeholder' => 'Password database',

                'app_tabs' => [
                    'more_info' => 'Maggiori informazioni',
                    'broadcasting_title' => 'Broadcasting, cache, sessione e coda',
                    'broadcasting_label' => 'Driver Broadcasting',
                    'broadcasting_placeholder' => 'Driver Broadcasting',
                    'cache_label' => 'Driver cache',
                    'cache_placeholder' => 'Driver cache',
                    'filesystem_driver_label' => 'Driver del file system',
                    'filesystem_driver_placeholder' => 'Driver del file system',
                    'session_label' => 'Driver sessione',
                    'session_placeholder' => 'Driver sessione',
                    'queue_connection_label' => 'Connessione coda',
                    'queue_connection_placeholder' => 'Connessione coda',
                    'redis_label' => 'Driver Redis',
                    'redis_host' => 'Host Redis',
                    'redis_password' => 'Password Redis',
                    'redis_port' => 'Porta Redis',

                    'mail_label' => 'Email',
                    'mail_driver_label' => 'Driver email',
                    'mail_driver_placeholder' => 'Driver email',
                    'mail_host_label' => 'Host email',
                    'mail_host_placeholder' => 'Host email',
                    'mail_port_label' => 'Porta email',
                    'mail_port_placeholder' => 'Porta email',
                    'mail_username_label' => 'Nome utente email',
                    'mail_username_placeholder' => 'Nome utente email',
                    'mail_password_label' => 'Password email',
                    'mail_password_placeholder' => 'Password email',
                    'mail_encryption_label' => 'Crittografia email',
                    'mail_encryption_placeholder' => 'Crittografia email',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID chiave di accesso AWS',
                    'aws_access_key_placeholder' => 'ID chiave di accesso AWS',
                    'aws_secret_key_label' => 'Chiave di accesso AWS',
                    'aws_secret_key_placeholder' => 'Chiave di accesso AWS',
                    'aws_default_region_label' => 'Regione AWS predefinita',
                    'aws_default_region_placeholder' => 'Regione AWS predefinita',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Usa endpoint AWS in stile percorso',
                    'aws_endpoint_placeholder' => 'Usa endpoint AWS in stile percorso',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID app Pusher',
                    'pusher_app_id_palceholder' => 'ID app Pusher',
                    'pusher_app_key_label' => 'Chiave app Pusher',
                    'pusher_app_key_palceholder' => 'Chiave app Pusher',
                    'pusher_app_secret_label' => 'Segreto app Pusher',
                    'pusher_app_secret_palceholder' => 'Segreto app Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Imposta il nome dell’applicazione.',
                    'app_environment' => 'L’ambiente che desideri utilizzare nell’applicazione.',
                    'app_debug' => 'Definisce quanti dettagli dell’errore vengono visualizzati all’utente.',
                    'app_log_level' => 'Imposta il livello di log dell’applicazione.',
                    'app_url' => 'Imposta l’URL desiderato dell’applicazione.',
                    'db_connection' => 'La connessione al database dell’applicazione.',
                    'db_host' => 'Imposta l’host del database dell’applicazione.',
                    'db_port' => 'Imposta la porta del database dell’applicazione.',
                    'db_name' => 'Il nome del database che desideri utilizzare con W3mcs.',
                    'db_user_name' => 'Il nome utente del tuo database.',
                    'db_password' => 'La password del tuo database.',
                ],
                'buttons' => [
                    'setup_database' => 'Configura database',
                    'setup_application' => 'Configura applicazione',
                    'save' => 'Salva',
                    'installation' => 'Esegui installazione',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Passaggio 3 | Impostazioni ambiente | Editor classico',
            'title' => 'Editor ambiente classico',
            'save' => 'Salva .env',
            'back' => 'Usa procedura guidata',
            'install' => 'Salva e installa',
        ],
        'success' => 'Le impostazioni del file .env sono state salvate correttamente.',
        'errors' => 'Impossibile salvare il file .env. Crealo manualmente.',
    ],

    'install' => 'Installa',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer installato correttamente il ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installazione completata',
        'templateTitle' => 'Installazione completata',
        'finished' => 'L’applicazione è stata installata correttamente.',
        'migration' => 'Output della console Migration & Seed:',
        'console' => 'Output della console dell’applicazione:',
        'log' => 'Voce del registro di installazione:',
        'env' => 'File .env finale:',
        'exit' => 'Clicca qui per accedere',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configurazione amministratore'
        ],
        'name' => 'Nome completo',
        'name_description' => 'Inserisci il nome completo dell’utente. Il nome completo può contenere caratteri alfanumerici ecc.',
        'email' => 'Email',
        'email_description' => 'Controlla attentamente il tuo indirizzo email prima di continuare.',
        'password' => 'Password',
        'password_description' => 'Importante: avrai bisogno di questa password per accedere. Conservala in un luogo sicuro.',
        'confirm_password' => 'Conferma password',
        'confirm_password_description' => 'Conferma nuovamente la password qui.',
        'save' => 'Salva e accedi',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Per comunicare ora con il database, fai clic sul pulsante Esegui installazione.'
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
        'title' => 'Aggiornamento Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Benvenuto nell’aggiornamento',
            'message' => 'Benvenuto nella procedura guidata di aggiornamento.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Panoramica',
            'message' => 'È disponibile 1 aggiornamento.|Sono disponibili :number aggiornamenti.',
            'install_updates' => 'Installa aggiornamenti',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Completato',
            'finished' => 'Il database dell’applicazione è stato aggiornato correttamente.',
            'exit' => 'Clicca qui per uscire',
        ],

        'log' => [
            'success_message' => 'Laravel Installer aggiornato correttamente il ',
        ],
    ],
];

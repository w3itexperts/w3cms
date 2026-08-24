<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versie',
    'title' => 'Laravel-installatieprogramma',
    'next' => 'Volgende stap',
    'back' => 'Vorige',
    'finish' => 'Installeren',
    'forms' => [
        'errorTitle' => 'De volgende fouten zijn opgetreden:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Welkom',
        'title'   => 'Laravel-installatieprogramma',
        'message' => 'Eenvoudige installatie- en configuratiewizard.',
        'next'    => 'Vereisten controleren',
        'choose_language'    => 'Taal kiezen',
        'verify_requirements'    => 'Vereisten verifiëren',
        'setup_environment'    => 'Omgeving instellen',
        'configure_site'    => 'Website configureren',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Stap 1 | Serververeisten',
        'title' => 'Serververeisten en machtigingen',
        'next'    => 'Volgende',
        'prev'    => 'Vorige',
        'required'    => 'vereist',
        'error'     => 'Controleer de serververeisten en geef de benodigde machtigingen.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Stap 2 | Machtigingen',
        'title' => 'Machtigingen',
        'next' => 'Omgeving configureren',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Omgevingsinstellingen instellen',
            'title' => 'Omgevingsinstellingen instellen',
            'wizard-button' => 'Instellen met wizard',
            'classic-button' => 'Klassieke teksteditor',
        ],
        'wizard' => [
            'templateTitle' => 'Stap 3 | Omgevingsinstellingen | Begeleide wizard',
            'step3_title' => 'Omgevingsinstellingen instellen',
            'step4_title' => 'Database-instellingen instellen',
            'step5_title' => 'Applicatie-instellingen instellen',
            'step6_title' => 'Beheerdersinstellingen instellen',
            'step7_title' => 'Geslaagd',
            'step3_description' => 'Selecteer hoe u het <code>.env</code>-bestand van de applicatie wilt configureren.',
            'step4_description' => 'Voer hieronder uw databaseverbindingsgegevens in. Als u hier niet zeker van bent, neem dan contact op met uw hostingprovider.',
            'step5_description' => 'Selecteer hoe u het <code>.env</code>-bestand van de applicatie wilt configureren.',
            'step6_description' => 'Voer hieronder de gegevens van de beheerder in.',
            'step7_description' => 'W3cms is geïnstalleerd. Bedankt en veel plezier ermee.',
            'tabs' => [
                'environment' => 'Omgeving',
                'database' => 'Database',
                'application' => 'Applicatie',
            ],
            'form' => [
                'name_required' => 'Een omgevingsnaam is vereist.',
                'app_name_label' => 'Applicatienaam',
                'app_name_placeholder' => 'Applicatienaam',
                'app_environment_label' => 'Applicatieomgeving',
                'app_environment_label_local' => 'Lokaal',
                'app_environment_label_developement' => 'Ontwikkeling',
                'app_environment_label_qa' => 'Kwaliteitscontrole',
                'app_environment_label_production' => 'Productie',
                'app_environment_label_other' => 'Overig',
                'app_environment_placeholder_other' => 'Voer uw omgeving in...',
                'app_debug_label' => 'Applicatie-debug',
                'app_debug_label_true' => 'Waar',
                'app_debug_label_false' => 'Onwaar',
                'app_log_level_label' => 'Applicatielogniveau',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Applicatie-URL',
                'app_url_placeholder' => 'Applicatie-URL',
                'asset_url_label' => 'Asset-URL',
                'asset_url_placeholder' => 'Asset-URL',
                'db_connection_failed' => 'Kan geen verbinding maken met de database.',
                'db_connection_label' => 'Databaseverbinding',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Databasehost',
                'db_host_placeholder' => 'Databasehost',
                'db_port_label' => 'Databasepoort',
                'db_port_placeholder' => 'Databasepoort',
                'db_name_label' => 'Databasenaam',
                'db_name_placeholder' => 'Databasenaam',
                'db_username_label' => 'Databasegebruikersnaam',
                'db_username_placeholder' => 'Databasegebruikersnaam',
                'db_password_label' => 'Databasewachtwoord',
                'db_password_placeholder' => 'Databasewachtwoord',

                'app_tabs' => [
                    'more_info' => 'Meer informatie',
                    'broadcasting_title' => 'Broadcasting, caching, sessie en wachtrij',
                    'broadcasting_label' => 'Broadcast-driver',
                    'broadcasting_placeholder' => 'Broadcast-driver',
                    'cache_label' => 'Cache-driver',
                    'cache_placeholder' => 'Cache-driver',
                    'filesystem_driver_label' => 'Bestandssysteemdriver',
                    'filesystem_driver_placeholder' => 'Bestandssysteemdriver',
                    'session_label' => 'Sessiedriver',
                    'session_placeholder' => 'Sessiedriver',
                    'queue_connection_label' => 'Wachtrijverbinding',
                    'queue_connection_placeholder' => 'Wachtrijverbinding',
                    'redis_label' => 'Redis-driver',
                    'redis_host' => 'Redis-host',
                    'redis_password' => 'Redis-wachtwoord',
                    'redis_port' => 'Redis-poort',

                    'mail_label' => 'E-mail',
                    'mail_driver_label' => 'E-maildriver',
                    'mail_driver_placeholder' => 'E-maildriver',
                    'mail_host_label' => 'E-mailhost',
                    'mail_host_placeholder' => 'E-mailhost',
                    'mail_port_label' => 'E-mailpoort',
                    'mail_port_placeholder' => 'E-mailpoort',
                    'mail_username_label' => 'E-mailgebruikersnaam',
                    'mail_username_placeholder' => 'E-mailgebruikersnaam',
                    'mail_password_label' => 'E-mailwachtwoord',
                    'mail_password_placeholder' => 'E-mailwachtwoord',
                    'mail_encryption_label' => 'E-mailversleuteling',
                    'mail_encryption_placeholder' => 'E-mailversleuteling',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS Access Key ID',
                    'aws_access_key_placeholder' => 'AWS Access Key ID',
                    'aws_secret_key_label' => 'AWS Access Key',
                    'aws_secret_key_placeholder' => 'AWS Access Key',
                    'aws_default_region_label' => 'Standaard AWS-regio',
                    'aws_default_region_placeholder' => 'Standaard AWS-regio',
                    'aws_bucket_label' => 'AWS-bucket',
                    'aws_bucket_placeholder' => 'AWS-bucket',
                    'aws_endpoint_label' => 'AWS endpoint in padstijl gebruiken',
                    'aws_endpoint_placeholder' => 'AWS endpoint in padstijl gebruiken',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher-app-ID',
                    'pusher_app_id_palceholder' => 'Pusher-app-ID',
                    'pusher_app_key_label' => 'Pusher-appsleutel',
                    'pusher_app_key_palceholder' => 'Pusher-appsleutel',
                    'pusher_app_secret_label' => 'Pusher-appgeheim',
                    'pusher_app_secret_palceholder' => 'Pusher-appgeheim',
                ],
                'input_labels' => [
                    'app_name' => 'Stel de naam van de applicatie in.',
                    'app_environment' => 'De omgeving die u in de applicatie wilt gebruiken.',
                    'app_debug' => 'Bepaalt hoeveel foutdetails daadwerkelijk aan de gebruiker worden weergegeven.',
                    'app_log_level' => 'Stel het logniveau van de applicatie in.',
                    'app_url' => 'Stel de gewenste URL van de applicatie in.',
                    'db_connection' => 'De databaseverbinding van de applicatie.',
                    'db_host' => 'Stel de databasehost van de applicatie in.',
                    'db_port' => 'Stel de databasepoort van de applicatie in.',
                    'db_name' => 'De naam van de database die u met W3mcs wilt gebruiken.',
                    'db_user_name' => 'Uw databasegebruikersnaam.',
                    'db_password' => 'Uw databasewachtwoord.',
                ],
                'buttons' => [
                    'setup_database' => 'Database instellen',
                    'setup_application' => 'Applicatie instellen',
                    'save' => 'Opslaan',
                    'installation' => 'Installatie uitvoeren',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Stap 3 | Omgevingsinstellingen | Klassieke editor',
            'title' => 'Klassieke omgevingseditor',
            'save' => '.env opslaan',
            'back' => 'Wizard gebruiken',
            'install' => 'Opslaan en installeren',
        ],
        'success' => 'De instellingen van het .env-bestand zijn opgeslagen.',
        'errors' => 'Kan het .env-bestand niet opslaan. Maak het handmatig aan.',
    ],

    'install' => 'Installeren',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer succesvol GEÏNSTALLEERD op ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installatie voltooid',
        'templateTitle' => 'Installatie voltooid',
        'finished' => 'De applicatie is succesvol geïnstalleerd.',
        'migration' => 'Console-uitvoer van migratie en seed:',
        'console' => 'Console-uitvoer van de applicatie:',
        'log' => 'Installatielogboekvermelding:',
        'env' => 'Definitief .env-bestand:',
        'exit' => 'Klik hier om in te loggen',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Beheerder instellen'
        ],
        'name' => 'Volledige naam',
        'name_description' => 'Voer de volledige naam van de gebruiker in. De volledige naam kan alfanumerieke tekens enz. bevatten.',
        'email' => 'E-mail',
        'email_description' => 'Controleer uw e-mailadres zorgvuldig voordat u doorgaat.',
        'password' => 'Wachtwoord',
        'password_description' => 'Belangrijk: u hebt dit wachtwoord nodig om in te loggen. Bewaar het op een veilige plaats.',
        'confirm_password' => 'Wachtwoord bevestigen',
        'confirm_password_description' => 'Bevestig hier uw wachtwoord opnieuw.',
        'save' => 'Opslaan en inloggen',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Klik op de knop Installatie uitvoeren om nu verbinding te maken met uw database.'
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
            'title'   => 'Welkom bij de Updater',
            'message' => 'Welkom bij de updatewizard.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Overzicht',
            'message' => 'Er is 1 update.|Er zijn :number updates.',
            'install_updates' => 'Updates installeren',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Voltooid',
            'finished' => 'De database van de applicatie is succesvol bijgewerkt.',
            'exit' => 'Klik hier om af te sluiten',
        ],

        'log' => [
            'success_message' => 'Laravel Installer succesvol BIJGEWERKT op ',
        ],
    ],
];

<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'Version',
    'title' => 'Laravel Installer',
    'next' => 'Nächster Schritt',
    'back' => 'Zurück',
    'finish' => 'Installieren',
    'forms' => [
        'errorTitle' => 'Die folgenden Fehler sind aufgetreten:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Willkommen',
        'title'   => 'Laravel Installer',
        'message' => 'Einfacher Installations- und Einrichtungsassistent.',
        'next'    => 'Anforderungen prüfen',
        'choose_language'    => 'Sprache auswählen',
        'verify_requirements'    => 'Anforderungen überprüfen',
        'setup_environment'    => 'Umgebung einrichten',
        'configure_site'    => 'Website konfigurieren',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Schritt 1 | Serveranforderungen',
        'title' => 'Serveranforderungen & Berechtigungen',
        'next'    => 'Weiter',
        'prev'    => 'Zurück',
        'required'    => 'erforderlich',
        'error'     => 'Bitte überprüfen Sie die Serveranforderungen und erteilen Sie die erforderlichen Berechtigungen.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Schritt 2 | Berechtigungen',
        'title' => 'Berechtigungen',
        'next' => 'Umgebung konfigurieren',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Umgebungseinstellungen einrichten',
            'title' => 'Umgebungseinstellungen einrichten',
            'wizard-button' => 'Assistent zur Einrichtung',
            'classic-button' => 'Klassischer Texteditor',
        ],
        'wizard' => [
            'templateTitle' => 'Schritt 3 | Umgebungseinstellungen | Einrichtungsassistent',
            'step3_title' => 'Umgebungseinstellungen einrichten',
            'step4_title' => 'Datenbankeinstellungen einrichten',
            'step5_title' => 'Anwendungseinstellungen einrichten',
            'step6_title' => 'Administratoreinstellungen einrichten',
            'step7_title' => 'Erfolg',
            'step3_description' => 'Bitte wählen Sie aus, wie Sie die <code>.env</code>-Datei der Anwendung konfigurieren möchten.',
            'step4_description' => 'Geben Sie unten Ihre Datenbankverbindungsdaten ein. Wenn Sie sich nicht sicher sind, wenden Sie sich an Ihren Hosting-Anbieter.',
            'step5_description' => 'Bitte wählen Sie aus, wie Sie die <code>.env</code>-Datei der Anwendung konfigurieren möchten.',
            'step6_description' => 'Geben Sie unten die Daten des Administrators ein.',
            'step7_description' => 'W3cms wurde installiert. Vielen Dank und viel Freude damit.',
            'tabs' => [
                'environment' => 'Umgebung',
                'database' => 'Datenbank',
                'application' => 'Anwendung',
            ],
            'form' => [
                'name_required' => 'Ein Umgebungsname ist erforderlich.',
                'app_name_label' => 'Anwendungsname',
                'app_name_placeholder' => 'Anwendungsname',
                'app_environment_label' => 'Anwendungsumgebung',
                'app_environment_label_local' => 'Lokal',
                'app_environment_label_developement' => 'Entwicklung',
                'app_environment_label_qa' => 'Qualitätssicherung',
                'app_environment_label_production' => 'Produktion',
                'app_environment_label_other' => 'Andere',
                'app_environment_placeholder_other' => 'Geben Sie Ihre Umgebung ein...',
                'app_debug_label' => 'Anwendungs-Debugging',
                'app_debug_label_true' => 'Aktiviert',
                'app_debug_label_false' => 'Deaktiviert',
                'app_log_level_label' => 'Anwendungsprotokoll-Level',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Anwendungs-URL',
                'app_url_placeholder' => 'Anwendungs-URL',
                'asset_url_label' => 'Asset-URL',
                'asset_url_placeholder' => 'Asset-URL',
                'db_connection_failed' => 'Es konnte keine Verbindung zur Datenbank hergestellt werden.',
                'db_connection_label' => 'Datenbankverbindung',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Datenbank-Host',
                'db_host_placeholder' => 'Datenbank-Host',
                'db_port_label' => 'Datenbank-Port',
                'db_port_placeholder' => 'Datenbank-Port',
                'db_name_label' => 'Datenbankname',
                'db_name_placeholder' => 'Datenbankname',
                'db_username_label' => 'Datenbank-Benutzername',
                'db_username_placeholder' => 'Datenbank-Benutzername',
                'db_password_label' => 'Datenbankpasswort',
                'db_password_placeholder' => 'Datenbankpasswort',

                'app_tabs' => [
                    'more_info' => 'Weitere Informationen',
                    'broadcasting_title' => 'Broadcasting, Cache, Sitzung & Warteschlange',
                    'broadcasting_label' => 'Broadcast-Treiber',
                    'broadcasting_placeholder' => 'Broadcast-Treiber',
                    'cache_label' => 'Cache-Treiber',
                    'cache_placeholder' => 'Cache-Treiber',
                    'filesystem_driver_label' => 'Dateisystem-Treiber',
                    'filesystem_driver_placeholder' => 'Dateisystem-Treiber',
                    'session_label' => 'Sitzungstreiber',
                    'session_placeholder' => 'Sitzungstreiber',
                    'queue_connection_label' => 'Warteschlangenverbindung',
                    'queue_connection_placeholder' => 'Warteschlangenverbindung',
                    'redis_label' => 'Redis-Treiber',
                    'redis_host' => 'Redis-Host',
                    'redis_password' => 'Redis-Passwort',
                    'redis_port' => 'Redis-Port',

                    'mail_label' => 'E-Mail',
                    'mail_driver_label' => 'E-Mail-Treiber',
                    'mail_driver_placeholder' => 'E-Mail-Treiber',
                    'mail_host_label' => 'E-Mail-Host',
                    'mail_host_placeholder' => 'E-Mail-Host',
                    'mail_port_label' => 'E-Mail-Port',
                    'mail_port_placeholder' => 'E-Mail-Port',
                    'mail_username_label' => 'E-Mail-Benutzername',
                    'mail_username_placeholder' => 'E-Mail-Benutzername',
                    'mail_password_label' => 'E-Mail-Passwort',
                    'mail_password_placeholder' => 'E-Mail-Passwort',
                    'mail_encryption_label' => 'E-Mail-Verschlüsselung',
                    'mail_encryption_placeholder' => 'E-Mail-Verschlüsselung',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS Access Key ID',
                    'aws_access_key_placeholder' => 'AWS Access Key ID',
                    'aws_secret_key_label' => 'AWS Access Key',
                    'aws_secret_key_placeholder' => 'AWS Access Key',
                    'aws_default_region_label' => 'AWS-Standardregion',
                    'aws_default_region_placeholder' => 'AWS-Standardregion',
                    'aws_bucket_label' => 'AWS-Bucket',
                    'aws_bucket_placeholder' => 'AWS-Bucket',
                    'aws_endpoint_label' => 'AWS-Pfadstil-Endpunkt verwenden',
                    'aws_endpoint_placeholder' => 'AWS-Pfadstil-Endpunkt verwenden',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App-ID',
                    'pusher_app_id_palceholder' => 'Pusher App-ID',
                    'pusher_app_key_label' => 'Pusher App-Schlüssel',
                    'pusher_app_key_palceholder' => 'Pusher App-Schlüssel',
                    'pusher_app_secret_label' => 'Pusher App-Geheimnis',
                    'pusher_app_secret_palceholder' => 'Pusher App-Geheimnis',
                ],
                'input_labels' => [
                    'app_name' => 'Legen Sie den Namen der Anwendung fest.',
                    'app_environment' => 'Die Umgebung, die Sie für die Anwendung verwenden möchten.',
                    'app_debug' => 'Legt fest, wie viele Fehlerdetails dem Benutzer angezeigt werden.',
                    'app_log_level' => 'Legen Sie das Protokoll-Level der Anwendung fest.',
                    'app_url' => 'Legen Sie die gewünschte URL der Anwendung fest.',
                    'db_connection' => 'Die Datenbankverbindung der Anwendung.',
                    'db_host' => 'Legen Sie den Datenbank-Host der Anwendung fest.',
                    'db_port' => 'Legen Sie den Datenbank-Port der Anwendung fest.',
                    'db_name' => 'Der Name der Datenbank, die Sie mit W3mcs verwenden möchten.',
                    'db_user_name' => 'Ihr Datenbank-Benutzername.',
                    'db_password' => 'Ihr Datenbankpasswort.',
                ],
                'buttons' => [
                    'setup_database' => 'Datenbank einrichten',
                    'setup_application' => 'Anwendung einrichten',
                    'save' => 'Speichern',
                    'installation' => 'Installation ausführen',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Schritt 3 | Umgebungseinstellungen | Klassischer Editor',
            'title' => 'Klassischer Umgebungseditor',
            'save' => '.env speichern',
            'back' => 'Assistent verwenden',
            'install' => 'Speichern und installieren',
        ],
        'success' => 'Die Einstellungen der .env-Datei wurden gespeichert.',
        'errors' => 'Die .env-Datei konnte nicht gespeichert werden. Bitte erstellen Sie sie manuell.',
    ],

    'install' => 'Installieren',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer wurde erfolgreich installiert am ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installation abgeschlossen',
        'templateTitle' => 'Installation abgeschlossen',
        'finished' => 'Die Anwendung wurde erfolgreich installiert.',
        'migration' => 'Konsolenausgabe von Migration & Seed:',
        'console' => 'Konsolenausgabe der Anwendung:',
        'log' => 'Eintrag im Installationsprotokoll:',
        'env' => 'Finale .env-Datei:',
        'exit' => 'Klicken Sie hier, um sich anzumelden',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Administratoreinrichtung'
        ],
        'name' => 'Vollständiger Name',
        'name_description' => 'Geben Sie den vollständigen Namen des Benutzers ein. Der vollständige Name kann alphanumerische Zeichen usw. enthalten.',
        'email' => 'E-Mail',
        'email_description' => 'Überprüfen Sie Ihre E-Mail-Adresse sorgfältig, bevor Sie fortfahren.',
        'password' => 'Passwort',
        'password_description' => 'Wichtig: Sie benötigen dieses Passwort, um sich anzumelden. Bewahren Sie es an einem sicheren Ort auf.',
        'confirm_password' => 'Passwort bestätigen',
        'confirm_password_description' => 'Bestätigen Sie hier Ihr Passwort erneut.',
        'save' => 'Speichern und anmelden',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Um nun eine Verbindung mit Ihrer Datenbank herzustellen, klicken Sie auf die Schaltfläche „Installation ausführen“.'
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
            'title'   => 'Willkommen beim Updater',
            'message' => 'Willkommen beim Aktualisierungsassistenten.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Übersicht',
            'message' => 'Es gibt 1 Update.|Es gibt :number Updates.',
            'install_updates' => 'Updates installieren',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Abgeschlossen',
            'finished' => 'Die Datenbank der Anwendung wurde erfolgreich aktualisiert.',
            'exit' => 'Klicken Sie hier, um zu beenden',
        ],

        'log' => [
            'success_message' => 'Laravel Installer wurde erfolgreich aktualisiert am ',
        ],
    ],
];

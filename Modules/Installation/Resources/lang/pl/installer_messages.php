<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'wersja',
    'title' => 'Instalator Laravel',
    'next' => 'Następny krok',
    'back' => 'Poprzedni',
    'finish' => 'Zainstaluj',
    'forms' => [
        'errorTitle' => 'Wystąpiły następujące błędy:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Witamy',
        'title'   => 'Instalator Laravel',
        'message' => 'Łatwy kreator instalacji i konfiguracji.',
        'next'    => 'Sprawdź wymagania',
        'choose_language'    => 'Wybierz język',
        'verify_requirements'    => 'Sprawdź wymagania',
        'setup_environment'    => 'Skonfiguruj środowisko',
        'configure_site'    => 'Skonfiguruj witrynę',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Krok 1 | Wymagania serwera',
        'title' => 'Wymagania i uprawnienia serwera',
        'next'    => 'Dalej',
        'prev'    => 'Wstecz',
        'required'    => 'wymagane',
        'error'     => 'Sprawdź wymagania serwera i nadaj wymagane uprawnienia.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Krok 2 | Uprawnienia',
        'title' => 'Uprawnienia',
        'next' => 'Skonfiguruj środowisko',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Konfiguracja ustawień środowiska',
            'title' => 'Konfiguracja ustawień środowiska',
            'wizard-button' => 'Konfiguracja za pomocą kreatora',
            'classic-button' => 'Klasyczny edytor tekstu',
        ],
        'wizard' => [
            'templateTitle' => 'Krok 3 | Ustawienia środowiska | Kreator konfiguracji',
            'step3_title' => 'Konfiguracja ustawień środowiska',
            'step4_title' => 'Konfiguracja ustawień bazy danych',
            'step5_title' => 'Konfiguracja ustawień aplikacji',
            'step6_title' => 'Konfiguracja ustawień administratora',
            'step7_title' => 'Sukces',
            'step3_description' => 'Wybierz sposób konfiguracji pliku <code>.env</code> aplikacji.',
            'step4_description' => 'Poniżej wprowadź dane połączenia z bazą danych. Jeśli nie masz pewności, skontaktuj się z dostawcą hostingu.',
            'step5_description' => 'Wybierz sposób konfiguracji pliku <code>.env</code> aplikacji.',
            'step6_description' => 'Poniżej wprowadź dane administratora.',
            'step7_description' => 'W3cms zostało zainstalowane. Dziękujemy i życzymy miłego korzystania.',
            'tabs' => [
                'environment' => 'Środowisko',
                'database' => 'Baza danych',
                'application' => 'Aplikacja',
            ],
            'form' => [
                'name_required' => 'Nazwa środowiska jest wymagana.',
                'app_name_label' => 'Nazwa aplikacji',
                'app_name_placeholder' => 'Nazwa aplikacji',
                'app_environment_label' => 'Środowisko aplikacji',
                'app_environment_label_local' => 'Lokalne',
                'app_environment_label_developement' => 'Programistyczne',
                'app_environment_label_qa' => 'Kontrola jakości',
                'app_environment_label_production' => 'Produkcyjne',
                'app_environment_label_other' => 'Inne',
                'app_environment_placeholder_other' => 'Wprowadź swoje środowisko...',
                'app_debug_label' => 'Debugowanie aplikacji',
                'app_debug_label_true' => 'Włączone',
                'app_debug_label_false' => 'Wyłączone',
                'app_log_level_label' => 'Poziom logowania aplikacji',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Adres URL aplikacji',
                'app_url_placeholder' => 'Adres URL aplikacji',
                'asset_url_label' => 'Adres URL zasobów',
                'asset_url_placeholder' => 'Adres URL zasobów',
                'db_connection_failed' => 'Nie można połączyć się z bazą danych.',
                'db_connection_label' => 'Połączenie z bazą danych',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host bazy danych',
                'db_host_placeholder' => 'Host bazy danych',
                'db_port_label' => 'Port bazy danych',
                'db_port_placeholder' => 'Port bazy danych',
                'db_name_label' => 'Nazwa bazy danych',
                'db_name_placeholder' => 'Nazwa bazy danych',
                'db_username_label' => 'Nazwa użytkownika bazy danych',
                'db_username_placeholder' => 'Nazwa użytkownika bazy danych',
                'db_password_label' => 'Hasło bazy danych',
                'db_password_placeholder' => 'Hasło bazy danych',

                'app_tabs' => [
                    'more_info' => 'Więcej informacji',
                    'broadcasting_title' => 'Broadcasting, pamięć podręczna, sesja i kolejka',
                    'broadcasting_label' => 'Sterownik Broadcast',
                    'broadcasting_placeholder' => 'Sterownik Broadcast',
                    'cache_label' => 'Sterownik pamięci podręcznej',
                    'cache_placeholder' => 'Sterownik pamięci podręcznej',
                    'filesystem_driver_label' => 'Sterownik systemu plików',
                    'filesystem_driver_placeholder' => 'Sterownik systemu plików',
                    'session_label' => 'Sterownik sesji',
                    'session_placeholder' => 'Sterownik sesji',
                    'queue_connection_label' => 'Połączenie kolejki',
                    'queue_connection_placeholder' => 'Połączenie kolejki',
                    'redis_label' => 'Sterownik Redis',
                    'redis_host' => 'Host Redis',
                    'redis_password' => 'Hasło Redis',
                    'redis_port' => 'Port Redis',

                    'mail_label' => 'Poczta',
                    'mail_driver_label' => 'Sterownik poczty',
                    'mail_driver_placeholder' => 'Sterownik poczty',
                    'mail_host_label' => 'Host poczty',
                    'mail_host_placeholder' => 'Host poczty',
                    'mail_port_label' => 'Port poczty',
                    'mail_port_placeholder' => 'Port poczty',
                    'mail_username_label' => 'Nazwa użytkownika poczty',
                    'mail_username_placeholder' => 'Nazwa użytkownika poczty',
                    'mail_password_label' => 'Hasło poczty',
                    'mail_password_placeholder' => 'Hasło poczty',
                    'mail_encryption_label' => 'Szyfrowanie poczty',
                    'mail_encryption_placeholder' => 'Szyfrowanie poczty',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'Identyfikator klucza dostępu AWS',
                    'aws_access_key_placeholder' => 'Identyfikator klucza dostępu AWS',
                    'aws_secret_key_label' => 'Klucz dostępu AWS',
                    'aws_secret_key_placeholder' => 'Klucz dostępu AWS',
                    'aws_default_region_label' => 'Domyślny region AWS',
                    'aws_default_region_placeholder' => 'Domyślny region AWS',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Użyj endpointu AWS w stylu ścieżki',
                    'aws_endpoint_placeholder' => 'Użyj endpointu AWS w stylu ścieżki',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Identyfikator aplikacji Pusher',
                    'pusher_app_id_palceholder' => 'Identyfikator aplikacji Pusher',
                    'pusher_app_key_label' => 'Klucz aplikacji Pusher',
                    'pusher_app_key_palceholder' => 'Klucz aplikacji Pusher',
                    'pusher_app_secret_label' => 'Sekret aplikacji Pusher',
                    'pusher_app_secret_palceholder' => 'Sekret aplikacji Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Ustaw nazwę aplikacji.',
                    'app_environment' => 'Środowisko, którego chcesz używać w aplikacji.',
                    'app_debug' => 'Określa, ile szczegółów błędów jest wyświetlanych użytkownikowi.',
                    'app_log_level' => 'Ustaw poziom logowania aplikacji.',
                    'app_url' => 'Ustaw adres URL aplikacji.',
                    'db_connection' => 'Połączenie aplikacji z bazą danych.',
                    'db_host' => 'Ustaw host bazy danych aplikacji.',
                    'db_port' => 'Ustaw port bazy danych aplikacji.',
                    'db_name' => 'Nazwa bazy danych, której chcesz używać z W3mcs.',
                    'db_user_name' => 'Nazwa użytkownika bazy danych.',
                    'db_password' => 'Hasło do bazy danych.',
                ],
                'buttons' => [
                    'setup_database' => 'Skonfiguruj bazę danych',
                    'setup_application' => 'Skonfiguruj aplikację',
                    'save' => 'Zapisz',
                    'installation' => 'Uruchom instalację',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Krok 3 | Ustawienia środowiska | Klasyczny edytor',
            'title' => 'Klasyczny edytor środowiska',
            'save' => 'Zapisz .env',
            'back' => 'Użyj kreatora konfiguracji',
            'install' => 'Zapisz i zainstaluj',
        ],
        'success' => 'Ustawienia pliku .env zostały zapisane.',
        'errors' => 'Nie można zapisać pliku .env. Utwórz go ręcznie.',
    ],

    'install' => 'Zainstaluj',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer został pomyślnie ZAINSTALOWANY dnia ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Instalacja zakończona',
        'templateTitle' => 'Instalacja zakończona',
        'finished' => 'Aplikacja została pomyślnie zainstalowana.',
        'migration' => 'Dane wyjściowe konsoli migracji i seedowania:',
        'console' => 'Dane wyjściowe konsoli aplikacji:',
        'log' => 'Wpis w dzienniku instalacji:',
        'env' => 'Końcowy plik .env:',
        'exit' => 'Kliknij tutaj, aby się zalogować',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Konfiguracja administratora'
        ],
        'name' => 'Imię i nazwisko',
        'name_description' => 'Wprowadź imię i nazwisko użytkownika. Imię i nazwisko może zawierać znaki alfanumeryczne itp.',
        'email' => 'E-mail',
        'email_description' => 'Dokładnie sprawdź swój adres e-mail przed kontynuowaniem.',
        'password' => 'Hasło',
        'password_description' => 'Ważne: będziesz potrzebować tego hasła do logowania. Przechowuj je w bezpiecznym miejscu.',
        'confirm_password' => 'Potwierdź hasło',
        'confirm_password_description' => 'Potwierdź tutaj ponownie swoje hasło.',
        'save' => 'Zapisz i zaloguj się',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Aby połączyć się teraz z bazą danych, kliknij przycisk Uruchom instalację.'
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
        'title' => 'Aktualizator Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Witamy w aktualizatorze',
            'message' => 'Witamy w kreatorze aktualizacji.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Przegląd',
            'message' => 'Dostępna jest 1 aktualizacja.|Dostępnych jest :number aktualizacji.',
            'install_updates' => 'Zainstaluj aktualizacje',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Zakończono',
            'finished' => 'Baza danych aplikacji została pomyślnie zaktualizowana.',
            'exit' => 'Kliknij tutaj, aby wyjść',
        ],

        'log' => [
            'success_message' => 'Laravel Installer został pomyślnie ZAKTUALIZOWANY dnia ',
        ],
    ],
];

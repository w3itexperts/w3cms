<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'sürüm',
    'title' => 'Laravel Yükleyici',
    'next' => 'Sonraki Adım',
    'back' => 'Önceki',
    'finish' => 'Yükle',
    'forms' => [
        'errorTitle' => 'Aşağıdaki hatalar oluştu:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Hoş Geldiniz',
        'title'   => 'Laravel Yükleyici',
        'message' => 'Kolay Kurulum ve Ayar Sihirbazı.',
        'next'    => 'Gereksinimleri Kontrol Et',
        'choose_language'    => 'Dil Seç',
        'verify_requirements'    => 'Gereksinimleri Doğrula',
        'setup_environment'    => 'Ortamı Ayarla',
        'configure_site'    => 'Siteyi Yapılandır',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Adım 1 | Sunucu Gereksinimleri',
        'title' => 'Sunucu Gereksinimleri ve İzinleri',
        'next'    => 'İleri',
        'prev'    => 'Geri',
        'required'    => 'gerekli',
        'error'     => 'Lütfen sunucu gereksinimlerini kontrol edin ve gerekli izinleri verin.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Adım 2 | İzinler',
        'title' => 'İzinler',
        'next' => 'Ortamı Yapılandır',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Ortam Ayarlarını Yapılandır',
            'title' => 'Ortam Ayarlarını Yapılandır',
            'wizard-button' => 'Form Sihirbazı ile Kurulum',
            'classic-button' => 'Klasik Metin Düzenleyici',
        ],
        'wizard' => [
            'templateTitle' => 'Adım 3 | Ortam Ayarları | Kılavuzlu Sihirbaz',
            'step3_title' => 'Ortam Ayarlarını Yapılandır',
            'step4_title' => 'Veritabanı Ayarlarını Yapılandır',
            'step5_title' => 'Uygulama Ayarlarını Yapılandır',
            'step6_title' => 'Yönetici Ayarlarını Yapılandır',
            'step7_title' => 'Başarılı',
            'step3_description' => 'Uygulamanın <code>.env</code> dosyasını nasıl yapılandırmak istediğinizi seçin.',
            'step4_description' => 'Aşağıya veritabanı bağlantı bilgilerinizi girin. Bunlardan emin değilseniz hosting sağlayıcınızla iletişime geçin.',
            'step5_description' => 'Uygulamanın <code>.env</code> dosyasını nasıl yapılandırmak istediğinizi seçin.',
            'step6_description' => 'Aşağıya yönetici bilgilerini girin.',
            'step7_description' => 'W3cms başarıyla kuruldu. Teşekkürler, iyi kullanımlar.',
            'tabs' => [
                'environment' => 'Ortam',
                'database' => 'Veritabanı',
                'application' => 'Uygulama',
            ],
            'form' => [
                'name_required' => 'Bir ortam adı gereklidir.',
                'app_name_label' => 'Uygulama Adı',
                'app_name_placeholder' => 'Uygulama Adı',
                'app_environment_label' => 'Uygulama Ortamı',
                'app_environment_label_local' => 'Yerel',
                'app_environment_label_developement' => 'Geliştirme',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Üretim',
                'app_environment_label_other' => 'Diğer',
                'app_environment_placeholder_other' => 'Ortamınızı girin...',
                'app_debug_label' => 'Uygulama Hata Ayıklama',
                'app_debug_label_true' => 'Doğru',
                'app_debug_label_false' => 'Yanlış',
                'app_log_level_label' => 'Uygulama Günlük Seviyesi',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'Uygulama URL\'si',
                'app_url_placeholder' => 'Uygulama URL\'si',
                'asset_url_label' => 'Asset URL\'si',
                'asset_url_placeholder' => 'Asset URL\'si',
                'db_connection_failed' => 'Veritabanına bağlanılamadı.',
                'db_connection_label' => 'Veritabanı Bağlantısı',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Veritabanı Sunucusu',
                'db_host_placeholder' => 'Veritabanı Sunucusu',
                'db_port_label' => 'Veritabanı Portu',
                'db_port_placeholder' => 'Veritabanı Portu',
                'db_name_label' => 'Veritabanı Adı',
                'db_name_placeholder' => 'Veritabanı Adı',
                'db_username_label' => 'Veritabanı Kullanıcı Adı',
                'db_username_placeholder' => 'Veritabanı Kullanıcı Adı',
                'db_password_label' => 'Veritabanı Şifresi',
                'db_password_placeholder' => 'Veritabanı Şifresi',

                'app_tabs' => [
                    'more_info' => 'Daha Fazla Bilgi',
                    'broadcasting_title' => 'Broadcasting, Önbellek, Oturum ve Kuyruk',
                    'broadcasting_label' => 'Broadcast Sürücüsü',
                    'broadcasting_placeholder' => 'Broadcast Sürücüsü',
                    'cache_label' => 'Önbellek Sürücüsü',
                    'cache_placeholder' => 'Önbellek Sürücüsü',
                    'filesystem_driver_label' => 'Dosya Sistemi Sürücüsü',
                    'filesystem_driver_placeholder' => 'Dosya Sistemi Sürücüsü',
                    'session_label' => 'Oturum Sürücüsü',
                    'session_placeholder' => 'Oturum Sürücüsü',
                    'queue_connection_label' => 'Kuyruk Bağlantısı',
                    'queue_connection_placeholder' => 'Kuyruk Bağlantısı',
                    'redis_label' => 'Redis Sürücüsü',
                    'redis_host' => 'Redis Sunucusu',
                    'redis_password' => 'Redis Şifresi',
                    'redis_port' => 'Redis Portu',

                    'mail_label' => 'E-posta',
                    'mail_driver_label' => 'E-posta Sürücüsü',
                    'mail_driver_placeholder' => 'E-posta Sürücüsü',
                    'mail_host_label' => 'E-posta Sunucusu',
                    'mail_host_placeholder' => 'E-posta Sunucusu',
                    'mail_port_label' => 'E-posta Portu',
                    'mail_port_placeholder' => 'E-posta Portu',
                    'mail_username_label' => 'E-posta Kullanıcı Adı',
                    'mail_username_placeholder' => 'E-posta Kullanıcı Adı',
                    'mail_password_label' => 'E-posta Şifresi',
                    'mail_password_placeholder' => 'E-posta Şifresi',
                    'mail_encryption_label' => 'E-posta Şifrelemesi',
                    'mail_encryption_placeholder' => 'E-posta Şifrelemesi',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS Erişim Anahtarı Kimliği',
                    'aws_access_key_placeholder' => 'AWS Erişim Anahtarı Kimliği',
                    'aws_secret_key_label' => 'AWS Erişim Anahtarı',
                    'aws_secret_key_placeholder' => 'AWS Erişim Anahtarı',
                    'aws_default_region_label' => 'AWS Varsayılan Bölgesi',
                    'aws_default_region_placeholder' => 'AWS Varsayılan Bölgesi',
                    'aws_bucket_label' => 'AWS Bucket',
                    'aws_bucket_placeholder' => 'AWS Bucket',
                    'aws_endpoint_label' => 'AWS Yol Tarzı Endpoint Kullan',
                    'aws_endpoint_placeholder' => 'AWS Yol Tarzı Endpoint Kullan',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher Uygulama Kimliği',
                    'pusher_app_id_palceholder' => 'Pusher Uygulama Kimliği',
                    'pusher_app_key_label' => 'Pusher Uygulama Anahtarı',
                    'pusher_app_key_palceholder' => 'Pusher Uygulama Anahtarı',
                    'pusher_app_secret_label' => 'Pusher Uygulama Gizli Anahtarı',
                    'pusher_app_secret_palceholder' => 'Pusher Uygulama Gizli Anahtarı',
                ],
                'input_labels' => [
                    'app_name' => 'Uygulamanın adını belirleyin.',
                    'app_environment' => 'Uygulamada kullanmak istediğiniz ortam.',
                    'app_debug' => 'Hata ayrıntılarının kullanıcıya ne kadar gösterileceğini belirler.',
                    'app_log_level' => 'Uygulamanın günlük seviyesini belirleyin.',
                    'app_url' => 'Uygulama için istediğiniz URL\'yi belirleyin.',
                    'db_connection' => 'Uygulamanın veritabanı bağlantısı.',
                    'db_host' => 'Uygulamanın veritabanı sunucusunu belirleyin.',
                    'db_port' => 'Uygulamanın veritabanı portunu belirleyin.',
                    'db_name' => 'W3mcs ile kullanmak istediğiniz veritabanının adı.',
                    'db_user_name' => 'Veritabanı kullanıcı adınız.',
                    'db_password' => 'Veritabanı şifreniz.',
                ],
                'buttons' => [
                    'setup_database' => 'Veritabanını Kur',
                    'setup_application' => 'Uygulamayı Kur',
                    'save' => 'Kaydet',
                    'installation' => 'Kurulumu Çalıştır',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Adım 3 | Ortam Ayarları | Klasik Düzenleyici',
            'title' => 'Klasik Ortam Düzenleyicisi',
            'save' => '.env Kaydet',
            'back' => 'Form Sihirbazını Kullan',
            'install' => 'Kaydet ve Yükle',
        ],
        'success' => '.env dosyası ayarları başarıyla kaydedildi.',
        'errors' => '.env dosyası kaydedilemedi. Lütfen dosyayı manuel olarak oluşturun.',
    ],

    'install' => 'Yükle',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer başarıyla KURULDU: ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Kurulum Tamamlandı',
        'templateTitle' => 'Kurulum Tamamlandı',
        'finished' => 'Uygulama başarıyla kuruldu.',
        'migration' => 'Migration ve Seed Konsol Çıktısı:',
        'console' => 'Uygulama Konsol Çıktısı:',
        'log' => 'Kurulum Günlüğü Kaydı:',
        'env' => 'Son .env Dosyası:',
        'exit' => 'Giriş yapmak için buraya tıklayın',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Yönetici Kurulumu'
        ],
        'name' => 'Ad Soyad',
        'name_description' => 'Kullanıcının adını ve soyadını girin. Ad ve soyad yalnızca alfanümerik karakterler vb. içerebilir.',
        'email' => 'E-posta',
        'email_description' => 'Devam etmeden önce e-posta adresinizi tekrar kontrol edin.',
        'password' => 'Şifre',
        'password_description' => 'Önemli: Giriş yapmak için bu şifreye ihtiyacınız olacak. Lütfen güvenli bir yerde saklayın.',
        'confirm_password' => 'Şifreyi Onayla',
        'confirm_password_description' => 'Şifrenizi burada tekrar onaylayın.',
        'save' => 'Kaydet ve Giriş Yap',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Şimdi veritabanınızla iletişim kurmak için Kurulumu Çalıştır düğmesine tıklayın.'
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
        'title' => 'Laravel Güncelleyici',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Güncelleyiciye Hoş Geldiniz',
            'message' => 'Güncelleme sihirbazına hoş geldiniz.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Genel Bakış',
            'message' => '1 güncelleme var.|:number güncelleme var.',
            'install_updates' => 'Güncellemeleri Yükle',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Tamamlandı',
            'finished' => 'Uygulamanın veritabanı başarıyla güncellendi.',
            'exit' => 'Çıkmak için buraya tıklayın',
        ],

        'log' => [
            'success_message' => 'Laravel Installer başarıyla GÜNCELLENDİ: ',
        ],
    ],
];

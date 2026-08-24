<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versi',
    'title' => 'Penginstal Laravel',
    'next' => 'Langkah Berikutnya',
    'back' => 'Sebelumnya',
    'finish' => 'Instal',
    'forms' => [
        'errorTitle' => 'Terjadi kesalahan berikut:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Selamat Datang',
        'title'   => 'Penginstal Laravel',
        'message' => 'Wizard Instalasi dan Pengaturan yang Mudah.',
        'next'    => 'Periksa Persyaratan',
        'choose_language'    => 'Pilih Bahasa',
        'verify_requirements'    => 'Verifikasi Persyaratan',
        'setup_environment'    => 'Atur Lingkungan',
        'configure_site'    => 'Konfigurasi Situs',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Langkah 1 | Persyaratan Server',
        'title' => 'Persyaratan & Izin Server',
        'next'    => 'Berikutnya',
        'prev'    => 'Sebelumnya',
        'required'    => 'diperlukan',
        'error'     => 'Silakan periksa persyaratan server dan berikan izin yang diperlukan.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Langkah 2 | Izin',
        'title' => 'Izin',
        'next' => 'Konfigurasi Lingkungan',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Pengaturan Lingkungan',
            'title' => 'Pengaturan Lingkungan',
            'wizard-button' => 'Pengaturan dengan Wizard Formulir',
            'classic-button' => 'Editor Teks Klasik',
        ],
        'wizard' => [
            'templateTitle' => 'Langkah 3 | Pengaturan Lingkungan | Wizard Terpandu',
            'step3_title' => 'Pengaturan Lingkungan',
            'step4_title' => 'Pengaturan Database',
            'step5_title' => 'Pengaturan Aplikasi',
            'step6_title' => 'Pengaturan Admin',
            'step7_title' => 'Berhasil',
            'step3_description' => 'Silakan pilih bagaimana Anda ingin mengonfigurasi file <code>.env</code> aplikasi.',
            'step4_description' => 'Masukkan detail koneksi database Anda di bawah ini. Jika Anda tidak yakin, hubungi penyedia hosting Anda.',
            'step5_description' => 'Silakan pilih bagaimana Anda ingin mengonfigurasi file <code>.env</code> aplikasi.',
            'step6_description' => 'Masukkan detail Admin di bawah ini.',
            'step7_description' => 'W3cms telah berhasil diinstal. Terima kasih dan selamat menikmati.',
            'tabs' => [
                'environment' => 'Lingkungan',
                'database' => 'Database',
                'application' => 'Aplikasi',
            ],
            'form' => [
                'name_required' => 'Nama lingkungan wajib diisi.',
                'app_name_label' => 'Nama Aplikasi',
                'app_name_placeholder' => 'Nama Aplikasi',
                'app_environment_label' => 'Lingkungan Aplikasi',
                'app_environment_label_local' => 'Lokal',
                'app_environment_label_developement' => 'Pengembangan',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Produksi',
                'app_environment_label_other' => 'Lainnya',
                'app_environment_placeholder_other' => 'Masukkan lingkungan Anda...',
                'app_debug_label' => 'Debug Aplikasi',
                'app_debug_label_true' => 'Aktif',
                'app_debug_label_false' => 'Nonaktif',
                'app_log_level_label' => 'Tingkat Log Aplikasi',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'peringatan',
                'app_log_level_label_error' => 'kesalahan',
                'app_log_level_label_critical' => 'kritis',
                'app_log_level_label_alert' => 'peringatan',
                'app_log_level_label_emergency' => 'darurat',
                'app_url_label' => 'URL Aplikasi',
                'app_url_placeholder' => 'URL Aplikasi',
                'asset_url_label' => 'URL Aset',
                'asset_url_placeholder' => 'URL Aset',
                'db_connection_failed' => 'Tidak dapat terhubung ke database.',
                'db_connection_label' => 'Koneksi Database',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host Database',
                'db_host_placeholder' => 'Host Database',
                'db_port_label' => 'Port Database',
                'db_port_placeholder' => 'Port Database',
                'db_name_label' => 'Nama Database',
                'db_name_placeholder' => 'Nama Database',
                'db_username_label' => 'Nama Pengguna Database',
                'db_username_placeholder' => 'Nama Pengguna Database',
                'db_password_label' => 'Kata Sandi Database',
                'db_password_placeholder' => 'Kata Sandi Database',

                'app_tabs' => [
                    'more_info' => 'Informasi Lainnya',
                    'broadcasting_title' => 'Broadcasting, Cache, Sesi, &amp; Antrean',
                    'broadcasting_label' => 'Driver Broadcasting',
                    'broadcasting_placeholder' => 'Driver Broadcasting',
                    'cache_label' => 'Driver Cache',
                    'cache_placeholder' => 'Driver Cache',
                    'filesystem_driver_label' => 'Driver Sistem File',
                    'filesystem_driver_placeholder' => 'Driver Sistem File',
                    'session_label' => 'Driver Sesi',
                    'session_placeholder' => 'Driver Sesi',
                    'queue_connection_label' => 'Koneksi Antrean',
                    'queue_connection_placeholder' => 'Koneksi Antrean',
                    'redis_label' => 'Driver Redis',
                    'redis_host' => 'Host Redis',
                    'redis_password' => 'Kata Sandi Redis',
                    'redis_port' => 'Port Redis',

                    'mail_label' => 'Email',
                    'mail_driver_label' => 'Driver Email',
                    'mail_driver_placeholder' => 'Driver Email',
                    'mail_host_label' => 'Host Email',
                    'mail_host_placeholder' => 'Host Email',
                    'mail_port_label' => 'Port Email',
                    'mail_port_placeholder' => 'Port Email',
                    'mail_username_label' => 'Nama Pengguna Email',
                    'mail_username_placeholder' => 'Nama Pengguna Email',
                    'mail_password_label' => 'Kata Sandi Email',
                    'mail_password_placeholder' => 'Kata Sandi Email',
                    'mail_encryption_label' => 'Enkripsi Email',
                    'mail_encryption_placeholder' => 'Enkripsi Email',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID Kunci Akses AWS',
                    'aws_access_key_placeholder' => 'ID Kunci Akses AWS',
                    'aws_secret_key_label' => 'Kunci Akses AWS',
                    'aws_secret_key_placeholder' => 'Kunci Akses AWS',
                    'aws_default_region_label' => 'Wilayah Default AWS',
                    'aws_default_region_placeholder' => 'Wilayah Default AWS',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Gunakan Endpoint AWS dengan Gaya Path',
                    'aws_endpoint_placeholder' => 'Gunakan Endpoint AWS dengan Gaya Path',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID Aplikasi Pusher',
                    'pusher_app_id_palceholder' => 'ID Aplikasi Pusher',
                    'pusher_app_key_label' => 'Kunci Aplikasi Pusher',
                    'pusher_app_key_palceholder' => 'Kunci Aplikasi Pusher',
                    'pusher_app_secret_label' => 'Secret Aplikasi Pusher',
                    'pusher_app_secret_palceholder' => 'Secret Aplikasi Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Tetapkan nama aplikasi.',
                    'app_environment' => 'Lingkungan yang ingin Anda gunakan pada aplikasi.',
                    'app_debug' => 'Menentukan seberapa banyak detail kesalahan yang ditampilkan kepada pengguna.',
                    'app_log_level' => 'Tetapkan tingkat log aplikasi.',
                    'app_url' => 'Tetapkan URL yang ingin Anda gunakan untuk aplikasi.',
                    'db_connection' => 'Koneksi database aplikasi.',
                    'db_host' => 'Tetapkan host database aplikasi.',
                    'db_port' => 'Tetapkan port database aplikasi.',
                    'db_name' => 'Nama database yang ingin Anda gunakan dengan W3mcs.',
                    'db_user_name' => 'Nama pengguna database Anda.',
                    'db_password' => 'Kata sandi database Anda.',
                ],
                'buttons' => [
                    'setup_database' => 'Atur Database',
                    'setup_application' => 'Atur Aplikasi',
                    'save' => 'Simpan',
                    'installation' => 'Jalankan Instalasi',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Langkah 3 | Pengaturan Lingkungan | Editor Klasik',
            'title' => 'Editor Lingkungan Klasik',
            'save' => 'Simpan .env',
            'back' => 'Gunakan Wizard Formulir',
            'install' => 'Simpan dan Instal',
        ],
        'success' => 'Pengaturan file .env Anda telah berhasil disimpan.',
        'errors' => 'Tidak dapat menyimpan file .env. Silakan buat file tersebut secara manual.',
    ],

    'install' => 'Instal',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Penginstal Laravel berhasil DIINSTAL pada ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Instalasi Selesai',
        'templateTitle' => 'Instalasi Selesai',
        'finished' => 'Aplikasi telah berhasil diinstal.',
        'migration' => 'Output Konsol Migrasi &amp; Seed:',
        'console' => 'Output Konsol Aplikasi:',
        'log' => 'Entri Log Instalasi:',
        'env' => 'File .env Final:',
        'exit' => 'Klik di sini untuk masuk',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Pengaturan Admin'
        ],
        'name' => 'Nama Lengkap',
        'name_description' => 'Masukkan Nama Lengkap Pengguna. Nama Lengkap hanya dapat berisi karakter alfanumerik, dll.',
        'email' => 'Email',
        'email_description' => 'Periksa kembali alamat email Anda sebelum melanjutkan.',
        'password' => 'Kata Sandi',
        'password_description' => 'Penting: Anda akan memerlukan kata sandi ini untuk masuk. Simpan di tempat yang aman.',
        'confirm_password' => 'Konfirmasi Kata Sandi',
        'confirm_password_description' => 'Konfirmasikan kembali kata sandi Anda.',
        'save' => 'Simpan dan Masuk',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Sekarang hubungkan aplikasi dengan database Anda dengan mengklik tombol Jalankan Instalasi.'
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
        'title' => 'Pembaruan Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Selamat Datang di Pembaruan',
            'message' => 'Selamat datang di wizard pembaruan.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Ringkasan',
            'message' => 'Ada 1 pembaruan.|Ada :number pembaruan.',
            'install_updates' => 'Instal Pembaruan',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Selesai',
            'finished' => "Database aplikasi telah berhasil diperbarui.",
            'exit' => 'Klik di sini untuk keluar',
        ],

        'log' => [
            'success_message' => 'Penginstal Laravel berhasil DIPERBARUI pada ',
        ],
    ],
];
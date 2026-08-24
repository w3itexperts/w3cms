<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => '版本',
    'title' => 'Laravel 安裝程式',
    'next' => '下一步',
    'back' => '上一步',
    'finish' => '安裝',
    'forms' => [
        'errorTitle' => '發生以下錯誤：',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => '歡迎',
        'title'   => 'Laravel 安裝程式',
        'message' => '簡易的安裝與設定精靈。',
        'next'    => '檢查系統需求',
        'choose_language'    => '選擇語言',
        'verify_requirements'    => '驗證系統需求',
        'setup_environment'    => '設定環境',
        'configure_site'    => '設定網站',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => '步驟 1 | 伺服器需求',
        'title' => '伺服器需求與權限',
        'next'    => '下一步',
        'prev'    => '上一步',
        'required'    => '必要',
        'error'     => '請檢查伺服器需求並授予必要的權限。'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => '步驟 2 | 權限',
        'title' => '權限',
        'next' => '設定環境',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => '設定環境設定',
            'title' => '設定環境設定',
            'wizard-button' => '表單精靈設定',
            'classic-button' => '傳統文字編輯器',
        ],
        'wizard' => [
            'templateTitle' => '步驟 3 | 環境設定 | 引導式精靈',
            'step3_title' => '設定環境設定',
            'step4_title' => '設定資料庫設定',
            'step5_title' => '設定應用程式設定',
            'step6_title' => '設定管理員設定',
            'step7_title' => '成功',
            'step3_description' => '請選擇您要如何設定應用程式的 <code>.env</code> 檔案。',
            'step4_description' => '請在下方輸入您的資料庫連線詳細資訊。如果您不確定這些資訊，請聯絡您的主機服務商。',
            'step5_description' => '請選擇您要如何設定應用程式的 <code>.env</code> 檔案。',
            'step6_description' => '請在下方輸入管理員詳細資訊。',
            'step7_description' => 'W3cms 已成功安裝。感謝您，祝您使用愉快。',
            'tabs' => [
                'environment' => '環境',
                'database' => '資料庫',
                'application' => '應用程式',
            ],
            'form' => [
                'name_required' => '必須輸入環境名稱。',
                'app_name_label' => '應用程式名稱',
                'app_name_placeholder' => '應用程式名稱',
                'app_environment_label' => '應用程式環境',
                'app_environment_label_local' => '本機',
                'app_environment_label_developement' => '開發',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => '正式環境',
                'app_environment_label_other' => '其他',
                'app_environment_placeholder_other' => '輸入您的環境...',
                'app_debug_label' => '應用程式偵錯',
                'app_debug_label_true' => '開啟',
                'app_debug_label_false' => '關閉',
                'app_log_level_label' => '應用程式日誌層級',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => '應用程式 URL',
                'app_url_placeholder' => '應用程式 URL',
                'asset_url_label' => '資源 URL',
                'asset_url_placeholder' => '資源 URL',
                'db_connection_failed' => '無法連線至資料庫。',
                'db_connection_label' => '資料庫連線',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => '資料庫主機',
                'db_host_placeholder' => '資料庫主機',
                'db_port_label' => '資料庫連接埠',
                'db_port_placeholder' => '資料庫連接埠',
                'db_name_label' => '資料庫名稱',
                'db_name_placeholder' => '資料庫名稱',
                'db_username_label' => '資料庫使用者名稱',
                'db_username_placeholder' => '資料庫使用者名稱',
                'db_password_label' => '資料庫密碼',
                'db_password_placeholder' => '資料庫密碼',

                'app_tabs' => [
                    'more_info' => '更多資訊',
                    'broadcasting_title' => '廣播、快取、工作階段與佇列',
                    'broadcasting_label' => '廣播驅動程式',
                    'broadcasting_placeholder' => '廣播驅動程式',
                    'cache_label' => '快取驅動程式',
                    'cache_placeholder' => '快取驅動程式',
                    'filesystem_driver_label' => '檔案系統驅動程式',
                    'filesystem_driver_placeholder' => '檔案系統驅動程式',
                    'session_label' => '工作階段驅動程式',
                    'session_placeholder' => '工作階段驅動程式',
                    'queue_connection_label' => '佇列連線',
                    'queue_connection_placeholder' => '佇列連線',
                    'redis_label' => 'Redis 驅動程式',
                    'redis_host' => 'Redis 主機',
                    'redis_password' => 'Redis 密碼',
                    'redis_port' => 'Redis 連接埠',

                    'mail_label' => '郵件',
                    'mail_driver_label' => '郵件驅動程式',
                    'mail_driver_placeholder' => '郵件驅動程式',
                    'mail_host_label' => '郵件主機',
                    'mail_host_placeholder' => '郵件主機',
                    'mail_port_label' => '郵件連接埠',
                    'mail_port_placeholder' => '郵件連接埠',
                    'mail_username_label' => '郵件使用者名稱',
                    'mail_username_placeholder' => '郵件使用者名稱',
                    'mail_password_label' => '郵件密碼',
                    'mail_password_placeholder' => '郵件密碼',
                    'mail_encryption_label' => '郵件加密',
                    'mail_encryption_placeholder' => '郵件加密',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS 存取金鑰 ID',
                    'aws_access_key_placeholder' => 'AWS 存取金鑰 ID',
                    'aws_secret_key_label' => 'AWS 存取金鑰',
                    'aws_secret_key_placeholder' => 'AWS 存取金鑰',
                    'aws_default_region_label' => 'AWS 預設區域',
                    'aws_default_region_placeholder' => 'AWS 預設區域',
                    'aws_bucket_label' => 'AWS 儲存貯體',
                    'aws_bucket_placeholder' => 'AWS 儲存貯體',
                    'aws_endpoint_label' => '使用 AWS 路徑樣式端點',
                    'aws_endpoint_placeholder' => '使用 AWS 路徑樣式端點',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher 應用程式 ID',
                    'pusher_app_id_palceholder' => 'Pusher 應用程式 ID',
                    'pusher_app_key_label' => 'Pusher 應用程式金鑰',
                    'pusher_app_key_palceholder' => 'Pusher 應用程式金鑰',
                    'pusher_app_secret_label' => 'Pusher 應用程式密鑰',
                    'pusher_app_secret_palceholder' => 'Pusher 應用程式密鑰',
                ],
                'input_labels' => [
                    'app_name' => '設定應用程式名稱。',
                    'app_environment' => '您要在應用程式中使用的環境。',
                    'app_debug' => '定義向使用者顯示多少錯誤詳細資訊。',
                    'app_log_level' => '設定應用程式的日誌層級。',
                    'app_url' => '設定您希望使用的應用程式 URL。',
                    'db_connection' => '應用程式的資料庫連線。',
                    'db_host' => '設定應用程式的資料庫主機。',
                    'db_port' => '設定應用程式的資料庫連接埠。',
                    'db_name' => '您希望與 W3mcs 搭配使用的資料庫名稱。',
                    'db_user_name' => '您的資料庫使用者名稱。',
                    'db_password' => '您的資料庫密碼。',
                ],
                'buttons' => [
                    'setup_database' => '設定資料庫',
                    'setup_application' => '設定應用程式',
                    'save' => '儲存',
                    'installation' => '執行安裝',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => '步驟 3 | 環境設定 | 傳統編輯器',
            'title' => '傳統環境編輯器',
            'save' => '儲存 .env',
            'back' => '使用表單精靈',
            'install' => '儲存並安裝',
        ],
        'success' => '.env 檔案設定已成功儲存。',
        'errors' => '無法儲存 .env 檔案，請手動建立該檔案。',
    ],

    'install' => '安裝',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer 已成功安裝於 ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => '安裝完成',
        'templateTitle' => '安裝完成',
        'finished' => '應用程式已成功安裝。',
        'migration' => 'Migration 與 Seed 主控台輸出：',
        'console' => '應用程式主控台輸出：',
        'log' => '安裝日誌記錄：',
        'env' => '最終 .env 檔案：',
        'exit' => '點擊此處登入',
    ],

    'admin' => [
        'wizard' => [
            'title' => '管理員設定'
        ],
        'name' => '全名',
        'name_description' => '輸入使用者的全名。全名可以包含英數字元等。',
        'email' => '電子郵件',
        'email_description' => '繼續之前，請再次確認您的電子郵件地址。',
        'password' => '密碼',
        'password_description' => '重要：您將需要此密碼登入。請將其儲存在安全的位置。',
        'confirm_password' => '確認密碼',
        'confirm_password_description' => '請在此處再次確認您的密碼。',
        'save' => '儲存並登入',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => '現在與您的資料庫進行通訊，請點擊「執行安裝」按鈕。'
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
        'title' => 'Laravel 更新程式',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => '歡迎使用更新程式',
            'message' => '歡迎使用更新精靈。',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => '概覽',
            'message' => '有 1 個更新。|有 :number 個更新。',
            'install_updates' => '安裝更新',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => '完成',
            'finished' => '應用程式的資料庫已成功更新。',
            'exit' => '點擊此處退出',
        ],

        'log' => [
            'success_message' => 'Laravel Installer 已成功更新於 ',
        ],
    ],
];

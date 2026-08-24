<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => '版本',
    'title' => 'Laravel 安装程序',
    'next' => '下一步',
    'back' => '上一步',
    'finish' => '安装',
    'forms' => [
        'errorTitle' => '发生了以下错误：',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => '欢迎',
        'title'   => 'Laravel 安装程序',
        'message' => '简单易用的安装和配置向导。',
        'next'    => '检查系统要求',
        'choose_language'    => '选择语言',
        'verify_requirements'    => '验证系统要求',
        'setup_environment'    => '设置环境',
        'configure_site'    => '配置网站',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => '步骤 1 | 服务器要求',
        'title' => '服务器要求和权限',
        'next'    => '下一步',
        'prev'    => '上一步',
        'required'    => '必需',
        'error'     => '请检查服务器要求并授予相应权限。'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => '步骤 2 | 权限',
        'title' => '权限',
        'next' => '配置环境',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => '设置环境配置',
            'title' => '设置环境配置',
            'wizard-button' => '表单向导设置',
            'classic-button' => '经典文本编辑器',
        ],
        'wizard' => [
            'templateTitle' => '步骤 3 | 环境设置 | 引导式向导',
            'step3_title' => '设置环境配置',
            'step4_title' => '设置数据库配置',
            'step5_title' => '设置应用程序配置',
            'step6_title' => '设置管理员配置',
            'step7_title' => '成功',
            'step3_description' => '请选择您希望如何配置应用程序的 <code>.env</code> 文件。',
            'step4_description' => '请在下面输入数据库连接详细信息。如果您不确定这些信息，请联系您的主机服务商。',
            'step5_description' => '请选择您希望如何配置应用程序的 <code>.env</code> 文件。',
            'step6_description' => '请在下面输入管理员详细信息。',
            'step7_description' => 'W3cms 已安装成功。感谢您的使用，祝您使用愉快。',
            'tabs' => [
                'environment' => '环境',
                'database' => '数据库',
                'application' => '应用程序',
            ],
            'form' => [
                'name_required' => '环境名称为必填项。',
                'app_name_label' => '应用程序名称',
                'app_name_placeholder' => '应用程序名称',
                'app_environment_label' => '应用程序环境',
                'app_environment_label_local' => '本地',
                'app_environment_label_developement' => '开发',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => '生产',
                'app_environment_label_other' => '其他',
                'app_environment_placeholder_other' => '输入您的环境...',
                'app_debug_label' => '应用程序调试',
                'app_debug_label_true' => '开启',
                'app_debug_label_false' => '关闭',
                'app_log_level_label' => '应用程序日志级别',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => '应用程序 URL',
                'app_url_placeholder' => '应用程序 URL',
                'asset_url_label' => '资源 URL',
                'asset_url_placeholder' => '资源 URL',
                'db_connection_failed' => '无法连接到数据库。',
                'db_connection_label' => '数据库连接',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => '数据库主机',
                'db_host_placeholder' => '数据库主机',
                'db_port_label' => '数据库端口',
                'db_port_placeholder' => '数据库端口',
                'db_name_label' => '数据库名称',
                'db_name_placeholder' => '数据库名称',
                'db_username_label' => '数据库用户名',
                'db_username_placeholder' => '数据库用户名',
                'db_password_label' => '数据库密码',
                'db_password_placeholder' => '数据库密码',

                'app_tabs' => [
                    'more_info' => '更多信息',
                    'broadcasting_title' => '广播、缓存、会话和队列',
                    'broadcasting_label' => '广播驱动',
                    'broadcasting_placeholder' => '广播驱动',
                    'cache_label' => '缓存驱动',
                    'cache_placeholder' => '缓存驱动',
                    'filesystem_driver_label' => '文件系统驱动',
                    'filesystem_driver_placeholder' => '文件系统驱动',
                    'session_label' => '会话驱动',
                    'session_placeholder' => '会话驱动',
                    'queue_connection_label' => '队列连接',
                    'queue_connection_placeholder' => '队列连接',
                    'redis_label' => 'Redis 驱动',
                    'redis_host' => 'Redis 主机',
                    'redis_password' => 'Redis 密码',
                    'redis_port' => 'Redis 端口',

                    'mail_label' => '邮件',
                    'mail_driver_label' => '邮件驱动',
                    'mail_driver_placeholder' => '邮件驱动',
                    'mail_host_label' => '邮件主机',
                    'mail_host_placeholder' => '邮件主机',
                    'mail_port_label' => '邮件端口',
                    'mail_port_placeholder' => '邮件端口',
                    'mail_username_label' => '邮件用户名',
                    'mail_username_placeholder' => '邮件用户名',
                    'mail_password_label' => '邮件密码',
                    'mail_password_placeholder' => '邮件密码',
                    'mail_encryption_label' => '邮件加密',
                    'mail_encryption_placeholder' => '邮件加密',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS 访问密钥 ID',
                    'aws_access_key_placeholder' => 'AWS 访问密钥 ID',
                    'aws_secret_key_label' => 'AWS 访问密钥',
                    'aws_secret_key_placeholder' => 'AWS 访问密钥',
                    'aws_default_region_label' => 'AWS 默认区域',
                    'aws_default_region_placeholder' => 'AWS 默认区域',
                    'aws_bucket_label' => 'AWS 存储桶',
                    'aws_bucket_placeholder' => 'AWS 存储桶',
                    'aws_endpoint_label' => '使用 AWS 路径样式 Endpoint',
                    'aws_endpoint_placeholder' => '使用 AWS 路径样式 Endpoint',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher 应用程序 ID',
                    'pusher_app_id_palceholder' => 'Pusher 应用程序 ID',
                    'pusher_app_key_label' => 'Pusher 应用程序密钥',
                    'pusher_app_key_palceholder' => 'Pusher 应用程序密钥',
                    'pusher_app_secret_label' => 'Pusher 应用程序密钥',
                    'pusher_app_secret_palceholder' => 'Pusher 应用程序密钥',
                ],
                'input_labels' => [
                    'app_name' => '设置应用程序名称。',
                    'app_environment' => '您希望在应用程序中使用的环境。',
                    'app_debug' => '定义向用户显示多少错误详细信息。',
                    'app_log_level' => '设置应用程序的日志级别。',
                    'app_url' => '设置应用程序所需的 URL。',
                    'db_connection' => '应用程序的数据库连接。',
                    'db_host' => '设置应用程序的数据库主机。',
                    'db_port' => '设置应用程序的数据库端口。',
                    'db_name' => '您希望与 W3mcs 一起使用的数据库名称。',
                    'db_user_name' => '您的数据库用户名。',
                    'db_password' => '您的数据库密码。',
                ],
                'buttons' => [
                    'setup_database' => '设置数据库',
                    'setup_application' => '设置应用程序',
                    'save' => '保存',
                    'installation' => '运行安装',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => '步骤 3 | 环境设置 | 经典编辑器',
            'title' => '经典环境编辑器',
            'save' => '保存 .env',
            'back' => '使用表单向导',
            'install' => '保存并安装',
        ],
        'success' => '.env 文件设置已成功保存。',
        'errors' => '无法保存 .env 文件，请手动创建该文件。',
    ],

    'install' => '安装',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer 已成功安装于 ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => '安装完成',
        'templateTitle' => '安装完成',
        'finished' => '应用程序已成功安装。',
        'migration' => '迁移和 Seed 控制台输出：',
        'console' => '应用程序控制台输出：',
        'log' => '安装日志记录：',
        'env' => '最终 .env 文件：',
        'exit' => '点击此处登录',
    ],

    'admin' => [
        'wizard' => [
            'title' => '管理员设置'
        ],
        'name' => '全名',
        'name_description' => '输入用户的全名。全名可以包含字母数字字符等。',
        'email' => '电子邮件',
        'email_description' => '继续之前请仔细检查您的电子邮件地址。',
        'password' => '密码',
        'password_description' => '重要提示：您需要使用此密码登录。请将其存放在安全的位置。',
        'confirm_password' => '确认密码',
        'confirm_password_description' => '请在此处再次确认您的密码。',
        'save' => '保存并登录',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => '现在与您的数据库进行通信，请点击“运行安装”按钮。'
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
        'title' => 'Laravel 更新程序',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => '欢迎使用更新程序',
            'message' => '欢迎使用更新向导。',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => '概览',
            'message' => '有 1 个更新。|有 :number 个更新。',
            'install_updates' => '安装更新',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => '完成',
            'finished' => '应用程序数据库已成功更新。',
            'exit' => '点击此处退出',
        ],

        'log' => [
            'success_message' => 'Laravel Installer 已成功更新于 ',
        ],
    ],
];

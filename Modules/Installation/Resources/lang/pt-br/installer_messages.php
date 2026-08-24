<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versão',
    'title' => 'Instalador Laravel',
    'next' => 'Próxima etapa',
    'back' => 'Anterior',
    'finish' => 'Instalar',
    'forms' => [
        'errorTitle' => 'Os seguintes erros ocorreram:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Bem-vindo',
        'title'   => 'Instalador Laravel',
        'message' => 'Assistente fácil de instalação e configuração.',
        'next'    => 'Verificar requisitos',
        'choose_language'    => 'Escolher idioma',
        'verify_requirements'    => 'Verificar requisitos',
        'setup_environment'    => 'Configurar ambiente',
        'configure_site'    => 'Configurar site',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Etapa 1 | Requisitos do servidor',
        'title' => 'Requisitos e permissões do servidor',
        'next'    => 'Próximo',
        'prev'    => 'Anterior',
        'required'    => 'obrigatório',
        'error'     => 'Verifique os requisitos do servidor e conceda as permissões necessárias.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Etapa 2 | Permissões',
        'title' => 'Permissões',
        'next' => 'Configurar ambiente',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Configurar definições do ambiente',
            'title' => 'Configurar definições do ambiente',
            'wizard-button' => 'Configuração com assistente',
            'classic-button' => 'Editor de texto clássico',
        ],
        'wizard' => [
            'templateTitle' => 'Etapa 3 | Configurações do ambiente | Assistente guiado',
            'step3_title' => 'Configurar configurações do ambiente',
            'step4_title' => 'Configurar configurações do banco de dados',
            'step5_title' => 'Configurar configurações da aplicação',
            'step6_title' => 'Configurar configurações do administrador',
            'step7_title' => 'Sucesso',
            'step3_description' => 'Selecione como deseja configurar o arquivo <code>.env</code> da aplicação.',
            'step4_description' => 'Insira abaixo os dados de conexão com o banco de dados. Se não tiver certeza sobre essas informações, entre em contato com seu provedor de hospedagem.',
            'step5_description' => 'Selecione como deseja configurar o arquivo <code>.env</code> da aplicação.',
            'step6_description' => 'Insira abaixo os dados do administrador.',
            'step7_description' => 'O W3cms foi instalado. Obrigado e aproveite.',
            'tabs' => [
                'environment' => 'Ambiente',
                'database' => 'Banco de dados',
                'application' => 'Aplicação',
            ],
            'form' => [
                'name_required' => 'O nome do ambiente é obrigatório.',
                'app_name_label' => 'Nome da aplicação',
                'app_name_placeholder' => 'Nome da aplicação',
                'app_environment_label' => 'Ambiente da aplicação',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Desenvolvimento',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Produção',
                'app_environment_label_other' => 'Outro',
                'app_environment_placeholder_other' => 'Digite seu ambiente...',
                'app_debug_label' => 'Debug da aplicação',
                'app_debug_label_true' => 'Verdadeiro',
                'app_debug_label_false' => 'Falso',
                'app_log_level_label' => 'Nível de log da aplicação',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL da aplicação',
                'app_url_placeholder' => 'URL da aplicação',
                'asset_url_label' => 'URL dos assets',
                'asset_url_placeholder' => 'URL dos assets',
                'db_connection_failed' => 'Não foi possível conectar ao banco de dados.',
                'db_connection_label' => 'Conexão com o banco de dados',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host do banco de dados',
                'db_host_placeholder' => 'Host do banco de dados',
                'db_port_label' => 'Porta do banco de dados',
                'db_port_placeholder' => 'Porta do banco de dados',
                'db_name_label' => 'Nome do banco de dados',
                'db_name_placeholder' => 'Nome do banco de dados',
                'db_username_label' => 'Nome de usuário do banco de dados',
                'db_username_placeholder' => 'Nome de usuário do banco de dados',
                'db_password_label' => 'Senha do banco de dados',
                'db_password_placeholder' => 'Senha do banco de dados',

                'app_tabs' => [
                    'more_info' => 'Mais informações',
                    'broadcasting_title' => 'Broadcasting, cache, sessão e fila',
                    'broadcasting_label' => 'Driver de Broadcasting',
                    'broadcasting_placeholder' => 'Driver de Broadcasting',
                    'cache_label' => 'Driver de cache',
                    'cache_placeholder' => 'Driver de cache',
                    'filesystem_driver_label' => 'Driver do sistema de arquivos',
                    'filesystem_driver_placeholder' => 'Driver do sistema de arquivos',
                    'session_label' => 'Driver de sessão',
                    'session_placeholder' => 'Driver de sessão',
                    'queue_connection_label' => 'Conexão da fila',
                    'queue_connection_placeholder' => 'Conexão da fila',
                    'redis_label' => 'Driver Redis',
                    'redis_host' => 'Host Redis',
                    'redis_password' => 'Senha Redis',
                    'redis_port' => 'Porta Redis',

                    'mail_label' => 'E-mail',
                    'mail_driver_label' => 'Driver de e-mail',
                    'mail_driver_placeholder' => 'Driver de e-mail',
                    'mail_host_label' => 'Host de e-mail',
                    'mail_host_placeholder' => 'Host de e-mail',
                    'mail_port_label' => 'Porta de e-mail',
                    'mail_port_placeholder' => 'Porta de e-mail',
                    'mail_username_label' => 'Nome de usuário do e-mail',
                    'mail_username_placeholder' => 'Nome de usuário do e-mail',
                    'mail_password_label' => 'Senha do e-mail',
                    'mail_password_placeholder' => 'Senha do e-mail',
                    'mail_encryption_label' => 'Criptografia do e-mail',
                    'mail_encryption_placeholder' => 'Criptografia do e-mail',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID da chave de acesso da AWS',
                    'aws_access_key_placeholder' => 'ID da chave de acesso da AWS',
                    'aws_secret_key_label' => 'Chave de acesso da AWS',
                    'aws_secret_key_placeholder' => 'Chave de acesso da AWS',
                    'aws_default_region_label' => 'Região padrão da AWS',
                    'aws_default_region_placeholder' => 'Região padrão da AWS',
                    'aws_bucket_label' => 'Bucket da AWS',
                    'aws_bucket_placeholder' => 'Bucket da AWS',
                    'aws_endpoint_label' => 'Usar endpoint da AWS no estilo de caminho',
                    'aws_endpoint_placeholder' => 'Usar endpoint da AWS no estilo de caminho',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID do aplicativo Pusher',
                    'pusher_app_id_palceholder' => 'ID do aplicativo Pusher',
                    'pusher_app_key_label' => 'Chave do aplicativo Pusher',
                    'pusher_app_key_palceholder' => 'Chave do aplicativo Pusher',
                    'pusher_app_secret_label' => 'Segredo do aplicativo Pusher',
                    'pusher_app_secret_palceholder' => 'Segredo do aplicativo Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Defina o nome da aplicação.',
                    'app_environment' => 'O ambiente que você deseja usar na aplicação.',
                    'app_debug' => 'Define quantos detalhes do erro são exibidos para o usuário.',
                    'app_log_level' => 'Defina o nível de log da aplicação.',
                    'app_url' => 'Defina a URL desejada para a aplicação.',
                    'db_connection' => 'A conexão do banco de dados da aplicação.',
                    'db_host' => 'Defina o host do banco de dados da aplicação.',
                    'db_port' => 'Defina a porta do banco de dados da aplicação.',
                    'db_name' => 'O nome do banco de dados que você deseja usar com o W3mcs.',
                    'db_user_name' => 'Seu nome de usuário do banco de dados.',
                    'db_password' => 'Sua senha do banco de dados.',
                ],
                'buttons' => [
                    'setup_database' => 'Configurar banco de dados',
                    'setup_application' => 'Configurar aplicação',
                    'save' => 'Salvar',
                    'installation' => 'Executar instalação',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Etapa 3 | Configurações do ambiente | Editor clássico',
            'title' => 'Editor clássico de ambiente',
            'save' => 'Salvar .env',
            'back' => 'Usar assistente de configuração',
            'install' => 'Salvar e instalar',
        ],
        'success' => 'As configurações do arquivo .env foram salvas.',
        'errors' => 'Não foi possível salvar o arquivo .env. Crie-o manualmente.',
    ],

    'install' => 'Instalar',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer instalado com sucesso em ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Instalação concluída',
        'templateTitle' => 'Instalação concluída',
        'finished' => 'A aplicação foi instalada com sucesso.',
        'migration' => 'Saída do console de migração e seed:',
        'console' => 'Saída do console da aplicação:',
        'log' => 'Entrada do log de instalação:',
        'env' => 'Arquivo .env final:',
        'exit' => 'Clique aqui para fazer login',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configuração do administrador'
        ],
        'name' => 'Nome completo',
        'name_description' => 'Digite o nome completo do usuário. O nome completo pode conter caracteres alfanuméricos etc.',
        'email' => 'E-mail',
        'email_description' => 'Verifique seu endereço de e-mail antes de continuar.',
        'password' => 'Senha',
        'password_description' => 'Importante: você precisará desta senha para fazer login. Guarde-a em um local seguro.',
        'confirm_password' => 'Confirmar senha',
        'confirm_password_description' => 'Confirme sua senha novamente aqui.',
        'save' => 'Salvar e fazer login',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Para se comunicar agora com seu banco de dados, clique no botão Executar instalação.'
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
        'title' => 'Atualizador Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Bem-vindo ao atualizador',
            'message' => 'Bem-vindo ao assistente de atualização.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Visão geral',
            'message' => 'Há 1 atualização.|Há :number atualizações.',
            'install_updates' => 'Instalar atualizações',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Concluído',
            'finished' => 'O banco de dados da aplicação foi atualizado com sucesso.',
            'exit' => 'Clique aqui para sair',
        ],

        'log' => [
            'success_message' => 'Laravel Installer atualizado com sucesso em ',
        ],
    ],
];

<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versão',
    'title' => 'Instalador Laravel',
    'next' => 'Próximo passo',
    'back' => 'Anterior',
    'finish' => 'Instalar',
    'forms' => [
        'errorTitle' => 'Ocorreram os seguintes erros:',
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
        'templateTitle' => 'Passo 1 | Requisitos do servidor',
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
        'templateTitle' => 'Passo 2 | Permissões',
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
            'templateTitle' => 'Passo 3 | Definições do ambiente | Assistente guiado',
            'step3_title' => 'Configurar definições do ambiente',
            'step4_title' => 'Configurar definições da base de dados',
            'step5_title' => 'Configurar definições da aplicação',
            'step6_title' => 'Configurar definições do administrador',
            'step7_title' => 'Sucesso',
            'step3_description' => 'Selecione como pretende configurar o ficheiro <code>.env</code> da aplicação.',
            'step4_description' => 'Introduza abaixo os dados de ligação à sua base de dados. Se não tiver a certeza destes dados, contacte o seu fornecedor de alojamento.',
            'step5_description' => 'Selecione como pretende configurar o ficheiro <code>.env</code> da aplicação.',
            'step6_description' => 'Introduza abaixo os dados do administrador.',
            'step7_description' => 'O W3cms foi instalado. Obrigado e desfrute da utilização.',
            'tabs' => [
                'environment' => 'Ambiente',
                'database' => 'Base de dados',
                'application' => 'Aplicação',
            ],
            'form' => [
                'name_required' => 'É obrigatório indicar um nome de ambiente.',
                'app_name_label' => 'Nome da aplicação',
                'app_name_placeholder' => 'Nome da aplicação',
                'app_environment_label' => 'Ambiente da aplicação',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Desenvolvimento',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Produção',
                'app_environment_label_other' => 'Outro',
                'app_environment_placeholder_other' => 'Introduza o seu ambiente...',
                'app_debug_label' => 'Depuração da aplicação',
                'app_debug_label_true' => 'Verdadeiro',
                'app_debug_label_false' => 'Falso',
                'app_log_level_label' => 'Nível de registo da aplicação',
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
                'asset_url_label' => 'URL dos recursos',
                'asset_url_placeholder' => 'URL dos recursos',
                'db_connection_failed' => 'Não foi possível estabelecer ligação à base de dados.',
                'db_connection_label' => 'Ligação à base de dados',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host da base de dados',
                'db_host_placeholder' => 'Host da base de dados',
                'db_port_label' => 'Porta da base de dados',
                'db_port_placeholder' => 'Porta da base de dados',
                'db_name_label' => 'Nome da base de dados',
                'db_name_placeholder' => 'Nome da base de dados',
                'db_username_label' => 'Nome de utilizador da base de dados',
                'db_username_placeholder' => 'Nome de utilizador da base de dados',
                'db_password_label' => 'Palavra-passe da base de dados',
                'db_password_placeholder' => 'Palavra-passe da base de dados',

                'app_tabs' => [
                    'more_info' => 'Mais informações',
                    'broadcasting_title' => 'Broadcasting, cache, sessão e fila',
                    'broadcasting_label' => 'Driver de Broadcasting',
                    'broadcasting_placeholder' => 'Driver de Broadcasting',
                    'cache_label' => 'Driver de cache',
                    'cache_placeholder' => 'Driver de cache',
                    'filesystem_driver_label' => 'Driver do sistema de ficheiros',
                    'filesystem_driver_placeholder' => 'Driver do sistema de ficheiros',
                    'session_label' => 'Driver de sessão',
                    'session_placeholder' => 'Driver de sessão',
                    'queue_connection_label' => 'Ligação da fila',
                    'queue_connection_placeholder' => 'Ligação da fila',
                    'redis_label' => 'Driver Redis',
                    'redis_host' => 'Host Redis',
                    'redis_password' => 'Palavra-passe Redis',
                    'redis_port' => 'Porta Redis',

                    'mail_label' => 'E-mail',
                    'mail_driver_label' => 'Driver de e-mail',
                    'mail_driver_placeholder' => 'Driver de e-mail',
                    'mail_host_label' => 'Host de e-mail',
                    'mail_host_placeholder' => 'Host de e-mail',
                    'mail_port_label' => 'Porta de e-mail',
                    'mail_port_placeholder' => 'Porta de e-mail',
                    'mail_username_label' => 'Nome de utilizador do e-mail',
                    'mail_username_placeholder' => 'Nome de utilizador do e-mail',
                    'mail_password_label' => 'Palavra-passe do e-mail',
                    'mail_password_placeholder' => 'Palavra-passe do e-mail',
                    'mail_encryption_label' => 'Encriptação de e-mail',
                    'mail_encryption_placeholder' => 'Encriptação de e-mail',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID da chave de acesso AWS',
                    'aws_access_key_placeholder' => 'ID da chave de acesso AWS',
                    'aws_secret_key_label' => 'Chave de acesso AWS',
                    'aws_secret_key_placeholder' => 'Chave de acesso AWS',
                    'aws_default_region_label' => 'Região AWS predefinida',
                    'aws_default_region_placeholder' => 'Região AWS predefinida',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Utilizar endpoint AWS em estilo de caminho',
                    'aws_endpoint_placeholder' => 'Utilizar endpoint AWS em estilo de caminho',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID da aplicação Pusher',
                    'pusher_app_id_palceholder' => 'ID da aplicação Pusher',
                    'pusher_app_key_label' => 'Chave da aplicação Pusher',
                    'pusher_app_key_palceholder' => 'Chave da aplicação Pusher',
                    'pusher_app_secret_label' => 'Segredo da aplicação Pusher',
                    'pusher_app_secret_palceholder' => 'Segredo da aplicação Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Defina o nome da aplicação.',
                    'app_environment' => 'O ambiente que pretende utilizar na aplicação.',
                    'app_debug' => 'Define a quantidade de detalhes dos erros que são apresentados ao utilizador.',
                    'app_log_level' => 'Defina o nível de registo da aplicação.',
                    'app_url' => 'Defina o URL pretendido para a aplicação.',
                    'db_connection' => 'A ligação da aplicação à base de dados.',
                    'db_host' => 'Defina o host da base de dados da aplicação.',
                    'db_port' => 'Defina a porta da base de dados da aplicação.',
                    'db_name' => 'O nome da base de dados que pretende utilizar com o W3mcs.',
                    'db_user_name' => 'O nome de utilizador da sua base de dados.',
                    'db_password' => 'A palavra-passe da sua base de dados.',
                ],
                'buttons' => [
                    'setup_database' => 'Configurar base de dados',
                    'setup_application' => 'Configurar aplicação',
                    'save' => 'Guardar',
                    'installation' => 'Executar instalação',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Passo 3 | Definições do ambiente | Editor clássico',
            'title' => 'Editor clássico do ambiente',
            'save' => 'Guardar .env',
            'back' => 'Utilizar assistente de configuração',
            'install' => 'Guardar e instalar',
        ],
        'success' => 'As definições do ficheiro .env foram guardadas.',
        'errors' => 'Não foi possível guardar o ficheiro .env. Crie-o manualmente.',
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
        'migration' => 'Saída da consola de migração e seed:',
        'console' => 'Saída da consola da aplicação:',
        'log' => 'Entrada do registo de instalação:',
        'env' => 'Ficheiro .env final:',
        'exit' => 'Clique aqui para iniciar sessão',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configuração do administrador'
        ],
        'name' => 'Nome completo',
        'name_description' => 'Introduza o nome completo do utilizador. O nome completo pode conter caracteres alfanuméricos, etc.',
        'email' => 'E-mail',
        'email_description' => 'Verifique cuidadosamente o seu endereço de e-mail antes de continuar.',
        'password' => 'Palavra-passe',
        'password_description' => 'Importante: precisará desta palavra-passe para iniciar sessão. Guarde-a num local seguro.',
        'confirm_password' => 'Confirmar palavra-passe',
        'confirm_password_description' => 'Confirme novamente a sua palavra-passe aqui.',
        'save' => 'Guardar e iniciar sessão',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Para comunicar agora com a sua base de dados, clique no botão Executar instalação.'
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
            'message' => 'Existe 1 atualização.|Existem :number atualizações.',
            'install_updates' => 'Instalar atualizações',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Concluído',
            'finished' => 'A base de dados da aplicação foi atualizada com sucesso.',
            'exit' => 'Clique aqui para sair',
        ],

        'log' => [
            'success_message' => 'Laravel Installer atualizado com sucesso em ',
        ],
    ],
];

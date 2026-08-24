<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'versión',
    'title' => 'Instalador de Laravel',
    'next' => 'Siguiente paso',
    'back' => 'Anterior',
    'finish' => 'Instalar',
    'forms' => [
        'errorTitle' => 'Se produjeron los siguientes errores:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Bienvenido',
        'title'   => 'Instalador de Laravel',
        'message' => 'Asistente sencillo de instalación y configuración.',
        'next'    => 'Comprobar requisitos',
        'choose_language'    => 'Elegir idioma',
        'verify_requirements'    => 'Verificar requisitos',
        'setup_environment'    => 'Configurar entorno',
        'configure_site'    => 'Configurar sitio',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Paso 1 | Requisitos del servidor',
        'title' => 'Requisitos y permisos del servidor',
        'next'    => 'Siguiente',
        'prev'    => 'Anterior',
        'required'    => 'obligatorio',
        'error'     => 'Compruebe los requisitos del servidor y otorgue los permisos necesarios.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Paso 2 | Permisos',
        'title' => 'Permisos',
        'next' => 'Configurar entorno',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Configurar ajustes del entorno',
            'title' => 'Configurar ajustes del entorno',
            'wizard-button' => 'Configuración mediante asistente',
            'classic-button' => 'Editor de texto clásico',
        ],
        'wizard' => [
            'templateTitle' => 'Paso 3 | Ajustes del entorno | Asistente guiado',
            'step3_title' => 'Configurar ajustes del entorno',
            'step4_title' => 'Configurar ajustes de la base de datos',
            'step5_title' => 'Configurar ajustes de la aplicación',
            'step6_title' => 'Configurar ajustes del administrador',
            'step7_title' => 'Éxito',
            'step3_description' => 'Seleccione cómo desea configurar el archivo <code>.env</code> de la aplicación.',
            'step4_description' => 'Introduzca a continuación los datos de conexión de su base de datos. Si no está seguro de estos datos, póngase en contacto con su proveedor de alojamiento.',
            'step5_description' => 'Seleccione cómo desea configurar el archivo <code>.env</code> de la aplicación.',
            'step6_description' => 'Introduzca a continuación los datos del administrador.',
            'step7_description' => 'W3cms se ha instalado correctamente. Gracias y disfrute de la aplicación.',
            'tabs' => [
                'environment' => 'Entorno',
                'database' => 'Base de datos',
                'application' => 'Aplicación',
            ],
            'form' => [
                'name_required' => 'Se requiere un nombre de entorno.',
                'app_name_label' => 'Nombre de la aplicación',
                'app_name_placeholder' => 'Nombre de la aplicación',
                'app_environment_label' => 'Entorno de la aplicación',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Desarrollo',
                'app_environment_label_qa' => 'Control de calidad',
                'app_environment_label_production' => 'Producción',
                'app_environment_label_other' => 'Otro',
                'app_environment_placeholder_other' => 'Introduzca su entorno...',
                'app_debug_label' => 'Depuración de la aplicación',
                'app_debug_label_true' => 'Verdadero',
                'app_debug_label_false' => 'Falso',
                'app_log_level_label' => 'Nivel de registro de la aplicación',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL de la aplicación',
                'app_url_placeholder' => 'URL de la aplicación',
                'asset_url_label' => 'URL de recursos',
                'asset_url_placeholder' => 'URL de recursos',
                'db_connection_failed' => 'No se pudo conectar con la base de datos.',
                'db_connection_label' => 'Conexión de base de datos',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Host de la base de datos',
                'db_host_placeholder' => 'Host de la base de datos',
                'db_port_label' => 'Puerto de la base de datos',
                'db_port_placeholder' => 'Puerto de la base de datos',
                'db_name_label' => 'Nombre de la base de datos',
                'db_name_placeholder' => 'Nombre de la base de datos',
                'db_username_label' => 'Nombre de usuario de la base de datos',
                'db_username_placeholder' => 'Nombre de usuario de la base de datos',
                'db_password_label' => 'Contraseña de la base de datos',
                'db_password_placeholder' => 'Contraseña de la base de datos',

                'app_tabs' => [
                    'more_info' => 'Más información',
                    'broadcasting_title' => 'Broadcasting, caché, sesión y cola',
                    'broadcasting_label' => 'Controlador de broadcasting',
                    'broadcasting_placeholder' => 'Controlador de broadcasting',
                    'cache_label' => 'Controlador de caché',
                    'cache_placeholder' => 'Controlador de caché',
                    'filesystem_driver_label' => 'Controlador del sistema de archivos',
                    'filesystem_driver_placeholder' => 'Controlador del sistema de archivos',
                    'session_label' => 'Controlador de sesión',
                    'session_placeholder' => 'Controlador de sesión',
                    'queue_connection_label' => 'Conexión de cola',
                    'queue_connection_placeholder' => 'Conexión de cola',
                    'redis_label' => 'Controlador de Redis',
                    'redis_host' => 'Host de Redis',
                    'redis_password' => 'Contraseña de Redis',
                    'redis_port' => 'Puerto de Redis',

                    'mail_label' => 'Correo electrónico',
                    'mail_driver_label' => 'Controlador de correo',
                    'mail_driver_placeholder' => 'Controlador de correo',
                    'mail_host_label' => 'Host de correo',
                    'mail_host_placeholder' => 'Host de correo',
                    'mail_port_label' => 'Puerto de correo',
                    'mail_port_placeholder' => 'Puerto de correo',
                    'mail_username_label' => 'Nombre de usuario del correo',
                    'mail_username_placeholder' => 'Nombre de usuario del correo',
                    'mail_password_label' => 'Contraseña del correo',
                    'mail_password_placeholder' => 'Contraseña del correo',
                    'mail_encryption_label' => 'Cifrado del correo',
                    'mail_encryption_placeholder' => 'Cifrado del correo',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'ID de clave de acceso de AWS',
                    'aws_access_key_placeholder' => 'ID de clave de acceso de AWS',
                    'aws_secret_key_label' => 'Clave de acceso de AWS',
                    'aws_secret_key_placeholder' => 'Clave de acceso de AWS',
                    'aws_default_region_label' => 'Región predeterminada de AWS',
                    'aws_default_region_placeholder' => 'Región predeterminada de AWS',
                    'aws_bucket_label' => 'Bucket de AWS',
                    'aws_bucket_placeholder' => 'Bucket de AWS',
                    'aws_endpoint_label' => 'Usar endpoint con formato de ruta de AWS',
                    'aws_endpoint_placeholder' => 'Usar endpoint con formato de ruta de AWS',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID de aplicación de Pusher',
                    'pusher_app_id_palceholder' => 'ID de aplicación de Pusher',
                    'pusher_app_key_label' => 'Clave de aplicación de Pusher',
                    'pusher_app_key_palceholder' => 'Clave de aplicación de Pusher',
                    'pusher_app_secret_label' => 'Secreto de aplicación de Pusher',
                    'pusher_app_secret_palceholder' => 'Secreto de aplicación de Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Establezca el nombre de la aplicación.',
                    'app_environment' => 'El entorno que desea utilizar en la aplicación.',
                    'app_debug' => 'Define cuántos detalles del error se muestran al usuario.',
                    'app_log_level' => 'Establezca el nivel de registro de la aplicación.',
                    'app_url' => 'Establezca la URL que desea utilizar para la aplicación.',
                    'db_connection' => 'La conexión de base de datos de la aplicación.',
                    'db_host' => 'Establezca el host de la base de datos de la aplicación.',
                    'db_port' => 'Establezca el puerto de la base de datos de la aplicación.',
                    'db_name' => 'El nombre de la base de datos que desea utilizar con W3mcs.',
                    'db_user_name' => 'Su nombre de usuario de la base de datos.',
                    'db_password' => 'Su contraseña de la base de datos.',
                ],
                'buttons' => [
                    'setup_database' => 'Configurar base de datos',
                    'setup_application' => 'Configurar aplicación',
                    'save' => 'Guardar',
                    'installation' => 'Ejecutar instalación',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Paso 3 | Ajustes del entorno | Editor clásico',
            'title' => 'Editor de entorno clásico',
            'save' => 'Guardar .env',
            'back' => 'Usar asistente de configuración',
            'install' => 'Guardar e instalar',
        ],
        'success' => 'La configuración del archivo .env se ha guardado correctamente.',
        'errors' => 'No se pudo guardar el archivo .env. Créelo manualmente.',
    ],

    'install' => 'Instalar',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Laravel Installer se instaló correctamente el ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Instalación finalizada',
        'templateTitle' => 'Instalación finalizada',
        'finished' => 'La aplicación se ha instalado correctamente.',
        'migration' => 'Salida de consola de migración y seed:',
        'console' => 'Salida de consola de la aplicación:',
        'log' => 'Entrada del registro de instalación:',
        'env' => 'Archivo .env final:',
        'exit' => 'Haga clic aquí para iniciar sesión',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configuración del administrador'
        ],
        'name' => 'Nombre completo',
        'name_description' => 'Introduzca el nombre completo del usuario. El nombre completo puede contener caracteres alfanuméricos, etc.',
        'email' => 'Correo electrónico',
        'email_description' => 'Compruebe cuidadosamente su dirección de correo electrónico antes de continuar.',
        'password' => 'Contraseña',
        'password_description' => 'Importante: necesitará esta contraseña para iniciar sesión. Guárdela en un lugar seguro.',
        'confirm_password' => 'Confirmar contraseña',
        'confirm_password_description' => 'Confirme aquí su contraseña nuevamente.',
        'save' => 'Guardar e iniciar sesión',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Para conectarse ahora con su base de datos, haga clic en el botón Ejecutar instalación.'
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
        'title' => 'Actualizador de Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Bienvenido al actualizador',
            'message' => 'Bienvenido al asistente de actualización.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Resumen',
            'message' => 'Hay 1 actualización.|Hay :number actualizaciones.',
            'install_updates' => 'Instalar actualizaciones',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finalizado',
            'finished' => 'La base de datos de la aplicación se ha actualizado correctamente.',
            'exit' => 'Haga clic aquí para salir',
        ],

        'log' => [
            'success_message' => 'Laravel Installer se actualizó correctamente el ',
        ],
    ],
];

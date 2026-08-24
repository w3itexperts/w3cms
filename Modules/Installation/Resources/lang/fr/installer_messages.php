<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'version',
    'title' => 'Installateur Laravel',
    'next' => 'Étape suivante',
    'back' => 'Étape précédente',
    'finish' => 'Installer',
    'forms' => [
        'errorTitle' => 'Les erreurs suivantes se sont produites :',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Bienvenue',
        'title'   => 'Installateur Laravel',
        'message' => 'Assistant d’installation et de configuration facile.',
        'next'    => 'Vérifier les prérequis',
        'choose_language'    => 'Choisir la langue',
        'verify_requirements'    => 'Vérifier les prérequis',
        'setup_environment'    => 'Configurer l’environnement',
        'configure_site'    => 'Configurer le site',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Étape 1 | Prérequis du serveur',
        'title' => 'Prérequis et permissions du serveur',
        'next'    => 'Suivant',
        'prev'    => 'Précédent',
        'required'    => 'requis',
        'error'     => 'Veuillez vérifier les prérequis du serveur et accorder les permissions nécessaires.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Étape 2 | Permissions',
        'title' => 'Permissions',
        'next' => 'Configurer l’environnement',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Paramètres de configuration de l’environnement',
            'title' => 'Paramètres de configuration de l’environnement',
            'wizard-button' => 'Configuration avec assistant',
            'classic-button' => 'Éditeur de texte classique',
        ],
        'wizard' => [
            'templateTitle' => 'Étape 3 | Paramètres de l’environnement | Assistant guidé',
            'step3_title' => 'Configurer les paramètres de l’environnement',
            'step4_title' => 'Configurer les paramètres de la base de données',
            'step5_title' => 'Configurer les paramètres de l’application',
            'step6_title' => 'Configurer les paramètres de l’administrateur',
            'step7_title' => 'Succès',
            'step3_description' => 'Veuillez sélectionner la manière dont vous souhaitez configurer le fichier <code>.env</code> de l’application.',
            'step4_description' => 'Veuillez saisir ci-dessous les informations de connexion à votre base de données. Si vous n’êtes pas sûr de ces informations, contactez votre hébergeur.',
            'step5_description' => 'Veuillez sélectionner la manière dont vous souhaitez configurer le fichier <code>.env</code> de l’application.',
            'step6_description' => 'Veuillez saisir ci-dessous les informations concernant l’administrateur.',
            'step7_description' => 'W3cms a été installé. Merci et profitez-en.',
            'tabs' => [
                'environment' => 'Environnement',
                'database' => 'Base de données',
                'application' => 'Application',
            ],
            'form' => [
                'name_required' => 'Un nom d’environnement est requis.',
                'app_name_label' => 'Nom de l’application',
                'app_name_placeholder' => 'Nom de l’application',
                'app_environment_label' => 'Environnement de l’application',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Développement',
                'app_environment_label_qa' => 'Test',
                'app_environment_label_production' => 'Production',
                'app_environment_label_other' => 'Autre',
                'app_environment_placeholder_other' => 'Saisissez votre environnement...',
                'app_debug_label' => 'Débogage de l’application',
                'app_debug_label_true' => 'Activé',
                'app_debug_label_false' => 'Désactivé',
                'app_log_level_label' => 'Niveau de journalisation',
                'app_log_level_label_debug' => 'débogage',
                'app_log_level_label_info' => 'information',
                'app_log_level_label_notice' => 'notification',
                'app_log_level_label_warning' => 'avertissement',
                'app_log_level_label_error' => 'erreur',
                'app_log_level_label_critical' => 'critique',
                'app_log_level_label_alert' => 'alerte',
                'app_log_level_label_emergency' => 'urgence',
                'app_url_label' => 'URL de l’application',
                'app_url_placeholder' => 'URL de l’application',
                'asset_url_label' => 'URL des ressources',
                'asset_url_placeholder' => 'URL des ressources',
                'db_connection_failed' => 'Impossible de se connecter à la base de données.',
                'db_connection_label' => 'Connexion à la base de données',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Hôte de la base de données',
                'db_host_placeholder' => 'Hôte de la base de données',
                'db_port_label' => 'Port de la base de données',
                'db_port_placeholder' => 'Port de la base de données',
                'db_name_label' => 'Nom de la base de données',
                'db_name_placeholder' => 'Nom de la base de données',
                'db_username_label' => 'Nom d’utilisateur de la base de données',
                'db_username_placeholder' => 'Nom d’utilisateur de la base de données',
                'db_password_label' => 'Mot de passe de la base de données',
                'db_password_placeholder' => 'Mot de passe de la base de données',

                'app_tabs' => [
                    'more_info' => 'Plus d’informations',
                    'broadcasting_title' => 'Diffusion, cache, session et file d’attente',
                    'broadcasting_label' => 'Pilote de diffusion',
                    'broadcasting_placeholder' => 'Pilote de diffusion',
                    'cache_label' => 'Pilote de cache',
                    'cache_placeholder' => 'Pilote de cache',
                    'filesystem_driver_label' => 'Pilote du système de fichiers',
                    'filesystem_driver_placeholder' => 'Pilote du système de fichiers',
                    'session_label' => 'Pilote de session',
                    'session_placeholder' => 'Pilote de session',
                    'queue_connection_label' => 'Connexion à la file d’attente',
                    'queue_connection_placeholder' => 'Connexion à la file d’attente',
                    'redis_label' => 'Pilote Redis',
                    'redis_host' => 'Hôte Redis',
                    'redis_password' => 'Mot de passe Redis',
                    'redis_port' => 'Port Redis',

                    'mail_label' => 'E-mail',
                    'mail_driver_label' => 'Pilote de messagerie',
                    'mail_driver_placeholder' => 'Pilote de messagerie',
                    'mail_host_label' => 'Hôte de messagerie',
                    'mail_host_placeholder' => 'Hôte de messagerie',
                    'mail_port_label' => 'Port de messagerie',
                    'mail_port_placeholder' => 'Port de messagerie',
                    'mail_username_label' => 'Nom d’utilisateur de messagerie',
                    'mail_username_placeholder' => 'Nom d’utilisateur de messagerie',
                    'mail_password_label' => 'Mot de passe de messagerie',
                    'mail_password_placeholder' => 'Mot de passe de messagerie',
                    'mail_encryption_label' => 'Chiffrement de messagerie',
                    'mail_encryption_placeholder' => 'Chiffrement de messagerie',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'Identifiant de clé d’accès AWS',
                    'aws_access_key_placeholder' => 'Identifiant de clé d’accès AWS',
                    'aws_secret_key_label' => 'Clé d’accès secrète AWS',
                    'aws_secret_key_placeholder' => 'Clé d’accès secrète AWS',
                    'aws_default_region_label' => 'Région AWS par défaut',
                    'aws_default_region_placeholder' => 'Région AWS par défaut',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Utiliser le style de chemin pour le point de terminaison AWS',
                    'aws_endpoint_placeholder' => 'Utiliser le style de chemin pour le point de terminaison AWS',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID de l’application Pusher',
                    'pusher_app_id_palceholder' => 'ID de l’application Pusher',
                    'pusher_app_key_label' => 'Clé de l’application Pusher',
                    'pusher_app_key_palceholder' => 'Clé de l’application Pusher',
                    'pusher_app_secret_label' => 'Secret de l’application Pusher',
                    'pusher_app_secret_palceholder' => 'Secret de l’application Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Définissez le nom de l’application.',
                    'app_environment' => 'L’environnement que vous souhaitez utiliser pour l’application.',
                    'app_debug' => 'Définit le niveau de détail des erreurs affichées à l’utilisateur.',
                    'app_log_level' => 'Définissez le niveau de journalisation de l’application.',
                    'app_url' => 'Définissez l’URL que vous souhaitez utiliser pour l’application.',
                    'db_connection' => 'La connexion à la base de données de l’application.',
                    'db_host' => 'Définissez l’hôte de la base de données de l’application.',
                    'db_port' => 'Définissez le port de la base de données de l’application.',
                    'db_name' => 'Le nom de la base de données que vous souhaitez utiliser avec W3cms.',
                    'db_user_name' => 'Votre nom d’utilisateur de base de données.',
                    'db_password' => 'Votre mot de passe de base de données.',
                ],
                'buttons' => [
                    'setup_database' => 'Configurer la base de données',
                    'setup_application' => 'Configurer l’application',
                    'save' => 'Enregistrer',
                    'installation' => 'Lancer l’installation',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Étape 3 | Paramètres de l’environnement | Éditeur classique',
            'title' => 'Éditeur classique de l’environnement',
            'save' => 'Enregistrer .env',
            'back' => 'Utiliser l’assistant de configuration',
            'install' => 'Enregistrer et installer',
        ],
        'success' => 'Les paramètres de votre fichier .env ont été enregistrés.',
        'errors' => 'Impossible d’enregistrer le fichier .env. Veuillez le créer manuellement.',
    ],

    'install' => 'Installer',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Installateur Laravel installé avec succès le ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installation terminée',
        'templateTitle' => 'Installation terminée',
        'finished' => 'L’application a été installée avec succès.',
        'migration' => 'Sortie de la console de migration et d’initialisation :',
        'console' => 'Sortie de la console de l’application :',
        'log' => 'Entrée du journal d’installation :',
        'env' => 'Fichier .env final :',
        'exit' => 'Cliquez ici pour vous connecter',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Configuration de l’administrateur'
        ],
        'name' => 'Nom complet',
        'name_description' => 'Saisissez le nom complet de l’utilisateur. Le nom complet peut contenir uniquement des caractères alphanumériques, etc.',
        'email' => 'E-mail',
        'email_description' => 'Vérifiez attentivement votre adresse e-mail avant de continuer.',
        'password' => 'Mot de passe',
        'password_description' => 'Important : vous aurez besoin de ce mot de passe pour vous connecter. Veuillez le conserver dans un endroit sécurisé.',
        'confirm_password' => 'Confirmer le mot de passe',
        'confirm_password_description' => 'Confirmez votre mot de passe en le saisissant à nouveau.',
        'save' => 'Enregistrer et se connecter',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Communiquez maintenant avec votre base de données en cliquant sur le bouton Lancer l’installation.'
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
        'title' => 'Mise à jour Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Bienvenue dans le programme de mise à jour',
            'message' => 'Bienvenue dans l’assistant de mise à jour.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Aperçu',
            'message' => 'Il y a 1 mise à jour.|Il y a :number mises à jour.',
            'install_updates' => 'Installer les mises à jour',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Terminé',
            'finished' => 'La base de données de l’application a été mise à jour avec succès.',
            'exit' => 'Cliquez ici pour quitter',
        ],

        'log' => [
            'success_message' => 'Installateur Laravel mis à jour avec succès le ',
        ],
    ],
];
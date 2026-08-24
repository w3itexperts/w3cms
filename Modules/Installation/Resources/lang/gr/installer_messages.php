<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'έκδοση',
    'title' => 'Πρόγραμμα εγκατάστασης Laravel',
    'next' => 'Επόμενο βήμα',
    'back' => 'Προηγούμενο',
    'finish' => 'Εγκατάσταση',
    'forms' => [
        'errorTitle' => 'Παρουσιάστηκαν τα ακόλουθα σφάλματα:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Καλώς ήρθατε',
        'title'   => 'Πρόγραμμα εγκατάστασης Laravel',
        'message' => 'Εύκολος οδηγός εγκατάστασης και ρύθμισης.',
        'next'    => 'Έλεγχος απαιτήσεων',
        'choose_language'    => 'Επιλογή γλώσσας',
        'verify_requirements'    => 'Επαλήθευση απαιτήσεων',
        'setup_environment'    => 'Ρύθμιση περιβάλλοντος',
        'configure_site'    => 'Ρύθμιση ιστότοπου',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Βήμα 1 | Απαιτήσεις διακομιστή',
        'title' => 'Απαιτήσεις και δικαιώματα διακομιστή',
        'next'    => 'Επόμενο',
        'prev'    => 'Προηγούμενο',
        'required'    => 'απαιτείται',
        'error'     => 'Παρακαλούμε ελέγξτε τις απαιτήσεις του διακομιστή και παραχωρήστε τα απαραίτητα δικαιώματα.'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Βήμα 2 | Δικαιώματα',
        'title' => 'Δικαιώματα',
        'next' => 'Ρύθμιση περιβάλλοντος',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Ρύθμιση παραμέτρων περιβάλλοντος',
            'title' => 'Ρύθμιση παραμέτρων περιβάλλοντος',
            'wizard-button' => 'Ρύθμιση μέσω οδηγού',
            'classic-button' => 'Κλασικός επεξεργαστής κειμένου',
        ],
        'wizard' => [
            'templateTitle' => 'Βήμα 3 | Ρυθμίσεις περιβάλλοντος | Οδηγός',
            'step3_title' => 'Ρύθμιση παραμέτρων περιβάλλοντος',
            'step4_title' => 'Ρύθμιση παραμέτρων βάσης δεδομένων',
            'step5_title' => 'Ρύθμιση παραμέτρων εφαρμογής',
            'step6_title' => 'Ρύθμιση παραμέτρων διαχειριστή',
            'step7_title' => 'Επιτυχία',
            'step3_description' => 'Παρακαλούμε επιλέξτε πώς θέλετε να διαμορφώσετε το αρχείο <code>.env</code> της εφαρμογής.',
            'step4_description' => 'Παρακάτω εισαγάγετε τα στοιχεία σύνδεσης της βάσης δεδομένων σας. Εάν δεν είστε σίγουροι για αυτά, επικοινωνήστε με τον πάροχο φιλοξενίας σας.',
            'step5_description' => 'Παρακαλούμε επιλέξτε πώς θέλετε να διαμορφώσετε το αρχείο <code>.env</code> της εφαρμογής.',
            'step6_description' => 'Παρακάτω εισαγάγετε τα στοιχεία του διαχειριστή.',
            'step7_description' => 'Το W3cms εγκαταστάθηκε με επιτυχία. Σας ευχαριστούμε και καλή χρήση.',
            'tabs' => [
                'environment' => 'Περιβάλλον',
                'database' => 'Βάση δεδομένων',
                'application' => 'Εφαρμογή',
            ],
            'form' => [
                'name_required' => 'Απαιτείται όνομα περιβάλλοντος.',
                'app_name_label' => 'Όνομα εφαρμογής',
                'app_name_placeholder' => 'Όνομα εφαρμογής',
                'app_environment_label' => 'Περιβάλλον εφαρμογής',
                'app_environment_label_local' => 'Τοπικό',
                'app_environment_label_developement' => 'Ανάπτυξη',
                'app_environment_label_qa' => 'Ποιοτικός έλεγχος',
                'app_environment_label_production' => 'Παραγωγή',
                'app_environment_label_other' => 'Άλλο',
                'app_environment_placeholder_other' => 'Εισαγάγετε το περιβάλλον σας...',
                'app_debug_label' => 'Αποσφαλμάτωση εφαρμογής',
                'app_debug_label_true' => 'Ενεργό',
                'app_debug_label_false' => 'Ανενεργό',
                'app_log_level_label' => 'Επίπεδο καταγραφής εφαρμογής',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL εφαρμογής',
                'app_url_placeholder' => 'URL εφαρμογής',
                'asset_url_label' => 'URL πόρων',
                'asset_url_placeholder' => 'URL πόρων',
                'db_connection_failed' => 'Δεν ήταν δυνατή η σύνδεση με τη βάση δεδομένων.',
                'db_connection_label' => 'Σύνδεση βάσης δεδομένων',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Κεντρικός υπολογιστής βάσης δεδομένων',
                'db_host_placeholder' => 'Κεντρικός υπολογιστής βάσης δεδομένων',
                'db_port_label' => 'Θύρα βάσης δεδομένων',
                'db_port_placeholder' => 'Θύρα βάσης δεδομένων',
                'db_name_label' => 'Όνομα βάσης δεδομένων',
                'db_name_placeholder' => 'Όνομα βάσης δεδομένων',
                'db_username_label' => 'Όνομα χρήστη βάσης δεδομένων',
                'db_username_placeholder' => 'Όνομα χρήστη βάσης δεδομένων',
                'db_password_label' => 'Κωδικός πρόσβασης βάσης δεδομένων',
                'db_password_placeholder' => 'Κωδικός πρόσβασης βάσης δεδομένων',

                'app_tabs' => [
                    'more_info' => 'Περισσότερες πληροφορίες',
                    'broadcasting_title' => 'Broadcasting, προσωρινή μνήμη, συνεδρία και ουρά',
                    'broadcasting_label' => 'Οδηγός Broadcasting',
                    'broadcasting_placeholder' => 'Οδηγός Broadcasting',
                    'cache_label' => 'Οδηγός προσωρινής μνήμης',
                    'cache_placeholder' => 'Οδηγός προσωρινής μνήμης',
                    'filesystem_driver_label' => 'Οδηγός συστήματος αρχείων',
                    'filesystem_driver_placeholder' => 'Οδηγός συστήματος αρχείων',
                    'session_label' => 'Οδηγός συνεδρίας',
                    'session_placeholder' => 'Οδηγός συνεδρίας',
                    'queue_connection_label' => 'Σύνδεση ουράς',
                    'queue_connection_placeholder' => 'Σύνδεση ουράς',
                    'redis_label' => 'Οδηγός Redis',
                    'redis_host' => 'Κεντρικός υπολογιστής Redis',
                    'redis_password' => 'Κωδικός πρόσβασης Redis',
                    'redis_port' => 'Θύρα Redis',

                    'mail_label' => 'Email',
                    'mail_driver_label' => 'Οδηγός email',
                    'mail_driver_placeholder' => 'Οδηγός email',
                    'mail_host_label' => 'Κεντρικός υπολογιστής email',
                    'mail_host_placeholder' => 'Κεντρικός υπολογιστής email',
                    'mail_port_label' => 'Θύρα email',
                    'mail_port_placeholder' => 'Θύρα email',
                    'mail_username_label' => 'Όνομα χρήστη email',
                    'mail_username_placeholder' => 'Όνομα χρήστη email',
                    'mail_password_label' => 'Κωδικός πρόσβασης email',
                    'mail_password_placeholder' => 'Κωδικός πρόσβασης email',
                    'mail_encryption_label' => 'Κρυπτογράφηση email',
                    'mail_encryption_placeholder' => 'Κρυπτογράφηση email',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'Αναγνωριστικό κλειδιού πρόσβασης AWS',
                    'aws_access_key_placeholder' => 'Αναγνωριστικό κλειδιού πρόσβασης AWS',
                    'aws_secret_key_label' => 'Κλειδί πρόσβασης AWS',
                    'aws_secret_key_placeholder' => 'Κλειδί πρόσβασης AWS',
                    'aws_default_region_label' => 'Προεπιλεγμένη περιοχή AWS',
                    'aws_default_region_placeholder' => 'Προεπιλεγμένη περιοχή AWS',
                    'aws_bucket_label' => 'Bucket AWS',
                    'aws_bucket_placeholder' => 'Bucket AWS',
                    'aws_endpoint_label' => 'Χρήση endpoint τύπου διαδρομής AWS',
                    'aws_endpoint_placeholder' => 'Χρήση endpoint τύπου διαδρομής AWS',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'ID εφαρμογής Pusher',
                    'pusher_app_id_palceholder' => 'ID εφαρμογής Pusher',
                    'pusher_app_key_label' => 'Κλειδί εφαρμογής Pusher',
                    'pusher_app_key_palceholder' => 'Κλειδί εφαρμογής Pusher',
                    'pusher_app_secret_label' => 'Μυστικό εφαρμογής Pusher',
                    'pusher_app_secret_palceholder' => 'Μυστικό εφαρμογής Pusher',
                ],
                'input_labels' => [
                    'app_name' => 'Ορίστε το όνομα της εφαρμογής.',
                    'app_environment' => 'Το περιβάλλον που θέλετε να χρησιμοποιήσετε στην εφαρμογή.',
                    'app_debug' => 'Καθορίζει πόσες λεπτομέρειες σφάλματος εμφανίζονται στον χρήστη.',
                    'app_log_level' => 'Ορίστε το επίπεδο καταγραφής της εφαρμογής.',
                    'app_url' => 'Ορίστε το URL που θέλετε για την εφαρμογή.',
                    'db_connection' => 'Η σύνδεση της εφαρμογής με τη βάση δεδομένων.',
                    'db_host' => 'Ορίστε τον κεντρικό υπολογιστή της βάσης δεδομένων.',
                    'db_port' => 'Ορίστε τη θύρα της βάσης δεδομένων.',
                    'db_name' => 'Το όνομα της βάσης δεδομένων που θέλετε να χρησιμοποιήσετε με το W3mcs.',
                    'db_user_name' => 'Το όνομα χρήστη της βάσης δεδομένων σας.',
                    'db_password' => 'Ο κωδικός πρόσβασης της βάσης δεδομένων σας.',
                ],
                'buttons' => [
                    'setup_database' => 'Ρύθμιση βάσης δεδομένων',
                    'setup_application' => 'Ρύθμιση εφαρμογής',
                    'save' => 'Αποθήκευση',
                    'installation' => 'Εκτέλεση εγκατάστασης',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'Βήμα 3 | Ρυθμίσεις περιβάλλοντος | Κλασικός επεξεργαστής',
            'title' => 'Κλασικός επεξεργαστής περιβάλλοντος',
            'save' => 'Αποθήκευση .env',
            'back' => 'Χρήση οδηγού',
            'install' => 'Αποθήκευση και εγκατάσταση',
        ],
        'success' => 'Οι ρυθμίσεις του αρχείου .env αποθηκεύτηκαν με επιτυχία.',
        'errors' => 'Δεν ήταν δυνατή η αποθήκευση του αρχείου .env. Παρακαλούμε δημιουργήστε το χειροκίνητα.',
    ],

    'install' => 'Εγκατάσταση',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'Το Laravel Installer εγκαταστάθηκε με επιτυχία στις ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Η εγκατάσταση ολοκληρώθηκε',
        'templateTitle' => 'Η εγκατάσταση ολοκληρώθηκε',
        'finished' => 'Η εφαρμογή εγκαταστάθηκε με επιτυχία.',
        'migration' => 'Έξοδος κονσόλας Migration & Seed:',
        'console' => 'Έξοδος κονσόλας εφαρμογής:',
        'log' => 'Καταχώριση αρχείου καταγραφής εγκατάστασης:',
        'env' => 'Τελικό αρχείο .env:',
        'exit' => 'Κάντε κλικ εδώ για να συνδεθείτε',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'Ρύθμιση διαχειριστή'
        ],
        'name' => 'Ονοματεπώνυμο',
        'name_description' => 'Εισαγάγετε το ονοματεπώνυμο του χρήστη. Το ονοματεπώνυμο μπορεί να περιέχει αλφαριθμητικούς χαρακτήρες κ.λπ.',
        'email' => 'Email',
        'email_description' => 'Ελέγξτε προσεκτικά τη διεύθυνση email σας πριν συνεχίσετε.',
        'password' => 'Κωδικός πρόσβασης',
        'password_description' => 'Σημαντικό: Θα χρειαστείτε αυτόν τον κωδικό πρόσβασης για να συνδεθείτε. Αποθηκεύστε τον σε ασφαλές μέρος.',
        'confirm_password' => 'Επιβεβαίωση κωδικού πρόσβασης',
        'confirm_password_description' => 'Επιβεβαιώστε ξανά τον κωδικό πρόσβασής σας εδώ.',
        'save' => 'Αποθήκευση και σύνδεση',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'Για να συνδεθείτε τώρα με τη βάση δεδομένων σας, κάντε κλικ στο κουμπί Εκτέλεση εγκατάστασης.'
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
        'title' => 'Ενημερωτής Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Καλώς ήρθατε στον Ενημερωτή',
            'message' => 'Καλώς ήρθατε στον οδηγό ενημέρωσης.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Επισκόπηση',
            'message' => 'Υπάρχει 1 ενημέρωση.|Υπάρχουν :number ενημερώσεις.',
            'install_updates' => 'Εγκατάσταση ενημερώσεων',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Ολοκληρώθηκε',
            'finished' => 'Η βάση δεδομένων της εφαρμογής ενημερώθηκε με επιτυχία.',
            'exit' => 'Κάντε κλικ εδώ για έξοδο',
        ],

        'log' => [
            'success_message' => 'Το Laravel Installer ενημερώθηκε με επιτυχία στις ',
        ],
    ],
];

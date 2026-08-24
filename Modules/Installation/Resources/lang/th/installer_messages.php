<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'version' => 'เวอร์ชัน',
    'title' => 'ตัวติดตั้ง Laravel',
    'next' => 'ขั้นตอนถัดไป',
    'back' => 'ก่อนหน้า',
    'finish' => 'ติดตั้ง',
    'forms' => [
        'errorTitle' => 'เกิดข้อผิดพลาดดังต่อไปนี้:',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'ยินดีต้อนรับ',
        'title'   => 'ตัวติดตั้ง Laravel',
        'message' => 'ตัวช่วยติดตั้งและตั้งค่าที่ใช้งานง่าย',
        'next'    => 'ตรวจสอบข้อกำหนด',
        'choose_language'    => 'เลือกภาษา',
        'verify_requirements'    => 'ตรวจสอบข้อกำหนด',
        'setup_environment'    => 'ตั้งค่าสภาพแวดล้อม',
        'configure_site'    => 'ตั้งค่าเว็บไซต์',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'ขั้นตอนที่ 1 | ข้อกำหนดของเซิร์ฟเวอร์',
        'title' => 'ข้อกำหนดและสิทธิ์ของเซิร์ฟเวอร์',
        'next'    => 'ถัดไป',
        'prev'    => 'ก่อนหน้า',
        'required'    => 'จำเป็น',
        'error'     => 'โปรดตรวจสอบข้อกำหนดของเซิร์ฟเวอร์และกำหนดสิทธิ์ที่จำเป็น'
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'ขั้นตอนที่ 2 | สิทธิ์',
        'title' => 'สิทธิ์',
        'next' => 'ตั้งค่าสภาพแวดล้อม',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'ตั้งค่าการกำหนดค่าสภาพแวดล้อม',
            'title' => 'ตั้งค่าการกำหนดค่าสภาพแวดล้อม',
            'wizard-button' => 'ตั้งค่าด้วยตัวช่วย',
            'classic-button' => 'ตัวแก้ไขข้อความแบบคลาสสิก',
        ],
        'wizard' => [
            'templateTitle' => 'ขั้นตอนที่ 3 | การตั้งค่าสภาพแวดล้อม | ตัวช่วยแบบมีคำแนะนำ',
            'step3_title' => 'ตั้งค่าการกำหนดค่าสภาพแวดล้อม',
            'step4_title' => 'ตั้งค่าฐานข้อมูล',
            'step5_title' => 'ตั้งค่าการกำหนดค่าแอปพลิเคชัน',
            'step6_title' => 'ตั้งค่าผู้ดูแลระบบ',
            'step7_title' => 'สำเร็จ',
            'step3_description' => 'โปรดเลือกวิธีที่คุณต้องการใช้ในการกำหนดค่าไฟล์ <code>.env</code> ของแอปพลิเคชัน',
            'step4_description' => 'กรอกรายละเอียดการเชื่อมต่อฐานข้อมูลด้านล่าง หากไม่แน่ใจ โปรดติดต่อผู้ให้บริการโฮสติ้งของคุณ',
            'step5_description' => 'โปรดเลือกวิธีที่คุณต้องการใช้ในการกำหนดค่าไฟล์ <code>.env</code> ของแอปพลิเคชัน',
            'step6_description' => 'กรอกรายละเอียดของผู้ดูแลระบบด้านล่าง',
            'step7_description' => 'ติดตั้ง W3cms เรียบร้อยแล้ว ขอบคุณและขอให้ใช้งานอย่างมีความสุข',
            'tabs' => [
                'environment' => 'สภาพแวดล้อม',
                'database' => 'ฐานข้อมูล',
                'application' => 'แอปพลิเคชัน',
            ],
            'form' => [
                'name_required' => 'จำเป็นต้องระบุชื่อสภาพแวดล้อม',
                'app_name_label' => 'ชื่อแอปพลิเคชัน',
                'app_name_placeholder' => 'ชื่อแอปพลิเคชัน',
                'app_environment_label' => 'สภาพแวดล้อมของแอปพลิเคชัน',
                'app_environment_label_local' => 'Local',
                'app_environment_label_developement' => 'Development',
                'app_environment_label_qa' => 'QA',
                'app_environment_label_production' => 'Production',
                'app_environment_label_other' => 'อื่น ๆ',
                'app_environment_placeholder_other' => 'ระบุสภาพแวดล้อมของคุณ...',
                'app_debug_label' => 'ดีบักแอปพลิเคชัน',
                'app_debug_label_true' => 'เปิด',
                'app_debug_label_false' => 'ปิด',
                'app_log_level_label' => 'ระดับ Log ของแอปพลิเคชัน',
                'app_log_level_label_debug' => 'debug',
                'app_log_level_label_info' => 'info',
                'app_log_level_label_notice' => 'notice',
                'app_log_level_label_warning' => 'warning',
                'app_log_level_label_error' => 'error',
                'app_log_level_label_critical' => 'critical',
                'app_log_level_label_alert' => 'alert',
                'app_log_level_label_emergency' => 'emergency',
                'app_url_label' => 'URL แอปพลิเคชัน',
                'app_url_placeholder' => 'URL แอปพลิเคชัน',
                'asset_url_label' => 'URL ของ Asset',
                'asset_url_placeholder' => 'URL ของ Asset',
                'db_connection_failed' => 'ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้',
                'db_connection_label' => 'การเชื่อมต่อฐานข้อมูล',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'โฮสต์ฐานข้อมูล',
                'db_host_placeholder' => 'โฮสต์ฐานข้อมูล',
                'db_port_label' => 'พอร์ตฐานข้อมูล',
                'db_port_placeholder' => 'พอร์ตฐานข้อมูล',
                'db_name_label' => 'ชื่อฐานข้อมูล',
                'db_name_placeholder' => 'ชื่อฐานข้อมูล',
                'db_username_label' => 'ชื่อผู้ใช้ฐานข้อมูล',
                'db_username_placeholder' => 'ชื่อผู้ใช้ฐานข้อมูล',
                'db_password_label' => 'รหัสผ่านฐานข้อมูล',
                'db_password_placeholder' => 'รหัสผ่านฐานข้อมูล',

                'app_tabs' => [
                    'more_info' => 'ข้อมูลเพิ่มเติม',
                    'broadcasting_title' => 'Broadcasting, Cache, Session และ Queue',
                    'broadcasting_label' => 'Broadcast Driver',
                    'broadcasting_placeholder' => 'Broadcast Driver',
                    'cache_label' => 'Cache Driver',
                    'cache_placeholder' => 'Cache Driver',
                    'filesystem_driver_label' => 'Filesystem Driver',
                    'filesystem_driver_placeholder' => 'Filesystem Driver',
                    'session_label' => 'Session Driver',
                    'session_placeholder' => 'Session Driver',
                    'queue_connection_label' => 'Queue Connection',
                    'queue_connection_placeholder' => 'Queue Connection',
                    'redis_label' => 'Redis Driver',
                    'redis_host' => 'Redis Host',
                    'redis_password' => 'Redis Password',
                    'redis_port' => 'Redis Port',

                    'mail_label' => 'อีเมล',
                    'mail_driver_label' => 'Mail Driver',
                    'mail_driver_placeholder' => 'Mail Driver',
                    'mail_host_label' => 'Mail Host',
                    'mail_host_placeholder' => 'Mail Host',
                    'mail_port_label' => 'Mail Port',
                    'mail_port_placeholder' => 'Mail Port',
                    'mail_username_label' => 'ชื่อผู้ใช้ Mail',
                    'mail_username_placeholder' => 'ชื่อผู้ใช้ Mail',
                    'mail_password_label' => 'รหัสผ่าน Mail',
                    'mail_password_placeholder' => 'รหัสผ่าน Mail',
                    'mail_encryption_label' => 'การเข้ารหัส Mail',
                    'mail_encryption_placeholder' => 'การเข้ารหัส Mail',

                    'aws_label' => 'AWS',
                    'aws_access_key_label' => 'AWS Access Key ID',
                    'aws_access_key_placeholder' => 'AWS Access Key ID',
                    'aws_secret_key_label' => 'AWS Access Key',
                    'aws_secret_key_placeholder' => 'AWS Access Key',
                    'aws_default_region_label' => 'AWS Default Region',
                    'aws_default_region_placeholder' => 'AWS Default Region',
                    'aws_bucket_label' => 'AWS Bucket',
                    'aws_bucket_placeholder' => 'AWS Bucket',
                    'aws_endpoint_label' => 'ใช้ AWS Path Style Endpoint',
                    'aws_endpoint_placeholder' => 'ใช้ AWS Path Style Endpoint',

                    'pusher_label' => 'Pusher',
                    'pusher_app_id_label' => 'Pusher App ID',
                    'pusher_app_id_palceholder' => 'Pusher App ID',
                    'pusher_app_key_label' => 'Pusher App Key',
                    'pusher_app_key_palceholder' => 'Pusher App Key',
                    'pusher_app_secret_label' => 'Pusher App Secret',
                    'pusher_app_secret_palceholder' => 'Pusher App Secret',
                ],
                'input_labels' => [
                    'app_name' => 'ตั้งชื่อแอปพลิเคชัน',
                    'app_environment' => 'สภาพแวดล้อมที่คุณต้องการใช้ในแอปพลิเคชัน',
                    'app_debug' => 'กำหนดว่าจะแสดงรายละเอียดข้อผิดพลาดให้ผู้ใช้มากน้อยเพียงใด',
                    'app_log_level' => 'ตั้งค่าระดับ Log ของแอปพลิเคชัน',
                    'app_url' => 'ตั้งค่า URL ที่ต้องการสำหรับแอปพลิเคชัน',
                    'db_connection' => 'การเชื่อมต่อฐานข้อมูลของแอปพลิเคชัน',
                    'db_host' => 'ตั้งค่า Host ฐานข้อมูลของแอปพลิเคชัน',
                    'db_port' => 'ตั้งค่า Port ฐานข้อมูลของแอปพลิเคชัน',
                    'db_name' => 'ชื่อฐานข้อมูลที่คุณต้องการใช้กับ W3mcs',
                    'db_user_name' => 'ชื่อผู้ใช้ฐานข้อมูลของคุณ',
                    'db_password' => 'รหัสผ่านฐานข้อมูลของคุณ',
                ],
                'buttons' => [
                    'setup_database' => 'ตั้งค่าฐานข้อมูล',
                    'setup_application' => 'ตั้งค่าแอปพลิเคชัน',
                    'save' => 'บันทึก',
                    'installation' => 'เรียกใช้การติดตั้ง',
                ],
            ],
        ],
        'classic' => [
            'templateTitle' => 'ขั้นตอนที่ 3 | การตั้งค่าสภาพแวดล้อม | ตัวแก้ไขแบบคลาสสิก',
            'title' => 'ตัวแก้ไขสภาพแวดล้อมแบบคลาสสิก',
            'save' => 'บันทึก .env',
            'back' => 'ใช้ตัวช่วยการตั้งค่า',
            'install' => 'บันทึกและติดตั้ง',
        ],
        'success' => 'บันทึกการตั้งค่าไฟล์ .env เรียบร้อยแล้ว',
        'errors' => 'ไม่สามารถบันทึกไฟล์ .env ได้ โปรดสร้างไฟล์ด้วยตนเอง',
    ],

    'install' => 'ติดตั้ง',

    /*
     *
     * Installed Log translations.
     *
     */
    'installed' => [
        'success_log_message' => 'ติดตั้ง Laravel Installer สำเร็จเมื่อ ',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'การติดตั้งเสร็จสมบูรณ์',
        'templateTitle' => 'การติดตั้งเสร็จสมบูรณ์',
        'finished' => 'ติดตั้งแอปพลิเคชันสำเร็จแล้ว',
        'migration' => 'ผลลัพธ์คอนโซล Migration & Seed:',
        'console' => 'ผลลัพธ์คอนโซลของแอปพลิเคชัน:',
        'log' => 'รายการบันทึกการติดตั้ง:',
        'env' => 'ไฟล์ .env สุดท้าย:',
        'exit' => 'คลิกที่นี่เพื่อเข้าสู่ระบบ',
    ],

    'admin' => [
        'wizard' => [
            'title' => 'ตั้งค่าผู้ดูแลระบบ'
        ],
        'name' => 'ชื่อเต็ม',
        'name_description' => 'กรอกชื่อเต็มของผู้ใช้ ชื่อเต็มสามารถประกอบด้วยอักขระตัวอักษรและตัวเลข เป็นต้น',
        'email' => 'อีเมล',
        'email_description' => 'ตรวจสอบที่อยู่อีเมลของคุณอีกครั้งก่อนดำเนินการต่อ',
        'password' => 'รหัสผ่าน',
        'password_description' => 'สำคัญ: คุณจะต้องใช้รหัสผ่านนี้เพื่อเข้าสู่ระบบ โปรดเก็บไว้ในที่ปลอดภัย',
        'confirm_password' => 'ยืนยันรหัสผ่าน',
        'confirm_password_description' => 'ยืนยันรหัสผ่านของคุณอีกครั้งที่นี่',
        'save' => 'บันทึกและเข้าสู่ระบบ',
    ],

    'configure_site' => [
        'setup_db' => [
            'label' => 'หากต้องการเชื่อมต่อกับฐานข้อมูลของคุณ ให้คลิกปุ่ม เรียกใช้การติดตั้ง'
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
        'title' => 'ตัวอัปเดต Laravel',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'ยินดีต้อนรับสู่ตัวอัปเดต',
            'message' => 'ยินดีต้อนรับสู่ตัวช่วยอัปเดต',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'ภาพรวม',
            'message' => 'มี 1 รายการอัปเดต|มี :number รายการอัปเดต',
            'install_updates' => 'ติดตั้งการอัปเดต',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'เสร็จสิ้น',
            'finished' => 'อัปเดตฐานข้อมูลของแอปพลิเคชันสำเร็จแล้ว',
            'exit' => 'คลิกที่นี่เพื่อออก',
        ],

        'log' => [
            'success_message' => 'อัปเดต Laravel Installer สำเร็จเมื่อ ',
        ],
    ],
];

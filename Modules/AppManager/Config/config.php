<?php

return [
    'name'              => 'AppManager',
    'slug'              => 'appmanger',
    'route_prefix'      => 'app-manager',
    'file_extension'    => array(
                            '.xls' => 'Excel',
                            '.xlt' => 'Excel',
                            '.xlm' => 'Excel',
                            '.xlsx' => 'Excel',
                            '.xlsm' => 'Excel',
                            '.xltx'  => 'Excel',
                            '.xltm'  => 'Excel',
                            '.xlsb'  => 'Excel',
                            '.xla' => 'Excel',
                            '.xlam'  => 'Excel',
                            '.xll'  => 'Excel',
                            '.xlw'  => 'Excel',

                            '.doc'  => 'Word',
                            '.dot'  => 'Word',
                            '.wbk'  => 'Word',
                            '.docx'  => 'Word',
                            '.docm'  => 'Word',
                            '.dotx'  => 'Word',
                            '.dotm'  => 'Word',
                            '.docb'  => 'Word',
                            
                            '.txt'  => 'NotePad',

                            '.jpg'  => 'Image',
                            '.jpeg'  => 'Image',
                            '.gif'  => 'Image',
                            '.png'  => 'Image',

                            '.pdf'  => 'PDF',
                        ),

    'technology_platform' => array(
        'L'     => 'Laravel',
        'PD'    => 'Python dJango',
        'C'     => 'Codeigniter',
        'CK'    => 'CakePHP'
    ),

    'type' => array(
        'A' => 'Admin Theme',
        'T' => 'Theme',
        'P' => 'Plugin'
    ),

    'status' => array(
        'D'    => 'Development Mode',
        'L'     => 'Live',
        'P'    => 'Planing Mode',
        'T'    => 'Testing Mode'
    )
];

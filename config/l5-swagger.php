<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'API Documentation - Transmission des Lois',
                'version' => '1.0.0',
                'description' => 'API for managing structures, services, users, roles, and permissions',
            ],
            'routes' => [
                'api' => 'api/v1',
            ],
        ],
    ],
    'paths' => [
        'docs' => storage_path('api-docs'),
        'docs_json' => 'api-docs.json',
        'docs_yaml' => 'api-docs.yaml',
        'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
        'annotations' => [
            base_path('app'),
            base_path('app/OpenApi'),
        ],
        'excludes' => [],
        'views' => base_path('resources/views/vendor/l5-swagger'),
        'base' => env('L5_SWAGGER_BASE_PATH', 'http://localhost:8000'),
        'swagger_ui' => 'api/documentation',
        'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
        'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => ['auth:sanctum'], // Protège l'accès à la documentation
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],
    ],
    'securityDefinitions' => [
        'securitySchemes' => [
            'sanctum' => [
                'type' => 'apiKey',
                'in' => 'header',
                'name' => 'Authorization',
                'description' => 'Enter token in format: Bearer {token}',
            ],
        ],
        'security' => [
            [
                'sanctum' => [],
            ],
        ],
    ],
    'generate_always' => env('L5_SWAGGER_GENERATE_ALWAYS', false),
    'generate_yaml_copy' => env('L5_SWAGGER_GENERATE_YAML_COPY', false),
    'proxy' => false,
    'additional_config_url' => null,
    'operations_sort' => env('L5_SWAGGER_OPERATIONS_SORT', null),
    'validator_url' => null,
    'ui' => [
        'display' => [
            'dark_mode' => env('L5_SWAGGER_UI_DARK_MODE', false),
            'doc_expansion' => env('L5_SWAGGER_UI_DOC_EXPANSION', 'none'),
            'filter' => env('L5_SWAGGER_UI_FILTERS', true),
        ],
        'authorization' => [
            'persist_authorization' => env('L5_SWAGGER_UI_PERSIST_AUTHORIZATION', false),
            'oauth2' => [
                'use_pkce_with_authorization_code_grant' => false,
            ],
        ],
    ],
    'constants' => [
        'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000'),
    ],
];

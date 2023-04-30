<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/article' => [[['_route' => 'create_article', '_controller' => 'App\\Controller\\ArticleController::createArticle'], null, ['POST' => 0, 'HEAD' => 1], null, false, false, null]],
        '/articles' => [[['_route' => 'list_articles', '_controller' => 'App\\Controller\\ArticleController::listAllArticles'], null, ['GET' => 0, 'HEAD' => 1], null, false, false, null]],
        '/active-articles' => [[['_route' => 'list_active_articles', '_controller' => 'App\\Controller\\ArticleController::listAllActiveArticles'], null, ['GET' => 0, 'HEAD' => 1], null, false, false, null]],
        '/articles-additional' => [[['_route' => 'list_articles_additional', '_controller' => 'App\\Controller\\ArticleController::listAllArticlesAdditional'], null, ['GET' => 0, 'HEAD' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/a(?'
                    .'|pi(?'
                        .'|/\\.well\\-known/genid/([^/]++)(*:46)'
                        .'|(?:/(index)(?:\\.([^/]++))?)?(*:81)'
                        .'|/(?'
                            .'|docs(?:\\.([^/]++))?(*:111)'
                            .'|contexts/([^.]+)(?:\\.(jsonld))?(*:150)'
                        .')'
                    .')'
                    .'|rticles/([^/]++)/CSV(*:180)'
                .')'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:217)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        46 => [[['_route' => 'api_genid', '_controller' => 'api_platform.action.not_exposed', '_api_respond' => 'true'], ['id'], null, null, false, true, null]],
        81 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        111 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        150 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null]],
        180 => [[['_route' => 'show_article_csv', '_controller' => 'App\\Controller\\ArticleController::showArticleCSV'], ['id'], ['GET' => 0, 'HEAD' => 1], null, false, false, null]],
        217 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

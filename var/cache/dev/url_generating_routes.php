<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    'api_genid' => [['id'], ['_controller' => 'api_platform.action.not_exposed', '_api_respond' => 'true'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/.well-known/genid']], [], [], []],
    'api_entrypoint' => [['index', '_format'], ['_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index' => 'index'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', 'index', 'index', true], ['text', '/api']], [], [], []],
    'api_doc' => [['_format'], ['_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], [], [['variable', '.', '[^/]++', '_format', true], ['text', '/api/docs']], [], [], []],
    'api_jsonld_context' => [['shortName', '_format'], ['_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName' => '[^.]+', '_format' => 'jsonld'], [['variable', '.', 'jsonld', '_format', true], ['variable', '/', '[^.]+', 'shortName', true], ['text', '/api/contexts']], [], [], []],
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    'create_article' => [[], ['_controller' => 'App\\Controller\\ArticleController::createArticle'], [], [['text', '/article']], [], [], []],
    'list_articles' => [[], ['_controller' => 'App\\Controller\\ArticleController::listAllArticles'], [], [['text', '/articles']], [], [], []],
    'list_active_articles' => [[], ['_controller' => 'App\\Controller\\ArticleController::listAllActiveArticles'], [], [['text', '/active-articles']], [], [], []],
    'show_article_csv' => [['id'], ['_controller' => 'App\\Controller\\ArticleController::showArticleCSV'], [], [['text', '/CSV'], ['variable', '/', '[^/]++', 'id', true], ['text', '/articles']], [], [], []],
    'list_articles_additional' => [[], ['_controller' => 'App\\Controller\\ArticleController::listAllArticlesAdditional'], [], [['text', '/articles-additional']], [], [], []],
];
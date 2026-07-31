<?php

// Auto-initialize SQLite database on Vercel if missing
$dbPath = '/tmp/database.sqlite';
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE={$dbPath}");
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $dbPath;
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $dbPath;

if (!file_exists($dbPath) || filesize($dbPath) === 0) {
    @touch($dbPath);
    try {
        require_once __DIR__ . '/../vendor/autoload.php';
        $app = require __DIR__ . '/../bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate:fresh', ['--force' => true]);
        $kernel->call('db:seed', ['--force' => true]);
    } catch (\Throwable $e) {
        // Ignore initialization errors
    }
}

// Forward Vercel serverless requests to public/index.php
require __DIR__ . '/../public/index.php';

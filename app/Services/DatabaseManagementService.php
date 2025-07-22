<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseManagementService
{
    private CoreDatabaseService $coreDatabaseService;
    public function __construct(CoreDatabaseService $coreDatabaseService)
    {
        $this->coreDatabaseService = $coreDatabaseService;
    }

    public function generatePassword(): string
    {
        $length = 12; // Ensure length is at least 8 for MySQL policy
        $lowercase = "abcdefghijklmnopqrstuvwxyz";
        $uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $digits = "0123456789";
        $specialChars = "!@#$%^&*()-_=+";

        // Ensure at least one character from each required set
        $password =
            $lowercase[random_int(0, strlen($lowercase) - 1)] .
            $uppercase[random_int(0, strlen($uppercase) - 1)] .
            $digits[random_int(0, strlen($digits) - 1)] .
            $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Fill the rest randomly
        $allChars = $lowercase . $uppercase . $digits . $specialChars;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle to randomize positions
        return str_shuffle($password);
    }

    public function createTenantDatabase($workSpaceName): array
    {
        $dbName = $workSpaceName;
        $username = $workSpaceName;
        $password = $this->generatePassword();
        $host = $this->createNewDatabase($dbName, $username, $password);
        return [
            'db_name' => $dbName,
            'db_username' => $username,
            'db_password' => $password,
            'db_host' => $host,
            'db_port' => '3306',
            'db_type' => 'mysql'
        ];
    }

    public function createNewDatabase2($dbName, $username, $password)
    {
        // Get core database credentials
        $coreDatabase = $this->coreDatabaseService->getActiveDatabase();
        $host = $coreDatabase->db_host;
        $rootDBCredentials = [
            'driver' => $coreDatabase->db_type,
            'host' => $host,
            'username' => $coreDatabase->db_username,
            'password' => $coreDatabase->db_password,
            'database' => $coreDatabase->db_name,
        ];

        // Connect to the root database
        Config::set('database.connections.root', $rootDBCredentials);
        Config::set('database.default', 'root');
        DB::purge('root');
        DB::reconnect('root');

        // Create the new database and user
        DB::statement("CREATE DATABASE IF NOT EXISTS $dbName");
        DB::statement("CREATE USER '$username'@'%' IDENTIFIED BY '$password'");
        DB::statement("GRANT ALL PRIVILEGES ON $dbName.* TO '$username'@'%'");

        // Reconnect to the default connection
        $databaseCredentials = [
            'driver' => env('DB_CONNECTION'),
            'host' => env('DB_HOST'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
        ];

        Config::set('database.connections.mysql', $databaseCredentials);
        Config::set('database.default', 'mysql');
        DB::purge('mysql');
        DB::reconnect('mysql');

        return $host;
    }

    public function createNewDatabase($dbName, $username, $password): string
    {
        try {
            $coreDatabase = $this->coreDatabaseService->getActiveDatabase();
            $host = $coreDatabase->db_host;
            $rootUsername = $coreDatabase->db_username;
            $rootPassword = $coreDatabase->db_password;
            $driver = $coreDatabase->db_type;

            $dsn = "$driver:host=$host";
            $pdo = new \PDO($dsn, $rootUsername, $rootPassword);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            # Step 1: Create database if not exists
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");

            # Step 2: Drop user if exists
            $pdo->exec("DROP USER IF EXISTS '$username'@'%'");

            # Step 3: Create user
            $pdo->exec("CREATE USER '$username'@'%' IDENTIFIED BY '$password'");

            # Step 4: Grant privileges
            $pdo->exec("GRANT ALL PRIVILEGES ON `$dbName`.* TO '$username'@'%'");

            # Step 5: Flush privileges
            $pdo->exec("FLUSH PRIVILEGES");

            # Close PDO connection
            $pdo = null;

            return $host;

        } catch (\PDOException $e) {
            \Log::error("Database creation failed: " . $e->getMessage());
            return '';
        }
    }

}

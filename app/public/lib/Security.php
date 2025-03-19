<?php

class Security {
    private static $instance = null;
    private $pdo;
    private $rateLimitAttempts = 5;
    private $rateLimitTimeWindow = 300; // 5 minutes

    private function __construct() {
        // Create database connection
        $host = $_ENV["DB_HOST"];
        $db = $_ENV["DB_NAME"];
        $user = $_ENV["DB_USER"];
        $pass = $_ENV["DB_PASSWORD"];
        $charset = $_ENV["DB_CHARSET"];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
        
        // Create rate limiting table if it doesn't exist
        $this->createRateLimitTable();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Security();
        }
        return self::$instance;
    }

    private function createRateLimitTable() {
        $sql = "CREATE TABLE IF NOT EXISTS rate_limits (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            action VARCHAR(50) NOT NULL,
            attempts INT DEFAULT 1,
            last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_ip_action (ip_address, action)
        )";
        $this->pdo->exec($sql);
    }

    public function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCSRFToken($token) {
        if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid CSRF token');
        }
        return true;
    }

    public function checkRateLimit($action, $ipAddress) {
        $sql = "SELECT attempts, last_attempt FROM rate_limits 
                WHERE ip_address = ? AND action = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ipAddress, $action]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $timeDiff = time() - strtotime($result['last_attempt']);
            
            // Reset if time window has passed
            if ($timeDiff > $this->rateLimitTimeWindow) {
                $this->resetRateLimit($ipAddress, $action);
                return true;
            }

            // Check if attempts exceeded
            if ($result['attempts'] >= $this->rateLimitAttempts) {
                $remainingTime = $this->rateLimitTimeWindow - $timeDiff;
                throw new Exception("Too many attempts. Please try again in " . ceil($remainingTime/60) . " minutes.");
            }

            // Increment attempts
            $this->incrementRateLimit($ipAddress, $action);
        } else {
            // First attempt
            $this->addRateLimit($ipAddress, $action);
        }

        return true;
    }

    private function addRateLimit($ipAddress, $action) {
        $sql = "INSERT INTO rate_limits (ip_address, action) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ipAddress, $action]);
    }

    private function incrementRateLimit($ipAddress, $action) {
        $sql = "UPDATE rate_limits 
                SET attempts = attempts + 1, 
                    last_attempt = CURRENT_TIMESTAMP 
                WHERE ip_address = ? AND action = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ipAddress, $action]);
    }

    private function resetRateLimit($ipAddress, $action) {
        $sql = "UPDATE rate_limits 
                SET attempts = 1, 
                    last_attempt = CURRENT_TIMESTAMP 
                WHERE ip_address = ? AND action = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ipAddress, $action]);
    }

    public function validatePasswordStrength($password) {
        // At least 8 characters
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }

        // Must contain at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception('Password must contain at least one uppercase letter');
        }

        // Must contain at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception('Password must contain at least one lowercase letter');
        }

        // Must contain at least one number
        if (!preg_match('/[0-9]/', $password)) {
            throw new Exception('Password must contain at least one number');
        }

        // Must contain at least one special character
        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
            throw new Exception('Password must contain at least one special character');
        }

        return true;
    }

    public function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
} 
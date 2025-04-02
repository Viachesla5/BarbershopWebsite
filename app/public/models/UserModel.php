<?php

require_once(__DIR__ . "/BaseModel.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // CREATE new user
    public function create($data)
    {
        $sql = "INSERT INTO users (
                    email, username, password, phone_number, address, profile_picture, is_admin
                ) VALUES (
                    :email, :username, :password, :phone_number, :address, :profile_picture, :is_admin
                )";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':phone_number' => $data['phone_number'],
            ':address' => $data['address'],
            ':profile_picture' => $data['profile_picture'] ?? null,
            ':is_admin' => $data['is_admin']
        ]);
        return self::$pdo->lastInsertId();
    }

    // READ all users
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ one user by id
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // for login
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE users 
                SET email = :email,
                    username = :username,
                    password = :password,
                    phone_number = :phone_number,
                    address = :address,
                    is_admin = :is_admin";
        
        $params = [
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':phone_number' => $data['phone_number'],
            ':address' => $data['address'],
            ':is_admin' => $data['is_admin'],
            ':id' => $id
        ];

        if (isset($data['profile_picture'])) {
            $sql .= ", profile_picture = :profile_picture";
            $params[':profile_picture'] = $data['profile_picture'];
        }

        $sql .= " WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
    
    public function updateProfilePicture($id, $filePath)
    {
        $sql = "UPDATE users 
                SET profile_picture = :profile 
                WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':profile' => $filePath,
            ':id' => $id
        ]);
        return $stmt->rowCount();
    }

}
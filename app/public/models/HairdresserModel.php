<?php

require_once(__DIR__ . "/BaseModel.php");

class HairdresserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // CREATE new hairdresser
    public function create($data)
    {
        $sql = "INSERT INTO hairdressers (email, name, password, phone_number, address, profile_picture, specialization)
                VALUES (:email, :name, :password, :phone_number, :address, :profile_picture, :specialization)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':name' => $data['name'],
            ':password' => $data['password'],  // hashed
            ':phone_number' => $data['phone_number'] ?? null,
            ':address' => $data['address'] ?? null,
            ':profile_picture' => $data['profile_picture'] ?? null,
            ':specialization' => $data['specialization'] ?? null,
        ]);
        return self::$pdo->lastInsertId();
    }

    // READ one hairdresser by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM hairdressers WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // READ all hairdressers
    public function getAll()
    {
        $sql = "SELECT * FROM hairdressers ORDER BY created_at DESC";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll();
    }

    // UPDATE hairdresser
    public function update($id, $data)
    {
        $sql = "UPDATE hairdressers
                SET email = :email,
                    name = :name,
                    phone_number = :phone_number,
                    address = :address,
                    profile_picture = :profile_picture,
                    specialization = :specialization
                WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':name' => $data['name'],
            ':phone_number' => $data['phone_number'] ?? null,
            ':address' => $data['address'] ?? null,
            ':profile_picture' => $data['profile_picture'] ?? null,
            ':specialization' => $data['specialization'] ?? null,
            ':id' => $id
        ]);
        return $stmt->rowCount();
    }

    // DELETE hairdresser
    public function delete($id)
    {
        $sql = "DELETE FROM hairdressers WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM hairdressers WHERE email = :email LIMIT 1";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(); // returns array or false if not found
    }
    // Optionally add: getByName, etc.
}
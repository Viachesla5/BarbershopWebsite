<?php

require_once(__DIR__ . "/BaseModel.php");

class AppointmentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // CREATE an appointment
    public function create($data)
    {
        $sql = "INSERT INTO appointments (user_id, hairdresser_id, appointment_date, appointment_time, status)
                VALUES (:user_id, :hairdresser_id, :appointment_date, :appointment_time, :status)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':hairdresser_id' => $data['hairdresser_id'],
            ':appointment_date' => $data['appointment_date'],
            ':appointment_time' => $data['appointment_time'],
            ':status' => $data['status'] ?? 'upcoming'
        ]);
        return self::$pdo->lastInsertId();
    }

    // NEW: Check if a given hairdresser/date/time is already booked
    // Returns the appointment row if taken, or false if free
    public function findByHairdresserDateTime($hairdresserId, $date, $time)
    {
        $sql = "SELECT * FROM appointments
                WHERE hairdresser_id = :hairdresser_id
                  AND appointment_date = :appointment_date
                  AND appointment_time = :appointment_time
                LIMIT 1";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':hairdresser_id' => $hairdresserId,
            ':appointment_date' => $date,
            ':appointment_time' => $time,
        ]);
        return $stmt->fetch(); // false if no row found
    }

    // READ an appointment by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM appointments WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // READ all appointments (optionally filtered by user or hairdresser)
    public function getAll($filters = [])
    {
        $sql = "SELECT * FROM appointments";
        $where = [];
        $params = [];

        if (isset($filters['user_id'])) {
            $where[] = "user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }
        if (isset($filters['hairdresser_id'])) {
            $where[] = "hairdresser_id = :hairdresser_id";
            $params[':hairdresser_id'] = $filters['hairdresser_id'];
        }
        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY appointment_date ASC, appointment_time ASC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // UPDATE an appointment
    public function update($id, $data)
    {
        $sql = "UPDATE appointments
                SET user_id = :user_id,
                    hairdresser_id = :hairdresser_id,
                    appointment_date = :appointment_date,
                    appointment_time = :appointment_time,
                    status = :status
                WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':hairdresser_id' => $data['hairdresser_id'],
            ':appointment_date' => $data['appointment_date'],
            ':appointment_time' => $data['appointment_time'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
        return $stmt->rowCount();
    }

    // DELETE an appointment
    public function delete($id)
    {
        $sql = "DELETE FROM appointments WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
}
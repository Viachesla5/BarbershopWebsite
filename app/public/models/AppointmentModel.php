<?php

require_once(__DIR__ . "/BaseModel.php");

class AppointmentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * CREATE an appointment.
     */
    public function create($data)
    {
        $sql = "INSERT INTO appointments (user_id, hairdresser_id, appointment_date, appointment_time, status)
                VALUES (:user_id, :hairdresser_id, :appointment_date, :appointment_time, :status)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':user_id'        => $data['user_id'],
            ':hairdresser_id' => $data['hairdresser_id'],
            ':appointment_date' => $data['appointment_date'],
            ':appointment_time' => $data['appointment_time'],
            ':status'         => $data['status'] ?? 'upcoming'
        ]);
        return self::$pdo->lastInsertId();
    }

    /**
     *  findByHairdresserDateTime
     *  Now checks for any appointment that starts +/- 30 minutes from the requested time.
     */
    public function findByHairdresserDateTime($hairdresserId, $date, $time)
    {
        // We'll parse $time into a MySQL-compatible time, then build a 30-min window
        // e.g., if time = "07:00:00", disallow from 06:31:00 to 07:29:00
        // For time calculations, we can rely on MySQL or do it in PHP. We'll do it in SQL for clarity.

        // We want any appointment that overlaps in the 30 minute window:
        // Let's define a range: [time - 29 minutes, time + 29 minutes]
        // We'll assume times are HH:MM:SS format. We'll use MySQL's ADDTIME/SUBTIME or TIMESTAMPDIFF.

        // Construct a query to find any appointment with the same date & hairdresser
        // and the appointment_time is within 30 minutes of $time.
        // This means: (ABS(TIMESTAMPDIFF(MINUTE, appointment_time, :time)) < 30)
        // so if the difference in minutes is < 30, there's a conflict.

        $sql = "SELECT * FROM appointments
            WHERE hairdresser_id = :hairdresser_id
              AND appointment_date = :appointment_date
              AND appointment_time BETWEEN SUBTIME(:time, '00:29:59') 
                                      AND ADDTIME(:time, '00:29:59')
            LIMIT 1";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([
            ':hairdresser_id'   => $hairdresserId,
            ':appointment_date' => $date,
            ':time'             => $time,
        ]);
        return $stmt->fetch(); // false if no row found
    }

    /**
     *  READ an appointment by ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM appointments WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     *  READ all appointments (optionally filtered by user or hairdresser).
     */
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

    /**
     *  NEW: getAllWithNames
     *  Join users & hairdressers to get user_name and hairdresser_name.
     *  For user-friendly FullCalendar event titles, etc.
     */
    public function getAllWithNames()
    {
        // We'll assume you have `users` table with 'username' or 'name' fields,
        // and `hairdressers` table with a 'name' field.
        // Example:
        //   appointments (user_id, hairdresser_id, appointment_date, appointment_time...)
        //   users        (id, username, ...)
        //   hairdressers (id, name, ...)

        $sql = "SELECT 
                    a.*,
                    u.username AS user_name,
                    h.name AS hairdresser_name
                FROM appointments a
                JOIN users u ON a.user_id = u.id
                JOIN hairdressers h ON a.hairdresser_id = h.id
                ORDER BY a.appointment_date ASC, a.appointment_time ASC";

        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * UPDATE an appointment
     */
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
            ':user_id'        => $data['user_id'],
            ':hairdresser_id' => $data['hairdresser_id'],
            ':appointment_date' => $data['appointment_date'],
            ':appointment_time' => $data['appointment_time'],
            ':status'         => $data['status'],
            ':id'             => $id
        ]);
        return $stmt->rowCount();
    }

    /**
     * DELETE an appointment
     */
    public function delete($id)
    {
        $sql = "DELETE FROM appointments WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
}
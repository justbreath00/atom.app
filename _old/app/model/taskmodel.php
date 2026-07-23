<?php
require_once __DIR__ . '/../../config/connect.php';

class TaskModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    /**
     * Get tasks for calendar grid — user must be a member of the class
     * Returns day => [tasks] map
     */
    public function getEventsByMonth(int $userId, int $year, int $month): array
    {
        $query = '
            SELECT
                ct.id,
                ct.title,
                ct.task_type,
                ct.priority,
                ct.deadline,
                s.subject_title AS subject_name,
                s.subject_code
            FROM class_tasks ct
            INNER JOIN class_members cm ON cm.class_id = ct.class_id
            INNER JOIN subjects s       ON s.id = ct.subject_id
            WHERE cm.user_id = :user_id
              AND ct.deadline IS NOT NULL
              AND YEAR(ct.deadline)  = :year
              AND MONTH(ct.deadline) = :month
            ORDER BY ct.deadline ASC
        ';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':year',    $year,   PDO::PARAM_INT);
        $stmt->bindValue(':month',   $month,  PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $t) {
            $day       = (int) date('j', strtotime($t['deadline']));
            $map[$day][] = [
                'id'       => (int) $t['id'],
                'title'    => $t['title'],
                'type'     => $t['task_type'],
                'priority' => $t['priority'],
                'time'     => date('H:i', strtotime($t['deadline'])),
                'subject'  => $t['subject_name'],
            ];
        }

        return $map;
    }

    /**
     * Upcoming tasks within N days for sidebar list
     * Color is derived from priority since subjects has no color_hex
     */
    public function getUpcomingTasks(int $userId, int $days = 7): array
    {
        $query = '
            SELECT
                ct.id,
                ct.title,
                ct.priority,
                ct.deadline,
                ct.task_type,
                s.subject_title AS subject_name
            FROM class_tasks ct
            INNER JOIN class_members cm ON cm.class_id = ct.class_id
            INNER JOIN subjects s       ON s.id = ct.subject_id
            WHERE cm.user_id = :user_id
              AND ct.deadline IS NOT NULL
              AND ct.deadline BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL :days DAY)
            ORDER BY ct.deadline ASC
            LIMIT 10
        ';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':days',    $days,   PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $priority_colors = [
            'high'   => '#EF4444',
            'medium' => '#4F46E5',
            'low'    => '#3B82F6',
        ];

        return array_map(function ($t) use ($priority_colors) {
            $ts = strtotime($t['deadline']);
            return [
                'id'         => (int) $t['id'],
                'title'      => $t['title'],
                'subject'    => $t['subject_name'],
                'color'      => $priority_colors[$t['priority']] ?? '#4F46E5',
                'day_label'  => date('D', $ts),
                'date_label' => date('M j', $ts),
                'time'       => date('H:i', $ts),
                'priority'   => $t['priority'],
            ];
        }, $rows);
    }
}
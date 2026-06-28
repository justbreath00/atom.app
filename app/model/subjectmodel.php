<?php 

require_once  '../config/connect.php';


class SubjectModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSubjectsByYearAndSemester(string $year, string $semester): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, subject_code, subject_title, unit
            FROM subjects
            WHERE year = :year
            AND semester = :semester
            ORDER BY id
        ");

        $stmt->execute([
            ':year' => $year,
            ':semester' => $semester
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
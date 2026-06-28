<?php

require_once '../config/connect.php';

class ClassModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ─────────────────────────────────────────
    // Generate class code
    // Format: BSIT-3.1A-2026
    // ─────────────────────────────────────────
    private function generateClassCode(
        string $courseCode,
        string $year,
        string $semester,
        string $block
    ): string {
        $yearMap = [
            'first year'  => '1',
            'second year' => '2',
            'third year'  => '3',
            'fourth year' => '4',
        ];

        $semMap = [
            'first semester'  => '1',
            'second semester' => '2',
        ];

        $yearNum  = $yearMap[strtolower($year)]    ?? '1';
        $semNum   = $semMap[strtolower($semester)] ?? '1';
        $blockUp  = strtoupper(trim($block));
        $currentYear = date('Y');

        return "{$courseCode}-{$yearNum}.{$semNum}{$blockUp}-{$currentYear}";
    }

    // ─────────────────────────────────────────
    // Ensure code is unique
    // ─────────────────────────────────────────
    private function codeExists(string $code): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM classes WHERE class_code = :code LIMIT 1"
        );
        $stmt->execute([':code' => $code]);
        return (bool) $stmt->fetch();
    }

    // ─────────────────────────────────────────
    // Create block + add creator as admin
    // Returns ['id', 'class_code']
    // ─────────────────────────────────────────
    public function createBlock(
        int    $creatorId,
        string $courseCode,
        string $block,
        string $year,
        string $semester
    ): array {
        $code = $this->generateClassCode($courseCode, $year, $semester, $block);

        if ($this->codeExists($code)) {
            throw new RuntimeException("Block {$code} already exists. A block with these details was already created this year.");
        }

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO classes (class_code, block, year, semester)
                VALUES (:class_code, :block, :year, :semester)
            ");
            $stmt->execute([
                ':class_code' => $code,
                ':block'      => strtoupper(trim($block)),
                ':year'       => strtolower($year),
                ':semester'   => strtolower($semester),
            ]);

            $classId = (int) $this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare("
                INSERT INTO class_members (class_id, user_id, role)
                VALUES (:class_id, :user_id, 'admin')
            ");
            $stmt->execute([
                ':class_id' => $classId,
                ':user_id'  => $creatorId,
            ]);

            $this->pdo->commit();

            return [
                'id'         => $classId,
                'class_code' => $code,
            ];

        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // ─────────────────────────────────────────
    // Get block by id
    // ─────────────────────────────────────────
    public function getBlockById(int $classId): array|false
    {
        $stmt = $this->pdo->prepare("
            SELECT id, class_code, block, year, semester, created_at
            FROM classes
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $classId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      // ─────────────────────────────────────────
    // Find class by code
    // ─────────────────────────────────────────
    public function getClassByCode(string $code): array|false
    {
        $stmt = $this->pdo->prepare("
            SELECT id, class_code, block, year, semester
            FROM classes
            WHERE class_code = :code
            LIMIT 1
        ");
        $stmt->execute([':code' => strtoupper(trim($code))]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    // ─────────────────────────────────────────
    // Check if user is already a member
    // ─────────────────────────────────────────
    public function isMember(int $classId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT id FROM class_members
            WHERE class_id = :class_id AND user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute([':class_id' => $classId, ':user_id' => $userId]);
        return (bool) $stmt->fetch();
    }
 
    // ─────────────────────────────────────────
    // Check existing request status
    // ─────────────────────────────────────────
    public function getRequestStatus(int $classId, int $userId): string|false
    {
        $stmt = $this->pdo->prepare("
            SELECT status FROM request_status
            WHERE class_id = :class_id AND user_id = :user_id
            LIMIT 1
        ");
        $stmt->execute([':class_id' => $classId, ':user_id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['status'] : false;
    }
 
    // ─────────────────────────────────────────
    // Submit join request
    // ─────────────────────────────────────────
    public function submitRequest(int $classId, int $userId): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO request_status (class_id, user_id, status)
            VALUES (:class_id, :user_id, 'pending')
        ");
        $stmt->execute([':class_id' => $classId, ':user_id' => $userId]);
    }
}
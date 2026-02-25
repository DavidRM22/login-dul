<?php
require_once MODEL_PATH . '/Database.php';

class AuditModel {

    public function log($type, $userId, $email, $details = null) {

        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO audit_logs
            (event_type, user_id, email, ip_address, user_agent, details)
            VALUES
            (:type, :user_id, :email, :ip, :agent, :details)
        ");

        $stmt->execute([
            ':type' => $type,
            ':user_id' => $userId,
            ':email' => $email,
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
            ':agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'N/A',
            ':details' => $details ? json_encode($details) : null
        ]);
    }
}
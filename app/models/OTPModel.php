<?php

require_once MODEL_PATH . '/Database.php';

class OTPModel {

    public function createOTP($userId, $otp)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO otps (user_id, code_hash, expires_at, used)
            VALUES (:user_id, :code_hash, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 0)
        ");

        return $stmt->execute([
            ':user_id'   => $userId,
            ':code_hash' => password_hash($otp, PASSWORD_DEFAULT)
        ]);
    }

    public function verifyOTP($userId, $otp)
{
    $db = Database::connect();

    $stmt = $db->prepare("
        SELECT * FROM otps
        WHERE user_id = :user_id
        AND used = 0
        AND expires_at >= NOW()
        ORDER BY id DESC
        LIMIT 1
    ");

    $stmt->execute([
        ':user_id' => $userId
    ]);

    $otpRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$otpRow) {
        return false;
    }

    // Verificar hash
    if (!password_verify($otp, $otpRow['code_hash'])) {
        return false;
    }

    // Marcar como usado
    $update = $db->prepare("
        UPDATE otps
        SET used = 1
        WHERE id = :id
    ");

    $update->execute([
        ':id' => $otpRow['id']
    ]);

    return true;
}
}
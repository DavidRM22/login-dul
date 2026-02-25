<?php
require_once MODEL_PATH . '/Database.php';

class UserModel {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * 🔥 Crear nuevo usuario
     */
    public function create($nombre, $apellido, $email, $password)
    {
        // Hashear contraseña SIEMPRE
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Unimos nombre y apellido (porque tu tabla solo tiene "name")
        $nameCompleto = trim($nombre . ' ' . $apellido);

        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password, is_verified, created_at)
            VALUES (:name, :email, :password, 0, NOW())
        ");

        return $stmt->execute([
            ':name'     => $nameCompleto,
            ':email'    => $email,
            ':password' => $passwordHash
        ]);
    }

    /**
     * 🔥 Buscar usuario por email
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE email = :email 
            LIMIT 1
        ");

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 🔥 Buscar usuario por ID
     */
    public function findById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    /**
     * 🔥 Verificar usuario (cuando OTP es correcto)
     */
    public function verifyUser($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET is_verified = 1 
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $userId
        ]);
    }

    /**
     * 🔥 Validar contraseña (login)
     */
    public function verifyPassword($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    /**
     * 🔥 Actualizar contraseña
     */
    public function updatePassword($userId, $newPassword)
    {
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            UPDATE users
            SET password = :password
            WHERE id = :id
        ");

        return $stmt->execute([
            ':password' => $newHash,
            ':id'       => $userId
        ]);
    }
}
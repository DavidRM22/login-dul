<?php

require_once MODEL_PATH . '/UserModel.php';
require_once MODEL_PATH . '/AuditModel.php';

class DashboardController
{
    public function index()
    {
        authRequired();

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            redirect(BASE_URL . '/index.php?controller=auth&action=login');
        }

        $userModel = new UserModel();
        $user = $userModel->findById($userId);

        if (!$user) {
            session_unset();
            session_destroy();
            redirect(BASE_URL . '/index.php?controller=auth&action=login');
        }

        // 🔥 RUTA CORREGIDA
        require VIEW_PATH . '/auth/dashboard.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        redirect(BASE_URL . '/index.php?controller=auth&action=login');
    }

    public function audit()
    {
        authRequired();

        $auditModel = new AuditModel();
        $logs = $auditModel->getAllLogs();

        // 🔥 RUTA CORREGIDA
        require VIEW_PATH . '/auth/audit.php';
    }
}
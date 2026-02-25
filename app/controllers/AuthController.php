<?php

require_once MODEL_PATH . '/UserModel.php';
require_once MODEL_PATH . '/OTPModel.php';

class AuthController {

    private $userModel;
    private $otpModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // 🔥 MUY IMPORTANTE
        }

        $this->userModel = new UserModel();
        $this->otpModel  = new OTPModel();
    }

    /* =========================
       LOGIN (GET + POST)
    ========================== */
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                echo "Correo o contraseña incorrectos";
                return;
            }

            // 🔥 Generar OTP UNA sola vez
            $otp = rand(100000, 999999);

$this->otpModel->createOTP($user['id'], $otp);

$_SESSION['otp_user_id'] = $user['id'];
$_SESSION['otp_email']   = $user['email'];

sendOTPEmail($user['email'], $otp); 

            redirect(BASE_URL . '/index.php?controller=auth&action=verify');
        }

        require VIEW_PATH . '/auth/login.php';
    }

    /* =========================
       REGISTRO (GET + POST)
    ========================== */
    public function register()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre   = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new UserModel();

        // Verificar si ya existe
        if ($userModel->findByEmail($email)) {
            $error = "El correo ya está registrado";
            require VIEW_PATH . '/auth/register.php';
            return;
        }

        // 🔥 AQUÍ ESTABA EL ERROR
        $userModel->create($nombre, $apellido, $email, $password);

        redirect(BASE_URL . '/index.php?controller=auth&action=login');
    }

    require VIEW_PATH . '/auth/register.php';
}
    /* =========================
       MOSTRAR VISTA VERIFY
    ========================== */
    public function verify() {

        if (!isset($_SESSION['otp_user_id'])) {
            redirect(BASE_URL . '/index.php?controller=auth&action=login');
        }

        require VIEW_PATH . '/auth/verify.php';
    }

    /* =========================
       VALIDAR OTP
    ========================== */
    public function doVerify()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(BASE_URL . '/index.php?controller=auth&action=login');
        }

        if (!isset($_SESSION['otp_user_id'])) {
            redirect(BASE_URL . '/index.php?controller=auth&action=login');
        }

        $otp = trim($_POST['otp'] ?? '');

        if (strlen($otp) !== 6 || !ctype_digit($otp)) {
            echo "Código incorrecto o expirado";
            return;
        }

        $userId = $_SESSION['otp_user_id'];

        $valid = $this->otpModel->verifyOTP($userId, $otp);

        if (!$valid) {
            echo "Código incorrecto o expirado";
            return;
        }

        // 🔥 Crear sesión real
        $_SESSION['user_id'] = $userId;

        // Limpiar sesión OTP
        unset($_SESSION['otp_user_id']);
        unset($_SESSION['otp_email']);

        header("Location: " . BASE_URL . '/index.php?controller=dashboard&action=index');
        exit;
    }

    /* =========================
       LOGOUT
    ========================== */
    public function logout() {

        session_unset();
        session_destroy();

        redirect(BASE_URL . '/index.php?controller=auth&action=login');
    }
}
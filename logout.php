<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils/getConnection.php';
require_once __DIR__ . '/utils/generaterandom.php';
require_once __DIR__ . '/src/Session.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function delete_session_id(){
    $connection = getConnection();
    $jwt = $_COOKIE['X-PZN-SESSION'];
    try {
        $payload = JWT::decode($jwt, new Key(SessionManager::$SECRET_KEY, 'HS256'));
        $sql = "DELETE FROM sessions_id WHERE session_id = ?";
        $statement = $connection->prepare($sql);
        $statement->execute([$payload->session_id]);
        setcookie('X-PZN-SESSION', 'LOGOUT');
        // Dengan memberikan nilai 'LOGOUT' pada cookie, Anda memberikan tanda bahwa pengguna telah logout dari sesi.
        $connection = null;
        header('Location: /login.php');
    } catch (Exception $exception) {
        throw new Exception("User is not login");
    }
}
delete_session_id();


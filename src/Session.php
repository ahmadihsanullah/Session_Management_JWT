<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Session
{

    public function __construct(public string $username, public string $role)
    {
    }

}

class SessionManager
{

    public static string $SECRET_KEY = "fjnljaicnuwe8nuwvo8nfulvieufksvfukenkfnelvnuf";

    public static function login(string $username, string $password): bool
    {
        if ($username == "eko" && $password == "eko") {

            $payload = [
                "username" => $username,
                "role" => "customer"
            ];
            //membuat jwt token
            $jwt = JWT::encode($payload, SessionManager::$SECRET_KEY, 'HS256');
            //simpan jwt token di cookie (browser client)
            setcookie("X-PZN-SESSION", $jwt, time() + 3600 , '/','', false,true );

            /**
             * nama_cookie: Nama untuk cookie yang ingin Anda buat.
             * nilai_cookie: Nilai yang ingin Anda tetapkan untuk cookie tersebut.
             * time() + 3600: Waktu kedaluwarsa cookie dalam detik. Dalam contoh ini, cookie akan kedaluwarsa setelah satu jam (3600 detik) dari saat ini.
             * '/': Jalur di situs web Anda di mana cookie akan tersedia. Dalam contoh ini, cookie akan tersedia di seluruh situs.
             * '': Domain di mana cookie akan tersedia. Dalam contoh ini, cookie akan tersedia di domain yang sama dengan skrip PHP yang sedang dijalankan.
             * false: Jika diatur sebagai true, maka cookie hanya dapat diakses melalui protokol HTTPS. Dalam contoh ini, kami mengaturnya sebagai false agar cookie dapat diakses melalui protokol HTTP dan HTTPS.
             * true: Jika diatur sebagai true, maka cookie akan ditandai sebagai HttpOnly, yang berarti cookie tidak dapat diakses melalui JavaScript di sisi klien. Dalam contoh ini, kami mengaturnya sebagai true untuk membuat cookie HttpOnly.
             */

            return true;
        } else {
            return false;
        }
    }

    public static function getCurrentSession(): Session
    {
        if($_COOKIE['X-PZN-SESSION']){
            $jwt = $_COOKIE['X-PZN-SESSION'];
            try {
                $payload = JWT::decode($jwt, new Key(SessionManager::$SECRET_KEY, 'HS256'));
                return new Session(username: $payload->username, role: $payload->role);
            }catch (Exception $exception){
                throw new Exception("User is not login");
            }
        }else{
            throw new Exception("User is not login");
        }
    }

}
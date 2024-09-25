<?php
namespace Models\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;

class JWTModel
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateToken($userId, $expirationTime = 3600)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + $expirationTime;

        $payload = array(
            'user_id' => $userId,
            'iat' => $issuedAt,
            'exp' => $expirationTime
        );

        $token = JWT::encode($payload, $this->secretKey, 'HS256');
        return $token;
    }

public function verifyToken($token)
{
    try {
        $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
        return $decoded;
    } catch (BeforeValidException | ExpiredException | SignatureInvalidException $e) {
        // El token es inválido o ha expirado, manejar el error adecuadamente
        return null;
    }
}

    
    
}


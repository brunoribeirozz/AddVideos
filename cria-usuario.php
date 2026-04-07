<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$email = $argv[1];
$password = $argv[2];
$hash = password_hash($password, PASSWORD_ARGON2ID);
///qualquer senha que tenha no hash, fica irreconhecivel, de forma que fique seguro para armazenar os dados do usuario //

$sql = "INSERT INTO users (email, password) VALUES (?, ?);";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(1, $email);
$stmt->bindValue(2, $hash);
$stmt->execute();

<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:" . $dbPath);


$pdo->exec('CREATE TABLE IF NOT EXISTS videos (
    id INTEGER PRIMARY KEY, 
    url TEXT, 
    title TEXT, 
    image_path TEXT
);');


$pdo->exec('CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY, 
    email TEXT, 
    password TEXT
);');


$hash = password_hash('123456', PASSWORD_ARGON2ID);
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, 'bruno@alura.com.br');
$statement->bindValue(2, $hash);


$count = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
if ($count == 0) {
    $statement->execute();
    echo "Usuário padrão criado! ";
}

echo "Banco de dados configurado com sucesso!";

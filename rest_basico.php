<?php

require 'database.php';

// Rota para buscar todos os contatos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_GET)) {
    try {
        $stmt = $conn->query('SELECT * FROM contato');
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($tasks);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Rota para adicionar um novo contato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['nome'])) {
        echo json_encode(['error' => 'O Nome do contato é obrigatório']);
        exit;
    }
    if (empty($data['telefone'])) {
        echo json_encode(['error' => 'O Telefone do contato é obrigatório']);
        exit;
    }
    if (empty($data['email'])) {
        echo json_encode(['error' => 'O E-mail do contato é obrigatório']);
        exit;
    }
    if (empty($data['datanasc'])) {
        echo json_encode(['error' => 'A Data de Nascimento do contato é obrigatório']);
        exit;
    }

    $nome = $data['nome'];
    $telefone = $data['telefone'];
    $email = $data['email'];

    // resolver a conversão de data
    $datanasc = $data['datanasc'];

    echo ($mysqldate);

    try {
        $stmt = $conn->prepare('INSERT INTO contato (nome, telefone, email) VALUES (:nome, :telefone, :email)');
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
      
        $stmt->execute();
        $taskId = $conn->lastInsertId();
        echo json_encode(['id' => $taskId, 'nome' => $nome, 'telefone' => $telefone, 'email' => $email]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Rota para marcar uma tarefa como concluída
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        echo json_encode(['error' => 'O ID do contato é obrigatório']);
        exit;
    }

    $id = $data['id'];
    $nome = $data['nome'];
    $telefone = $data['telefone'];
    $email = $data['email'];

    //resolver a conversão de data
    $datanasc = $data['datanasc'];

    try {
        $stmt = $conn->prepare('UPDATE contato SET nome= :nome, telefone= :telefone, email= :email WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Rota para deletar uma tarefa
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        echo json_encode(['error' => 'O ID do contato é obrigatório']);
        exit;
    }

    $id = $data['id'];

    try {
        $stmt = $conn->prepare('DELETE FROM contato WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

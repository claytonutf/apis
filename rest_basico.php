<?php

require 'database.php';

// Rota para buscar todos os contatos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if(empty($_GET)){
        try {
            $stmt = $conn->query('SELECT * FROM contato');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }else{
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $stmt = $conn->query('SELECT * FROM contato WHERE id='.$data['id']);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
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
    $datanasc = $data['datanasc'];

    echo ($mysqldate);

    try {
        $stmt = $conn->prepare('INSERT INTO contato (nome, telefone, email, datanasc) VALUES (:nome, :telefone, :email, :datanasc)');
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':datanasc', $datanasc);
      
        $stmt->execute();
        $taskId = $conn->lastInsertId();
        echo json_encode(['id' => $taskId, 'nome' => $nome, 'telefone' => $telefone, 'email' => $email, 'datanasc' => $datanasc]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Rota para atualizar um contato
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        echo json_encode(['error' => 'O ID do contato é obrigatório']);
        exit;
    }

    // tratar campos nulos
    $id = $data['id'];
    $nome = $data['nome'];
    $telefone = $data['telefone'];
    $email = $data['email'];
    $datanasc = $data['datanasc'];

    try {
        $stmt = $conn->prepare('UPDATE contato SET nome= :nome, telefone= :telefone, email= :email, datanasc= :datanasc WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':datanasc', $datanasc);

        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Rota para deletar um contato
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

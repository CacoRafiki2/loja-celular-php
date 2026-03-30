<?php
// backend/api_clientes.php
header('Content-Type: application/json');
include 'conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// 1. CADASTRAR
if ($acao == 'cadastrar') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO clientes (nome, cpf, telefone, endereco) VALUES ('$nome', '$cpf', '$telefone', '$endereco')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Cliente cadastrado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 2. LISTAR
elseif ($acao == 'listar') {
    $sql = "SELECT * FROM clientes";
    $resultado = $conn->query($sql);
    $clientes = [];

    if ($resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $clientes[] = $linha;
        }
    }
    echo json_encode($clientes);
}

// 3. EDITAR (ATUALIZAR)
elseif ($acao == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $sql = "UPDATE clientes SET nome='$nome', cpf='$cpf', telefone='$telefone', endereco='$endereco' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Cliente atualizado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 4. EXCLUIR
elseif ($acao == 'excluir') {
    $id = $_POST['id'];

    $sql = "DELETE FROM clientes WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Cliente excluído com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}
?>
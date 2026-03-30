<?php
// backend/api_servicos.php
header('Content-Type: application/json');
include 'conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// 1. CADASTRAR SERVIÇO
if ($acao == 'cadastrar') {
    $descricao = $_POST['descricao'];
    $preco_base = $_POST['preco_base'];

    $sql = "INSERT INTO servicos (descricao, preco_base) VALUES ('$descricao', '$preco_base')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Serviço registado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 2. LISTAR SERVIÇOS
elseif ($acao == 'listar') {
    $sql = "SELECT * FROM servicos";
    $resultado = $conn->query($sql);
    $servicos = [];

    if ($resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $servicos[] = $linha;
        }
    }
    echo json_encode($servicos);
}

// 3. EDITAR SERVIÇO
elseif ($acao == 'editar') {
    $id = $_POST['id'];
    $descricao = $_POST['descricao'];
    $preco_base = $_POST['preco_base'];

    $sql = "UPDATE servicos SET descricao='$descricao', preco_base='$preco_base' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Serviço atualizado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 4. EXCLUIR SERVIÇO
elseif ($acao == 'excluir') {
    $id = $_POST['id'];

    $sql = "DELETE FROM servicos WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Serviço excluído com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}
?>
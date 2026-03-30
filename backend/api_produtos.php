<?php
// backend/api_produtos.php
header('Content-Type: application/json');
include 'conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// 1. CADASTRAR PRODUTO
if ($acao == 'cadastrar') {
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "INSERT INTO produtos (nome, marca, preco, estoque) VALUES ('$nome', '$marca', '$preco', '$estoque')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Produto cadastrado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 2. LISTAR PRODUTOS
elseif ($acao == 'listar') {
    $sql = "SELECT * FROM produtos";
    $resultado = $conn->query($sql);
    $produtos = [];

    if ($resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $produtos[] = $linha;
        }
    }
    echo json_encode($produtos);
}

// 3. EDITAR PRODUTO
elseif ($acao == 'editar') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "UPDATE produtos SET nome='$nome', marca='$marca', preco='$preco', estoque='$estoque' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Produto atualizado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 4. EXCLUIR PRODUTO
elseif ($acao == 'excluir') {
    $id = $_POST['id'];

    $sql = "DELETE FROM produtos WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Produto excluído com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}
?>
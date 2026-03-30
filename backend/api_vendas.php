<?php
// backend/api_vendas.php
header('Content-Type: application/json');
include 'conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// 1. REGISTRAR VENDA OU OS
if ($acao == 'cadastrar') {
    $cliente_id = $_POST['cliente_id'];
    $tipo = $_POST['tipo']; // 'produto' ou 'servico'
    $quantidade = $_POST['quantidade'];
    $valor_total = $_POST['valor_total'];
    
    $produto_id = ($tipo == 'produto') ? $_POST['item_id'] : "NULL";
    $servico_id = ($tipo == 'servico') ? $_POST['item_id'] : "NULL";

    $sql = "INSERT INTO vendas_os (cliente_id, tipo, produto_id, servico_id, quantidade, valor_total) 
            VALUES ($cliente_id, '$tipo', $produto_id, $servico_id, $quantidade, $valor_total)";
    
    if ($conn->query($sql) === TRUE) {
        // BÔNUS: Baixa no Estoque se for produto
        if($tipo == 'produto') {
            $conn->query("UPDATE produtos SET estoque = estoque - $quantidade WHERE id = $produto_id");
        }
        echo json_encode(["status" => "sucesso", "mensagem" => "Registro salvo com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $conn->error]);
    }
}

// 2. LISTAR VENDAS E OS (Usando JOIN para trazer os nomes em vez dos IDs)
elseif ($acao == 'listar') {
    $sql = "SELECT v.id, v.tipo, v.quantidade, v.valor_total, v.data_registro, 
                   c.nome AS cliente_nome, 
                   p.nome AS produto_nome, 
                   s.descricao AS servico_desc 
            FROM vendas_os v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN produtos p ON v.produto_id = p.id
            LEFT JOIN servicos s ON v.servico_id = s.id
            ORDER BY v.id DESC";
            
    $resultado = $conn->query($sql);
    $vendas = [];

    if ($resultado && $resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            $vendas[] = $linha;
        }
    }
    echo json_encode($vendas);
}
?>
// SISTEMA DE NOTIFICAÇÕES (TOAST)
window.mostrarNotificacao = function(mensagem, tipo) {
    let toast = document.getElementById("notificacao");
    toast.innerText = mensagem;
    // Define a classe base e adiciona 'mostrar' e o tipo ('sucesso' ou 'erro')
    toast.className = `toast mostrar ${tipo}`;
    
    // Some após 3.5 segundos
    setTimeout(function() { 
        toast.className = toast.className.replace("mostrar", "").trim(); 
    }, 3500);
};

// VARIÁVEIS GERAIS E INICIALIZAÇÃO
let produtosGlobais = [];
let servicosGlobais = [];

document.addEventListener('DOMContentLoaded', () => {
    listarClientes();
    listarProdutos();
    listarServicos();
    carregarListasVendas();
    listarVendas();
});

window.abrirAba = function(evento, idAba) {
    document.querySelectorAll(".painel").forEach(p => p.classList.remove("ativo"));
    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("ativo"));
    document.getElementById(idAba).classList.add("ativo");
    evento.currentTarget.classList.add("ativo");
};

// 1. GESTÃO DE CLIENTES
const formCliente = document.getElementById('formCliente');

formCliente.addEventListener('submit', function(e) {
    e.preventDefault(); 
    fetch('backend/api_clientes.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
        mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
        if(data.status === 'sucesso') {
            cancelarEdicaoCliente(); 
            listarClientes();
            carregarListasVendas();
        }
    })
    .catch(erro => mostrarNotificacao("Erro de comunicação com o servidor/banco de dados.", "erro"));
});

function listarClientes() {
    fetch('backend/api_clientes.php?acao=listar')
    .then(res => res.json())
    .then(clientes => {
        let lista = document.getElementById('listaClientes');
        lista.innerHTML = ''; 
        clientes.forEach(c => {
            lista.innerHTML += `<li>
                <strong>${c.nome}</strong> - CPF: ${c.cpf} - Tel: ${c.telefone}
                <button onclick="prepararEdicaoCliente(${c.id}, '${c.nome}', '${c.cpf}', '${c.telefone}', '${c.endereco}')">Editar</button>
                <button onclick="excluirCliente(${c.id})">Excluir</button>
            </li>`;
        });
    })
    .catch(erro => console.error("Erro ao listar clientes:", erro));
}

window.prepararEdicaoCliente = function(id, nome, cpf, telefone, endereco) {
    formCliente.querySelector('[name="acao"]').value = 'editar';
    formCliente.querySelector('[name="id"]').value = id;
    formCliente.querySelector('[name="nome"]').value = nome;
    formCliente.querySelector('[name="cpf"]').value = cpf;
    formCliente.querySelector('[name="telefone"]').value = telefone;
    formCliente.querySelector('[name="endereco"]').value = endereco;
    
    formCliente.querySelector('button[type="submit"]').innerText = "Atualizar Cliente";
    formCliente.querySelector('#btnCancelar').style.display = "inline-block";
};

window.cancelarEdicaoCliente = function() {
    formCliente.reset();
    formCliente.querySelector('[name="acao"]').value = 'cadastrar';
    formCliente.querySelector('[name="id"]').value = '';
    formCliente.querySelector('button[type="submit"]').innerText = "Salvar Cliente";
    formCliente.querySelector('#btnCancelar').style.display = "none";
};

window.excluirCliente = function(id) {
    if(confirm("Tem certeza que deseja excluir este cliente?")) {
        let fd = new FormData(); fd.append('acao', 'excluir'); fd.append('id', id);
        fetch('backend/api_clientes.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => { 
            mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
            listarClientes(); 
            carregarListasVendas(); 
        })
        .catch(erro => mostrarNotificacao("Erro de comunicação ao excluir.", "erro"));
    }
};

// 2. GESTÃO DE PRODUTOS
const formProduto = document.getElementById('formProduto');

formProduto.addEventListener('submit', function(e) {
    e.preventDefault(); 
    fetch('backend/api_produtos.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
        mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
        if(data.status === 'sucesso') {
            cancelarEdicaoProduto(); 
            listarProdutos();
            carregarListasVendas();
        }
    })
    .catch(erro => mostrarNotificacao("Erro de comunicação com o servidor.", "erro"));
});

function listarProdutos() {
    fetch('backend/api_produtos.php?acao=listar')
    .then(res => res.json())
    .then(produtos => {
        let lista = document.getElementById('listaProdutos');
        lista.innerHTML = ''; 
        produtos.forEach(p => {
            lista.innerHTML += `<li>
                <strong>${p.nome} (${p.marca})</strong> - R$${p.preco} - Estoque: ${p.estoque} un.
                <button onclick="prepararEdicaoProduto(${p.id}, '${p.nome}', '${p.marca}', '${p.preco}', '${p.estoque}')">Editar</button>
                <button onclick="excluirProduto(${p.id})">Excluir</button>
            </li>`;
        });
    });
}

window.prepararEdicaoProduto = function(id, nome, marca, preco, estoque) {
    formProduto.querySelector('[name="acao"]').value = 'editar';
    formProduto.querySelector('[name="id"]').value = id;
    formProduto.querySelector('[name="nome"]').value = nome;
    formProduto.querySelector('[name="marca"]').value = marca;
    formProduto.querySelector('[name="preco"]').value = preco;
    formProduto.querySelector('[name="estoque"]').value = estoque;
    
    formProduto.querySelector('button[type="submit"]').innerText = "Atualizar Produto";
    formProduto.querySelector('#btnCancelar').style.display = "inline-block";
};

window.cancelarEdicaoProduto = function() {
    formProduto.reset();
    formProduto.querySelector('[name="acao"]').value = 'cadastrar';
    formProduto.querySelector('[name="id"]').value = '';
    formProduto.querySelector('button[type="submit"]').innerText = "Salvar Produto";
    formProduto.querySelector('#btnCancelar').style.display = "none";
};

window.excluirProduto = function(id) {
    if(confirm("Tem certeza que deseja excluir este produto?")) {
        let fd = new FormData(); fd.append('acao', 'excluir'); fd.append('id', id);
        fetch('backend/api_produtos.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => { 
            mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
            listarProdutos(); 
            carregarListasVendas(); 
        })
        .catch(erro => mostrarNotificacao("Erro de comunicação ao excluir.", "erro"));
    }
};

// 3. GESTÃO DE SERVIÇOS
const formServico = document.getElementById('formServico');

formServico.addEventListener('submit', function(e) {
    e.preventDefault(); 
    fetch('backend/api_servicos.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
        mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
        if(data.status === 'sucesso') {
            cancelarEdicaoServico(); 
            listarServicos();
            carregarListasVendas();
        }
    })
    .catch(erro => mostrarNotificacao("Erro de comunicação com o servidor.", "erro"));
});

function listarServicos() {
    fetch('backend/api_servicos.php?acao=listar')
    .then(res => res.json())
    .then(servicos => {
        let lista = document.getElementById('listaServicos');
        lista.innerHTML = ''; 
        servicos.forEach(s => {
            lista.innerHTML += `<li>
                <strong>${s.descricao}</strong> - R$${s.preco_base}
                <button onclick="prepararEdicaoServico(${s.id}, '${s.descricao}', '${s.preco_base}')">Editar</button>
                <button onclick="excluirServico(${s.id})">Excluir</button>
            </li>`;
        });
    });
}

window.prepararEdicaoServico = function(id, descricao, preco) {
    formServico.querySelector('[name="acao"]').value = 'editar';
    formServico.querySelector('[name="id"]').value = id;
    formServico.querySelector('[name="descricao"]').value = descricao;
    formServico.querySelector('[name="preco_base"]').value = preco;
    
    formServico.querySelector('button[type="submit"]').innerText = "Atualizar Serviço";
    formServico.querySelector('#btnCancelar').style.display = "inline-block";
};

window.cancelarEdicaoServico = function() {
    formServico.reset();
    formServico.querySelector('[name="acao"]').value = 'cadastrar';
    formServico.querySelector('[name="id"]').value = '';
    formServico.querySelector('button[type="submit"]').innerText = "Salvar Serviço";
    formServico.querySelector('#btnCancelar').style.display = "none";
};

window.excluirServico = function(id) {
    if(confirm("Tem certeza que deseja excluir este serviço?")) {
        let fd = new FormData(); fd.append('acao', 'excluir'); fd.append('id', id);
        fetch('backend/api_servicos.php', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => { 
            mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
            listarServicos(); 
            carregarListasVendas(); 
        })
        .catch(erro => mostrarNotificacao("Erro de comunicação ao excluir.", "erro"));
    }
};

// 4. VENDAS E ORDENS DE SERVIÇO (OS)
window.carregarListasVendas = function() {
    fetch('backend/api_clientes.php?acao=listar').then(res => res.json()).then(dados => {
        let select = document.getElementById('selectCliente');
        if(select) {
            select.innerHTML = '<option value="">Selecione um cliente</option>';
            dados.forEach(c => select.innerHTML += `<option value="${c.id}">${c.nome}</option>`);
        }
    }).catch(() => console.error("Falha ao carregar clientes na Venda"));

    fetch('backend/api_produtos.php?acao=listar').then(res => res.json()).then(dados => produtosGlobais = dados);
    fetch('backend/api_servicos.php?acao=listar').then(res => res.json()).then(dados => servicosGlobais = dados);
};

window.mudarTipo = function() {
    let tipo = document.getElementById('selectTipo').value;
    let selectItem = document.getElementById('selectItem');
    
    selectItem.innerHTML = '<option value="">Selecione um item</option>';
    selectItem.disabled = false;
    document.getElementById('valor_total').value = '';

    if (tipo === 'produto') {
        produtosGlobais.forEach(p => {
            selectItem.innerHTML += `<option value="${p.id}" data-preco="${p.preco}">[Estoque: ${p.estoque}] ${p.nome} - R$${p.preco}</option>`;
        });
    } else if (tipo === 'servico') {
        servicosGlobais.forEach(s => {
            selectItem.innerHTML += `<option value="${s.id}" data-preco="${s.preco_base}">${s.descricao} - R$${s.preco_base}</option>`;
        });
    } else {
        selectItem.disabled = true;
    }
};

window.calcularTotal = function() {
    let selectItem = document.getElementById('selectItem');
    let qtd = document.getElementById('quantidade').value;
    
    if(selectItem && selectItem.selectedIndex > 0) {
        let preco = selectItem.options[selectItem.selectedIndex].getAttribute('data-preco');
        let total = (parseFloat(preco) * parseInt(qtd)).toFixed(2);
        document.getElementById('valor_total').value = total;
    }
};

const formVenda = document.getElementById('formVenda');
if(formVenda) {
    formVenda.addEventListener('submit', function(e) {
        e.preventDefault(); 
        fetch('backend/api_vendas.php', { method: 'POST', body: new FormData(this) })
        .then(res => res.json())
        .then(data => {
            mostrarNotificacao(data.mensagem, data.status); // <--- NOTIFICAÇÃO AQUI
            if(data.status === 'sucesso') {
                this.reset();
                document.getElementById('selectItem').disabled = true;
                listarVendas();
                listarProdutos(); 
                carregarListasVendas(); 
            }
        })
        .catch(erro => mostrarNotificacao("Erro de comunicação com o servidor ao registrar venda.", "erro"));
    });
}

function listarVendas() {
    fetch('backend/api_vendas.php?acao=listar')
    .then(res => res.json())
    .then(vendas => {
        let lista = document.getElementById('listaVendas');
        if(lista) {
            lista.innerHTML = ''; 
            vendas.forEach(v => {
                let itemNome = v.tipo === 'produto' ? v.produto_nome : v.servico_desc;
                lista.innerHTML += `<li>
                    <small>${v.data_registro}</small><br>
                    <strong>Cliente:</strong> ${v.cliente_nome} <br>
                    <strong>${v.tipo.toUpperCase()}:</strong> ${itemNome} (Qtd: ${v.quantidade}) <br>
                    <strong>Total: R$ ${v.valor_total}</strong>
                </li>`;
            });
        }
    })
    .catch(erro => console.error("Erro ao listar vendas:", erro));
}
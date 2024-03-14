-- Criação do Banco de Dados

CREATE DATABASE IF NOT EXISTS sistema_vendas;
USE sistema_vendas;

-- Tabela Categoria
	CREATE TABLE IF NOT EXISTS Categoria(
		id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UsuarioAtualizacao INT,
        Ativo TINYINT(1)DEFAULT(1)
    );
    
    
-- Tabela FormaPagamento 
	CREATE TABLE IF NOT EXISTS FormaPagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    descricao TEXT,
	dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
	dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UsuarioAtualizacao INT,
	Ativo TINYINT(1)DEFAULT(1)
    );
    
    
    -- Tabela produto
    CREATE TABLE IF NOT EXISTS produto (
		id INT AUTO_INCREMENT PRIMARY KEY,
        Nome VARCHAR (100) NOT NULL,
        descricao TEXT,
        Preco DECIMAL(10,2) NOT NULL DEFAULT 0,
        CategoriaID INT,
        dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
	    dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		UsuarioAtualizacao INT,
        Ativo TINYINT(1)DEFAULT(1),
        INDEX idx_nome (nome), -- Adiciona indice nas colunas Nome
        CONSTRAINT fk_categoria_produto FOREIGN KEY (CategoriaID) REFERENCES Categoria(id)
    );
    
    
    -- Tabela Cliente
    
CREATE TABLE IF NOT EXISTS Cliente (
	id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    Telefone VARCHAR(20),
    dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
	dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UsuarioAtualizacao INT,
	Ativo TINYINT(1)DEFAULT(1),
    INDEX idx_nome(Nome)
);


CREATE TABLE IF NOT EXISTS Pedido(
	id INT AUTO_INCREMENT PRIMARY KEY,
    ClienteId INT,
    DataPedido DATETIME,
    FormaPagamentoId INT,
    status VARCHAR(50),
    dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
	dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UsuarioAtualizacao INT,
    FOREIGN KEY (ClienteId) REFERENCES cliente(ID),
    FOREIGN KEY (FormaPagamentoID) REFERENCES formaPagamento(ID)
);


-- Tabela ItemPedido
CREATE TABLE IF NOT EXISTS ItemPedido(
	ID INT AUTO_INCREMENT PRIMARY KEY,
    PedidoId INT,
    ProdutoId INT,
    Quantidade INT,
    dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
	dataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	UsuarioAtualizacao INT,
    FOREIGN KEY (PedidoId) REFERENCES pedido (id),
    FOREIGN KEY (ProdutoId) REFERENCES produto (id)
);
-- Tabela GrupoUsuario
CREATE TABLE IF NOT EXISTS GrupoUsuario (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT,
    DataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    DataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UsuarioAtualizacao INT,
    Ativo TINYINT(1) DEFAULT 1
);

-- Tabela Permissao
CREATE TABLE IF NOT EXISTS Permissao (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT,
    DataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    DataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UsuarioAtualizacao INT,
    Ativo TINYINT(1) DEFAULT 1
);

-- Tabela PermissaoGrupo
CREATE TABLE IF NOT EXISTS PermissaoGrupo (
    PermissaoID INT,
    GrupoUsuarioID INT,
    PRIMARY KEY (PermissaoID, GrupoUsuarioID),
    FOREIGN KEY (PermissaoID) REFERENCES Permissao(Id),
    FOREIGN KEY (GrupoUsuarioID) REFERENCES GrupoUsuario(Id)
);

-- Tabela Usuario
CREATE TABLE IF NOT EXISTS Usuario (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    NomeUsuario VARCHAR(50) NOT NULL,
    Senha VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    GrupoUsuarioID INT,
    Ativo TINYINT(1) DEFAULT 1,
    DataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    DataAtualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UsuarioAtualizacao INT,
    UNIQUE (NomeUsuario), -- Restrição UNIQUE na coluna NomeUsuario
    UNIQUE (Email), -- Restrição UNIQUE na coluna Email
    FOREIGN KEY (GrupoUsuarioID) REFERENCES GrupoUsuario(Id)
);
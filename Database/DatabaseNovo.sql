CREATE TABLE grupo_produtos(
	codigo_grupo INT AUTO_INCREMENT,
    descricao VARCHAR(30),
    PRIMARY KEY (codigo_grupo)
);

CREATE TABLE produtos (
	codigo_produto INT AUTO_INCREMENT,
    codTbGrupo INT,
    descricao VARCHAR(30),
    unidade VARCHAR(3),
    FOREIGN KEY (codTbGrupo) REFERENCES grupo_produtos(codigo_grupo),
    PRIMARY KEY (codigo_produto)
);

CREATE TABLE desperdicio_producao (
	codigo_producao INT AUTO_INCREMENT,
    nomePessoa VARCHAR(30),
    dataSaida DATE,
    numeroProducao VARCHAR(20),
    finalizada VARCHAR(1),
    PRIMARY KEY (codigo_producao)
);

CREATE TABLE desperdicio_producao_produto (
	sequencia INT AUTO_INCREMENT,
	codTbProducao INT,-- codTbProducao REPRESENTA UM RELACIONAMENTO COM O ID DA TABELA DESPERDICIO PRODUCAO
    codTbProduto INT, -- FAZ REFERENCIA AO ID DA TABELA PRODUTOS
    qtdeSaida INT,
    FOREIGN KEY (codTbProducao) REFERENCES desperdicio_producao(codigo_producao),
    FOREIGN KEY (codTbProduto) REFERENCES produtos(codigo_produto),
    PRIMARY KEY (sequencia)
);



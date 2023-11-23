CREATE TABLE grupo_produtos(
	codigo_grupo INT AUTO_INCREMENT,
    descricao VARCHAR(30),
    PRIMARY KEY (codigo_grupo)
);

CREATE TABLE produtos (
	codigo_produto INT AUTO_INCREMENT,
    codigo_grupo INT,
    descricao VARCHAR(30),
    unidade VARCHAR(3),
    FOREIGN KEY (codigo_grupo) REFERENCES grupo_produtos(codigo_grupo),
    PRIMARY KEY (codigo_produto)
);

DROP TABLE produtos;

CREATE TABLE desperdicio_producao (
	id INT AUTO_INCREMENT,
    nome_pessoa VARCHAR(30),
    data_saida DATE,
    numero_producao VARCHAR(20),
    finalizada VARCHAR(1),
    PRIMARY KEY (id)
);

CREATE TABLE desperdicio_producao_produto (
	sequencia INT AUTO_INCREMENT,
	id INT,-- ID REPRESENTA UM RELACIONAMENTO COM O ID DA TABELA DESPERDICIO PRODUCAO
    codigo_produto INT, -- FAZ REFERENCIA AO ID DA TABELA PRODUTOS
    qtde_saida INT,
    PRIMARY KEY (sequencia, id, codigo_produto)
);

ALTER TABLE desperdicio_producao_produto 
MODIFY COLUMN qtde_saida REAL;

DELIMITER $$

-- DESPERDICIO PRODUCAO
CREATE PROCEDURE sp_insert_desperdicio_producao(
    IN Inome_pessoa VARCHAR(30),
    IN Idata_lancamento DATE,
    IN Inumero_producao VARCHAR(20)
)
BEGIN
	INSERT INTO desperdicio_producao (nome_pessoa, data_saida, numero_producao, finalizada)
    VALUES (Inome_pessoa, Idata_lancamento, Inumero_producao, "N");
END $$ 


CREATE PROCEDURE sp_update_desperdicio_producao(
	IN Iid INT,
    IN Inome_pessoa VARCHAR(30),
    IN Idata_lancamento DATE,
    IN Inumero_producao VARCHAR(20)
)
BEGIN
	UPDATE desperdicio_producao
    SET nome_pessoa = Inome_pessoa, data_saida = Idata_lancamento, numero_producao = Inumero_producao
    WHERE finalizada = "N" AND id = Iid;
END $$ 


CREATE PROCEDURE sp_finaliza_desperdicio_producao(
	IN Iid INT
)
BEGIN
	UPDATE desperdicio_producao
    SET finalizada = "S"
    WHERE id = Iid;
END $$ 


CREATE PROCEDURE sp_delete_desperdicio_producao(
	IN id_despedicio INT
)
BEGIN
	DELETE FROM desperdicio_producao 
    WHERE id = id_despedicio AND finalizada = "N";
END $$


-- DESPERDICIO PRODUCAO PRODUTO
CREATE PROCEDURE sp_insert_desperdicio_producao_produto(
	IN id_desperdicio_producao INT,
    IN Icodigo_produto INT,
    IN Iqtde_saida INT
)
BEGIN
	INSERT INTO desperdicio_producao_produto (id, codigo_produto, qtde_saida)
    VALUES (id_desperdicio_producao, Icodigo_produto, Iqtde_saida);
END $$


CREATE PROCEDURE sp_update_desperdicio_producao_produto(
	IN id_desperdicio_producao_produto INT,
	IN id_desperdicio_producao INT,
    IN Icodigo_produto INT,
    IN Iqtde_saida INT
)
BEGIN
	UPDATE desperdicio_producao_produto
    SET id = id_desperdicio_producao , codigo_produto = Icodigo_produto, qtde_saida = Iqtde_saida
    WHERE sequencia = id_desperdicio_producao_produto;
END $$


CREATE PROCEDURE sp_delete_desperdicio_producao_produto(
	IN id_desperdicio_producao_produto INT
)
BEGIN
	DELETE FROM desperdicio_producao_produto 
    WHERE sequencia = id_desperdicio_producao_produto;
END $$
DELIMITER ;

CALL sp_update_desperdicio_producao(8, "TESTE update", now(), "fsdkjnfsfd");

INSERT INTO grupo_produtos (descricao) 
VALUES ('SECOS'),
('TEMPERO'),
('PROTEINAS');

INSERT INTO produtos(codigo_grupo, descricao, unidade)
VALUES (1, 'FEIJÃO', 'KG'),
(1, 'ARROZ', 'KG'),
(1, 'MACARRÃO', 'KG'),
(1, 'FARINHA', 'KG'),
(1, 'FAVA', 'KG'),
(2, 'ALHO', 'KG'),
(2, 'COLORAL', 'KG'),
(2, 'OREGANO', 'KG'),
(2, 'VINAGRE', 'KG'),
(2, 'SAL', 'KG'),
(3, 'PATINHO', 'KG'),
(3, 'CHAMBARIL', 'KG'),
(3, 'FILE MIGNOM', 'KG'),
(3, 'COXINHA DA ASA', 'KG'),
(3, 'COXA E SOBRECOXA', 'KG');

UPDATE grupo_produtos
SET descricao = "SECOS"
WHERE codigo_grupo = 1;

SELECT
    dpp.id,
    dpp.sequencia AS id_desperdicio_produto,
    p.codigo_produto,
    p.descricao,
    p.unidade,
    dpp.qtde_saida,
    gpr.descricao
FROM desperdicio_producao_produto dpp
INNER JOIN desperdicio_producao dp
ON dpp.id = dp.id
INNER JOIN  produtos p
ON dpp.codigo_produto = p.codigo_produto
INNER JOIN  grupo_produtos gpr
ON p.codigo_grupo = gpr.codigo_grupo
WHERE dp.id = 9;

select * from desperdicio_producao;

CREATE VIEW vw_desperdicio_producao_produto AS
SELECT 
	dp.id AS id,
	dp.sequencia AS id_desperdicio_produto,
    dp.qtde_saida,
    p.descricao
FROM desperdicio_producao_produto dp
INNER JOIN produtos p
ON dp.codigo_produto = p.codigo_produto
INNER JOIN grupo_produtos gp
ON p.codigo_grupo = gp.codigo_grupo;

SELECT 
	dp.id AS id,
	dp.sequencia AS id_desperdicio_produto,
    dp.qtde_saida,
    p.descricao,
    gp.descricao AS grupo
FROM desperdicio_producao_produto dp
INNER JOIN produtos p
ON dp.codigo_produto = p.codigo_produto
INNER JOIN grupo_produtos gp
ON p.codigo_grupo = gp.codigo_grupo
WHERE id = 9
ORDER BY gp.codigo_grupo;



SELECT 
	p.descricao AS PRODUTO,
    gps.descricao AS GRUPO,
    COUNT(p.codigo_produto) AS QTDE_REGISTRO,
    SUM(dpp.qtde_saida) AS QUANTIDADE_TOTAL
FROM produtos p
INNER JOIN desperdicio_producao_produto dpp
ON dpp.codigo_produto = p.codigo_produto
INNER JOIN grupo_produtos gps 
ON p.codigo_grupo = gps.codigo_grupo
GROUP BY p.codigo_produto
HAVING COUNT(p.codigo_produto) > 5;
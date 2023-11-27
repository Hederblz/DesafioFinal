create database desafio;
use desafio;

INSERT INTO grupo_produtos (descricao) VALUES
    ('Eletrônicos'),
    ('Móveis'),
    ('Roupas');

-- Suponhamos que os códigos dos grupos correspondam aos dados inseridos acima
INSERT INTO produtos (codTbGrupo, descricao, unidade) VALUES
    (1, 'Smartphone', 'un'),
    (2, 'Sofá', 'un'),
    (3, 'Camiseta', 'pc');

INSERT INTO desperdicio_producao (nomePessoa, dataSaida, numeroProducao, finalizada) VALUES
    ('Matheus', '2023-11-01', '001','S'),
    ('Maria', '2023-12-02', '002','S'),
    ('João', '2023-13-03', '003','S');

-- Suponhamos que os códigos das produções e produtos correspondam aos dados inseridos acima
INSERT INTO desperdicio_producao_produto (codTbProducao, codTbProduto, qtdeSaida) VALUES
    (1, 1, 10),
    (2, 2, 5),
    (3, 3, 8);


DELETE FROM desperdicio_producao WHERE desperdicio_producao.nomePessoa = 'ed';   


select * from desperdicio_producao_produto;
select * from produtos;
SELECT
    dp.codigo_producao,
    dp.nomePessoa,
    dp.dataSaida,
    dp.numeroProducao,
    dpp.qtdeSaida,
    pr.descricao AS produto
FROM
    desperdicio_producao dp
JOIN
    desperdicio_producao_produto dpp ON dp.codigo_producao = dpp.codTbProducao
JOIN
    produtos pr ON dpp.codTbProduto = pr.codigo_produto;


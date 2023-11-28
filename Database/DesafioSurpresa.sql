
SELECT
    p.descricao AS nome_produto,
    g.descricao AS grupo_produto,
    COUNT(dp.sequencia) AS quantidade_de_lancamentos,
    SUM(dp.qtdeSaida) AS quantidade_total
FROM
    desperdicio_producao_produto dp
INNER JOIN produtos p ON dp.codTbProduto = p.codigo_produto
INNER JOIN grupo_produtos g ON p.codTbGrupo = g.codigo_grupo
GROUP BY
    p.descricao, g.descricao
HAVING
    COUNT(dp.sequencia) > 5;
    
CREATE VIEW vw_busca_autoincremento
AS
SELECT co_seq_exame as id, nm_exame as nome, 'exame' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_exame
UNION ALL
SELECT co_seq_consulta as id, nm_consulta as nome, 'consulta' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_consulta
UNION ALL
SELECT co_seq_cliente as id, nm_cliente as nome, 'cliente' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_cliente
UNION ALL
SELECT co_seq_caixa as id, nm_caixa as nome, 'caixa' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_caixa
UNION ALL
SELECT co_seq_corpo_clinico as id, nm_corpo_clinico as nome, 'corpo-clinico' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_corpo_clinico
UNION ALL
SELECT co_seq_contrato_gog as id, nm_contrato_gog as nome, 'contrato-gog' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_contrato_gog
UNION ALL
SELECT co_seq_contato as id, nm_nome as nome, 'contato' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_contato
UNION ALL
SELECT co_seq_usuario as id, nm_usuario as nome, 'usuario' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_usuario
UNION ALL
SELECT co_seq_dependentes as id, nm_dependente as nome, 'dependente' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_dependentes;


CREATE VIEW vw_busca_autoincremento_cliente
AS
SELECT co_seq_exame as id, nm_exame as nome, 'exame' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_exame
UNION ALL
SELECT co_seq_consulta as id, nm_consulta as nome, 'consulta' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_consulta
UNION ALL
SELECT co_seq_corpo_clinico as id, nm_corpo_clinico as nome, 'corpo-clinico' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro
FROM tb_corpo_clinico;
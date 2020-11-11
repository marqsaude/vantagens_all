DELETE e.* FROM tb_extrato e
INNER JOIN tb_pagamento p ON p.co_seq_pagamento = e.co_pagamento
INNER JOIN tb_acordo a ON a.co_seq_acordo = p.co_acordo
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE b.* FROM tb_boleto b
INNER JOIN tb_pagamento p ON p.co_seq_pagamento = b.co_pagamento
INNER JOIN tb_acordo a ON a.co_seq_acordo = p.co_acordo
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE r.* FROM tb_recibo r
INNER JOIN tb_pagamento p ON p.co_seq_pagamento = r.co_pagamento
INNER JOIN tb_acordo a ON a.co_seq_acordo = p.co_acordo
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE p.* FROM tb_pagamento p
INNER JOIN tb_acordo a ON a.co_seq_acordo = p.co_acordo
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE ct.* FROM tb_cartao ct
INNER JOIN tb_cliente c ON c.co_seq_cliente = ct.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE d.* FROM tb_dependentes d
INNER JOIN tb_acordo a ON a.co_seq_acordo = d.co_acordo
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE a.* FROM tb_acordo a
INNER JOIN tb_cliente c ON c.co_seq_cliente = a.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE rct.* FROM rl_cliente_telefone rct
INNER JOIN tb_cliente c ON c.co_seq_cliente = rct.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE e.* FROM tb_email e
INNER JOIN tb_cliente c ON c.co_seq_cliente = e.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE o.* FROM tb_ocorrencia o
INNER JOIN tb_cliente c ON c.co_seq_cliente = o.co_cliente
WHERE (c.co_seq_cliente = ???);

DELETE c.* FROM tb_cliente c
WHERE (c.co_seq_cliente = ???);
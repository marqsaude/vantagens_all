DELIMITER //

CREATE FUNCTION pago ( co_status_pagamento INT, co_forma_pagamento INT, co_seq_cliente INT )
RETURNS INT

BEGIN

  DECLARE varReturn INT;
  DECLARE msgReturn VARCHAR(200);
  DECLARE returnSQL INT;

  IF (co_status_pagamento!=3 AND co_status_pagamento!=4) THEN
    SET msgReturn = 'Não houve primeiro pagamento.';
    SET varReturn = 3;
  ELSE
    IF co_forma_pagamento = 1 THEN
      SET returnSQL = (SELECT COUNT(*) AS var FROM tb_boleto WHERE dt_vencimento<=NOW() AND st_pago=2 AND st_registro=1 AND co_cliente=co_seq_cliente LIMIT 1);
      IF returnSQL = 0 THEN
        SET msgReturn = 'Boleto(s) em dia.';
        SET varReturn = 1;
      ELSE
        SET msgReturn = 'Boleto(s) não estão em dia.';
        SET varReturn = 4;
      END IF;
    ELSE
      SET msgReturn = 'Pagamento em dia.';
      SET varReturn = 2;
    END IF;
  END IF;

  RETURN varReturn;

END; //

DELIMITER ;
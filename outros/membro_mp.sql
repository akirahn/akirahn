select nm_apelido, vl_ultima_mensalidade, dt_mensalidade_a_pagar, vl_ultima_prestacao, dt_prestacao_a_pagar
from membro m
where m.tipo_situacao_id = 'A'
and   m.vl_ultima_prestacao is not null or m.vl_ultima_mensalidade is not null
order by 1
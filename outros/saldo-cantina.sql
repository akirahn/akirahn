/* Saldo Cantina */
SELECT sum(case when fluxo_movimento_id = 1 then vl_fluxo else -1 * vl_fluxo end) saldo 
FROM fluxo 
WHERE fluxo_tipo_id = 17 

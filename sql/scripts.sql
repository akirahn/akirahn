SELECT *
FROM gst_tab_pagto g
inner join gst_tab_forma_pagto f on f.id = g.fk_forma_pagto
inner join tab_quem q on q.id = g.fk_quem
where g.dia_vencimento < dia_fechamento
----------------------------------------------------------------------------
-- CORREÇÃO VENCIMENTO
SELECT * FROM gst_gastos g
where g.dt_gasto > g.dt_pagto
and g.fk_pagto in (13,14, 15)
order by dt_gasto
/*
update gst_gastos
set dt_pagto = DATE_ADD(dt_pagto, INTERVAL 1 MONTH)
where dt_gasto > dt_pagto
and fk_pagto in (13, 14, 15)
*/
/*
SELECT * FROM gst_gastos g
where g.dt_gasto >= '2024-02-29'
and g.fk_pagto in (14, 15)
order by dt_gasto
*/
update gst_gastos g
set dt_pagto = '2024-04-08'
where g.dt_gasto >= '2024-02-29'
and fk_pagto in (14, 15)
----------------------------------------------------------------------------
select if(movimento = 1, 'Receita', 'Despesa') movimento, grupo, tipo, sub, format(valor, 2, 'de_DE') valor, 
			 date_format(dt_pagto, '%d/%m/%Y') dt_pagto, obs, dt_gasto, tipo, id
from (
select g.fk_movimento movimento,
               gp.ds_grupo grupo,
               t.ds_tipo tipo,
               tg.ds_tag sub,
               vl_gasto valor,
               f.ds_forma_pagto,
               g.dt_pagto,
               g.obs,
               concat(g.nr_parcelas, '/', g.nr_parcelas) parcela,
               g.dt_gasto,
               'Q' tipo_linha,
               g.id
          from gst_gastos g
         inner join gst_tab_subtipo s
            on s.id = g.fk_subtipo
         inner join gst_tab_tipo t
            on t.id = s.fk_tipo
         inner join gst_tab_tag tg
            on tg.id = s.fk_tag
         inner join gst_tab_pagto p
            on p.id = g.fk_pagto
          left join gst_tab_forma_pagto f
            on p.fk_forma_pagto = f.id
          left join gst_tab_grupo gp
            on gp.id = s.fk_grupo
          left join gst_gastos_quem q
            on q.fk_gasto = g.id
         where 1 = 1
           and s.id <> 9
           and g.nr_parcelas = 1
					 --and (q.fk_quem = 7 or s.id = 39)
        union
        select g.fk_movimento,
               gp.ds_grupo,
               t.ds_tipo,
               tg.ds_tag,
               pc.vl_parcela,
               f.ds_forma_pagto,
               pc.dt_pagto,
               g.obs,
               concat(pc.nr_parcela, '/', g.nr_parcelas),
               g.dt_gasto,
               'P',
               pc.id
          from gst_gastos g
         inner join gst_tab_subtipo s
            on s.id = g.fk_subtipo
         inner join gst_tab_tipo t
            on t.id = s.fk_tipo
         inner join gst_tab_tag tg
            on tg.id = s.fk_tag
         inner join gst_tab_pagto p
            on p.id = g.fk_pagto
         inner join gst_parcelas pc
            on pc.fk_gastos = g.id
          left join gst_tab_forma_pagto f
            on p.fk_forma_pagto = f.id
          left join gst_tab_grupo gp
            on gp.id = 3
          left join gst_gastos_quem q
            on q.fk_gasto = g.id
         where 1 = 1
           and s.id <> 9
           and g.nr_parcelas > 1
					 --and (q.fk_quem = 7 or s.id = 39)
) t
where dt_pagto between '2024-01-01' and '2024-02-08'
order by 1, 2
----------------------------------------------------------------------------
-- DESPESAS CASA MADRINHA
select  date_format(dt_gasto, '%d/%m/%Y') Compra, obs Descrição,
        date_format(dt_pagto, '%d/%m/%Y') Vencimento,
        format(valor, 2, 'de_DE') Valor
select  date_format(dt_gasto, '%d/%m/%Y') Compra, obs Descrição,
        if(date_format(dt_pagto, '%m') = 1,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 1,format(valor, 2, 'de_DE'), null) Janeiro,
        if(date_format(dt_pagto, '%m') = 2,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 2,format(valor, 2, 'de_DE'), null) Fevereiro,
        if(date_format(dt_pagto, '%m') = 3,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 3,format(valor, 2, 'de_DE'), null) Março,
        if(date_format(dt_pagto, '%m') = 4,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 4,format(valor, 2, 'de_DE'), null) Abril,
        if(date_format(dt_pagto, '%m') = 5,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 5,format(valor, 2, 'de_DE'), null) Maio,
        if(date_format(dt_pagto, '%m') = 6,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 6,format(valor, 2, 'de_DE'), null) Junho,
        if(date_format(dt_pagto, '%m') = 7,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 7,format(valor, 2, 'de_DE'), null) Julho,
        if(date_format(dt_pagto, '%m') = 8,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 8,format(valor, 2, 'de_DE'), null) Agosto,
        if(date_format(dt_pagto, '%m') = 9,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 9,format(valor, 2, 'de_DE'), null) Setembro,
        if(date_format(dt_pagto, '%m') = 10,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 10,format(valor, 2, 'de_DE'), null) Outubro,
        if(date_format(dt_pagto, '%m') = 11,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 11,format(valor, 2, 'de_DE'), null) Novembro,
        if(date_format(dt_pagto, '%m') = 12,date_format(dt_pagto, '%d/%m/%Y'), null) Vencimento,
        if(date_format(dt_pagto, '%m') = 12,format(valor, 2, 'de_DE'), null) Dezembro
				
from (
select g.fk_movimento movimento,
               gp.ds_grupo grupo,
               t.ds_tipo tipo,
               tg.ds_tag sub,
               vl_gasto valor,
               f.ds_forma_pagto,
               g.dt_pagto,
               g.obs,
               concat(g.nr_parcelas, '/', g.nr_parcelas) parcela,
               g.dt_gasto,
               'Q' tipo_linha,
               g.id
          from gst_gastos g
         inner join gst_tab_subtipo s
            on s.id = g.fk_subtipo
         inner join gst_tab_tipo t
            on t.id = s.fk_tipo
         inner join gst_tab_tag tg
            on tg.id = s.fk_tag
         inner join gst_tab_pagto p
            on p.id = g.fk_pagto
          left join gst_tab_forma_pagto f
            on p.fk_forma_pagto = f.id
          left join gst_tab_grupo gp
            on gp.id = s.fk_grupo
          left join gst_gastos_quem q
            on q.fk_gasto = g.id
         where 1 = 1
           and s.id = 85
           and g.nr_parcelas = 1
        union
        select g.fk_movimento,
               gp.ds_grupo,
               t.ds_tipo,
               tg.ds_tag,
               pc.vl_parcela,
               f.ds_forma_pagto,
               pc.dt_pagto,
               g.obs,
               concat(pc.nr_parcela, '/', g.nr_parcelas),
               g.dt_gasto,
               'P',
               pc.id
          from gst_gastos g
         inner join gst_tab_subtipo s
            on s.id = g.fk_subtipo
         inner join gst_tab_tipo t
            on t.id = s.fk_tipo
         inner join gst_tab_tag tg
            on tg.id = s.fk_tag
         inner join gst_tab_pagto p
            on p.id = g.fk_pagto
         inner join gst_parcelas pc
            on pc.fk_gastos = g.id
          left join gst_tab_forma_pagto f
            on p.fk_forma_pagto = f.id
          left join gst_tab_grupo gp
            on gp.id = 3
          left join gst_gastos_quem q
            on q.fk_gasto = g.id
         where 1 = 1
           and s.id = 85
           and g.nr_parcelas > 1
) t
where dt_gasto > '2024-01-25'
order by dt_pagto
----------------------------------------------------------------------------
select s.id, t.id, t.ds_tipo, tg.id, tg.ds_tag, g.id, g.ds_grupo
from gst_tab_subtipo s
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
left join gst_tab_grupo g on g.id = s.fk_grupo
order by 3, 5
----------------------------------------------------------------------------
select concat(t.ds_tipo, '/', tg.ds_tag) subtipo, s.id, dt_pagto, format(vl_gasto, 2, 'de_DE') vl_gasto, g.nr_parcelas, g.obs, if(g.fk_movimento = 1,1, -1) tipo
from gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
where /*s.fk_tipo in (14, 15, 19)
and */g.dt_pagto between '2023-12-21' and '2024-01-22'
union
select concat(t.ds_tipo, '/', tg.ds_tag) subtipo, p.fk_gastos, p.dt_pagto, format(vl_parcela, 2, 'de_DE'), p.nr_parcela, '', -1
from gst_parcelas p
inner join gst_gastos g on g.id = p.fk_gastos
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
where p.dt_pagto between '2023-12-21' and '2024-01-22'
/*and s.fk_tipo in (14, 15, 19)*/
order by 1
----------------------------------------------------------------------------
select ds_tipo, format(sum(vl_gasto), 2, 'de_DE') valor
from (
select t.ds_tipo, if(g.fk_movimento = 1,1, -1) * vl_gasto vl_gasto, g.dt_pagto
from gst_gastos g
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
union
select t.ds_tipo, -1 * vl_parcela, p.dt_pagto
from gst_parcelas p
inner join gst_gastos g on g.id = p.fk_gastos
inner join gst_tab_subtipo s on s.id = g.fk_subtipo
inner join gst_tab_tipo t on t.id = s.fk_tipo
inner join gst_tab_tag tg on tg.id = s.fk_tag
) t
where dt_pagto between '2023-12-21' and '2024-01-22'
group by ds_tipo
order by 1
----------------------------------------------------------------------------
SELECT *
FROM gst_tab_pagto g
inner join gst_tab_forma_pagto f on f.id = g.fk_forma_pagto
inner join tab_quem q on q.id = g.fk_quem
where g.dia_vencimento < dia_fechamento
----------------------------------------------------------------------------
update gst_parcelas g
set dt_pagto = DATE_ADD(dt_pagto, INTERVAL 1 MONTH)
where fk_gastos = 1643
----------------------------------------------------------------------------
select pg.forma_pagto, pg.dt_pagto, sum(gt.vl_gasto) valor
from
(
SELECT g.id id_pagto, concat(f.ds_forma_pagto, coalesce(concat(' (', q.nm_pessoa, ')'), ' ')) forma_pagto,
  case
    when g.dia_vencimento < 20 then concat(date_format(DATE_ADD(cp.dt_competencia, INTERVAL 1 MONTH), '%Y-%m-'), '0', g.dia_vencimento)
    else concat(date_format(cp.dt_competencia, '%Y-%m-'), g.dia_vencimento) end dt_pagto
FROM gst_tab_pagto g
inner join gst_tab_forma_pagto f on f.id = g.fk_forma_pagto
left join tab_quem q on q.id = g.fk_quem
inner join gst_competencia cp
where cp.dt_competencia in
(select max(dt_competencia)
 from gst_competencia cpm)
and tp_pagto = 'C'
and dia_vencimento <> 0
order by 2
) pg,
(
select dt_pagto, fk_pagto, vl_gasto
from gst_gastos g
union
select p.dt_pagto, g.fk_pagto, p.vl_parcela
from gst_gastos g
inner join gst_parcelas p on p.fk_gastos = g.id
) gt
where pg.id_pagto = gt.fk_pagto
and pg.dt_pagto = gt.dt_pagto
group by pg.forma_pagto, pg.dt_pagto
order by 1
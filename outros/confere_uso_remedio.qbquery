select a.fk_remedio, r.qtd_uso, count(*)
from app_cabeca a
inner join app_cab_remedio r on r.id = a.fk_remedio
group by fk_remedio, r.qtd_uso
order by 1
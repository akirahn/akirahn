insert into app_cab_episodio (fk_cabeca, hr_cabeca, fk_remedio, nr_grau, nr_grau_alivio)
select a.id_cabeca, a.hr_cabeca, coalesce(r.id, 9), a.nr_grau, a.nr_grau_alivio
from app_cabeca a
left join app_cab_remedio r on a.ds_remedio = r.ds_remedio
order by a.id_cabeca

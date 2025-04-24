SELECT r.id as reservation , u.name, r.status , s.title , d.id  as devis FROM reservations  r
                                                                                  join users u  on r.user_id = u.id
                                                                                  join services s on s.id = r.service_id
                                                                                  join devis  d on d.reservation_id = r.id
where u.id = 1


SELECT r.id as reservation , u.name, r.status , s.title , d.id  as devis FROM reservations  r
                                                                                  join users u  on r.user_id = u.id
                                                                                  join services s on s.id = r.service_id
                                                                                  left join devis  d on d.reservation_id = r.id
where u.id = 1

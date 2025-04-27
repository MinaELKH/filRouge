SELECT r.id as reservation , u.name, r.status , s.title , d.id  as devis FROM reservations  r
                                                                                  join users u  on r.user_id = u.id
                                                                                  join services s on s.id = r.service_id
                                                                                  join devis  d on d.reservation_id = r.id
where u.id = 1

// detail reservatio
SELECT r.id as reservation , u.name, r.status , s.title , d.id  as devis FROM reservations  r
                                                                                  join users u  on r.user_id = u.id
                                                                                  join services s on s.id = r.service_id
                                                                                  left join devis  d on d.reservation_id = r.id
where u.id = 1


// detail serivce
SELECT
    s.id as service_id,
    s.title,
    s.description,
    s.price,
    s.cover_image,
    s.gallery,
    s.archived,
    s.status,
    u.id as user_id,
    u.name as user_name,
    u.email as user_email,
    u.created_at as user_created_at,
    c.id as category_id,
    c.name as category_name,
    v.id as ville_id,
    v.name as ville_name
FROM services s
         JOIN users u ON s.user_id = u.id
         JOIN categories c ON s.category_id = c.id
         JOIN villes v ON s.ville_id = v.id
WHERE s.id = 20;

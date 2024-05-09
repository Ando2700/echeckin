CREATE
OR REPLACE VIEW v_event AS

SELECT
    e.id,
    e.eventname,
    e.datedebut,
    e.datefin,
    e.description,
    p.nomplace,
    et.eventtype
FROM
    events e
    INNER JOIN places p ON e.place_id = p.id
    INNER JOIN eventtypes et ON e.eventtype_id = et.id;

-- query for stat
        SELECT 
            e.id,
            e.eventname,
            COUNT(p.attendee_id) AS nombre_de_presences,
            COUNT(i.attendee_id) AS nombre_total_invites,
            ROUND((COUNT(p.attendee_id) * 100.0 / COUNT(i.attendee_id)), 2) AS pourcentage_presence
        FROM 
            events e
        JOIN 
            invitations i ON e.id = i.event_id
        LEFT JOIN 
            presences p ON i.event_id = p.event_id AND i.attendee_id = p.attendee_id
                    AND p.date_heure_presence BETWEEN e.datedebut AND e.datefin
        GROUP BY 
            e.id, e.eventname;
-- query for stat

-- show all event
        SELECT 
            e.id,
            e.eventname,
            COUNT(p.attendee_id) AS nombre_de_presences,
            COUNT(i.attendee_id) AS nombre_total_invites,
            CASE 
                WHEN COUNT(i.attendee_id) = 0 THEN 0
                ELSE ROUND((COUNT(p.attendee_id) * 100.0 / NULLIF(COUNT(i.attendee_id), 0)), 2)
            END AS pourcentage_presence
        FROM 
            events e
        LEFT JOIN 
            invitations i ON e.id = i.event_id
        LEFT JOIN 
            presences p ON i.event_id = p.event_id AND i.attendee_id = p.attendee_id
                    AND p.date_heure_presence BETWEEN e.datedebut AND e.datefin
        GROUP BY 
            e.id, e.eventname;
-- show all events
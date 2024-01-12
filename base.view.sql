CREATE OR REPLACE VIEW v_event AS
SELECT e.id, e.eventname, e.datedebut, e.datefin,e.description, p.nomplace, et.eventtype 
FROM events e
INNER JOIN places p ON e.place_id = p.id 
INNER JOIN eventtypes et ON e.eventtype_id = et.id;

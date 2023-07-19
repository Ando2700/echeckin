-- VIEW POUR DETAIL DES ACTES :  ok
CREATE OR REPLACE view v_detail_acte AS
SELECT d.facture_id, a.type_acte, d.montant  FROM detailfactures d
INNER JOIN actes a
ON d.acte_id = a.id;

SELECT * FROM v_detail_acte ;


-- ALL FACTURES :
SELECT  *  FROM patients p
INNER JOIN factures f ON p.id = f.patient_id
INNER JOIN detailfactures d ON f.id = d.facture_id
INNER JOIN actes a ON d.acte_id=a.id;

-- GOOD DETAILS FOR FACTURE ok
CREATE OR REPLACE VIEW v_detailfacture_patient AS 
SELECT  p.nom, f.date_facture, d.facture_id, d.montant, a.type_acte FROM patients p
INNER JOIN factures f ON p.id = f.patient_id
INNER JOIN detailfactures d ON f.id = d.facture_id
INNER JOIN actes a ON d.acte_id=a.id;
-----------------------------------------------------------------------------------------------
-- ILAINA @ RECETTE ok
CREATE OR REPLACE VIEW v_detail_facture AS 
SELECT f.date_facture, d.montant, a.type_acte, a.reference, a.budget, a.annee FROM patients p
INNER JOIN factures f ON p.id = f.patient_id
INNER JOIN detailfactures d ON f.id = d.facture_id
INNER JOIN actes a ON d.acte_id=a.id;

--RECETTE(vrai)
CREATE OR REPLACE VIEW v_recette AS
SELECT
    EXTRACT(MONTH FROM date_facture) AS mois,
    type_acte,
    budget,
    annee,
    round(sum(montant)) AS montant_total,
    round(sum(montant/budget)*100) AS realisation
FROM 
    v_detail_facture
GROUP BY mois, type_acte, budget, annee
ORDER BY mois, type_acte, budget, annee;

-----------------------------------------------------------------------------------------------
-- CHARGE ok
CREATE VIEW v_charge AS
SELECT id, montant_depense, depense_id,
    TO_DATE(CONCAT(jour, '-', mois, '-', annee), 'DD-MM-YYY') AS date
FROM charges;

SELECT*FROM v_charge;

CREATE VIEW charge_depense AS
select c.montant_depense, c.date, d.type_depense, d.reference, d.budget, d.annee
from v_charge c inner join 
depenses d on c.depense_id = d.id; 

select*from sum(d.montant_total) as montant_depense, sum(r.montant_total) as montant_recette, r.mois, r.annee v_depense d left join v_recette r on  r.mois = d.mois;

-- DEPENSE ok
CREATE OR REPLACE VIEW v_depense AS
SELECT
    EXTRACT(MONTH FROM date) AS mois,
    type_depense,
    budget,
    annee,
    round(sum(montant_depense)) AS montant_total,
    round(sum(montant_depense/budget)*100) AS realisation
FROM 
    charge_depense
GROUP BY mois, type_depense, budget, annee
ORDER BY mois, type_depense, budget, annee;

select*from v_depense;

-----------------------------------------------------------------------------------------------

-- CREATE OR REPLACE VIEW v_recette_mois AS
-- SELECT EXTRACT(MONTH FROM date_facture) AS mois, 
--        type_acte,
--        SUM(montant) AS montant_total
-- FROM v_detail_facture
-- GROUP BY mois, type_acte
-- ORDER BY type_acte, mois;

-- VIEW RECETTE 
-- CREATE OR REPLACE VIEW v_recette AS
-- SELECT type_acte, SUM(montant) as montant, date_facture FROM v_detail_facture
-- GROUP BY type_acte
-- ORDER BY type_acte;

-- SELECT*FROM v_recette r inner join actes d on r.type_acte=d.type_acte;

-- CREATE OR REPLACE VIEW v_recette_sum as
-- SELECT sum(montant) as recette FROM v_detail_facture; 

-- SELECT * FROM v_detailfacture_patient ;
-- SELECT * FROM v_recette_mois ;
-- SELECT * FROM v_recette ;

-- MONTANT TOTAL POUR CHAQUE FACTURE ET CHAQUE PATIENT : ok
CREATE OR REPLACE VIEW v_montant_total AS
SELECT  sum(montant) as montant_total, facture_id FROM detailfactures GROUP BY facture_id;

SELECT * FROM v_montant_total ;

-- CHARGE PAR TYPE DE DEPENSE : TSY IZY TSONY
CREATE OR REPLACE VIEW v_type_charge AS
SELECT dep.type_depense, c.montant_depense, c.date_depense FROM charges c
INNER JOIN depenses dep ON c.depense_id = dep.id; 

SELECT * FROM v_type_charge ;

-- SOMME DES DEPENSE : TSY IZY TSONY
CREATE OR REPLACE VIEW v_somme_charge AS
SELECT sum(montant_depense) AS somme_charge FROM v_type_charge;
select*from v_somme_charge;

-- CHARGE PAR DEPENSE FOTSINY VAOVAO :
CREATE OR REPLACE VIEW v_type_charge AS
SELECT c.jour, c.mois, c.annee, c.montant_depense, dep.reference, dep.type_depense FROM charges c
INNER JOIN depenses dep ON c.depense_id = dep.id; 
select*from v_type_charge;
-- DEPENSE AVEC DATE
CREATE VIEW v_charge_date AS
SELECT id, montant_depense, depense_id,
    TO_DATE(CONCAT(jour, '-', mois, '-', annee), 'DD-MM-YYY') AS date
FROM charges;
select*from v_charge_date;

-- LISTE CHARGE POUR AVOIR LES DATE
CREATE OR REPLACE VIEW v_saisie_depense AS
SELECT ch.montant_depense, ch.date, d.type_depense, d.reference FROM 
v_charge ch INNER JOIN depenses d
ON ch.depense_id = d.id;
select*from v_saisie_depense;

-- RECETTE
select*from consulation


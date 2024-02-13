--Pour tarif et cout

        --Operation vrai détaillé

create or replace view operationvrai_detail as
select sum(capacite_panneau) as panneau,
    sum(groupe) as groupe,
    sum(jirama_capacite_max) as jirama,
    sum(resultat_Consommation) as consommation,
    sum(coutGroupe)+sum(coutJirama) as operation,
    (SELECT tarifenwatt FROM panneausolaire LIMIT 1) as tarif_panneau,
    (select sum(operationvrai.coutgroupe) from operationvrai) as tarif_groupe,
    (select sum(operationvrai.coutjirama) from operationvrai) as tarif_jirama,
    (sum(coutGroupe)+sum(coutJirama) + (SELECT tarifenwatt FROM panneausolaire LIMIT 1)) as total_conso
from operationVrai;


        --Operation vrai

CREATE or REPLACE view operationVrai as
SELECT
    vdc.heure,
    vdc.resultat_consommation,
    vdc.capacite_panneau,
    COALESCE(
        CASE
            WHEN vdc.groupe IS NOT NULL AND vdc.groupe <> 0
                THEN vdc.groupe_consoparlitreheure * vdc.groupe_prixessence
            ELSE
                NULL
        END, 0) AS coutGroupe,
    COALESCE(
        CASE
            WHEN vdc.jirama_capacite_max IS NOT NULL AND vdc.jirama_capacite_max <> 0
                THEN vdc.jirama_capacite_max * vdc.jirama_coutparwatt
            ELSE
                NULL
        END, 0) AS coutJirama,
    vdc.groupe_consoparlitreheure,
    vdc.groupe,
    vdc.groupe_prixessence,
    vdc.jirama_capacite_max,
    vdc.jirama_coutparwatt
FROM
    operation vdc
CROSS JOIN
    groupe g
CROSS JOIN
    jirama j ;


--Pour home: le tableau de produit et consommation

        --V_combined

CREATE OR REPLACE VIEW V_combined AS
SELECT
    hcpd.heure,
    hpgj.capacite_panneau,
    hpgj.groupe,
    hpgj.jirama_capacite_max,
    hpgj.production,
    hcpd.resultat_consommation,
    hcpd.pourcentage_pourcentage
FROM
    heure_conso_prod_detail hcpd
JOIN
    V_heure_panneau_groupe_jirama hpgj ON hcpd.heure = hpgj.heure;

            --Heure prod


CREATE OR REPLACE VIEW heure_prod_detail AS
SELECT
    hcp.heure,
    hcp.production,
    vp.pourcentage_heure_debut,
    vp.pourcentage_heure_fin,
    vp.panneau_capacite_max,
    vp.pourcentage_pourcentage,
    vp.groupe_capacite_max,
    vp.jirama_capacite_max,
    vp.capacite_panneau,
    vp.somme as resultat_production,
     CASE
        WHEN hcp.heure < '08:00:00'::TIME THEN
            0 
        WHEN  ('08:00:00'::TIME + (g.capacitereservoir / g.consoParLitreHeure) * INTERVAL '1 hour') <= hcp.heure THEN
            0
        ELSE
            g.capacitemax
 END as groupe
FROM
    heure_prod hcp
JOIN
    V_production vp ON hcp.production = vp.id
    CROSS JOIN Groupe g
ORDER BY
    hcp.heure;



            --meme chose mais rectifier

CREATE OR REPLACE VIEW heure_prod_detail AS
SELECT
    hcp.heure,
    hcp.production,
    vp.pourcentage_heure_debut,
    vp.pourcentage_heure_fin,
    vp.panneau_capacite_max,
    vp.pourcentage_pourcentage,
    vp.groupe_capacite_max,
    vp.jirama_capacite_max,
    vp.capacite_panneau,
    vp.somme as resultat_production,
     CASE
        WHEN hcp.heure < '08:00:00'::TIME THEN
            0 
        WHEN  ('08:00:00'::TIME + (g.capacitereservoir / g.consoParLitreHeure) * INTERVAL '1 hour') <= hcp.heure THEN
            0
        ELSE
            g.capacitemax
 END as groupe
FROM
    heure_prod hcp
JOIN
    V_production vp ON hcp.production = vp.id
    CROSS JOIN Groupe g
ORDER BY
    hcp.heure;

            --Heure prod detail avec coupure jirama

create or replace view heure_prod_detail_coupure as
SELECT
    hpd.*,
    CASE
        WHEN cj.id IS NOT NULL THEN 1
        ELSE 0
    END AS coupure,
    CASE
        WHEN cj.id IS NOT NULL THEN 0
        ELSE vp.jirama_capacite_max
    END AS jirama_coupure
FROM
    heure_prod_detail hpd
LEFT JOIN
    CoupureJirama cj ON hpd.heure BETWEEN cj.heureDebut AND cj.heureFin
LEFT JOIN
    V_production vp ON hpd.production = vp.id
ORDER BY
    hpd.heure;

create database panneausolaire;
GRANT ALL PRIVILEGES ON DATABASE panneausolaire TO gestion;
\c panneausolaire gestion;


create table admin(
        id serial primary key ,
        email varchar(120)  ,
        motdepasse varchar(120)
);
--insert into admin(email,motdepasse) values('admin@admin','admin1');

create table PanneauSolaire(
                          id serial primary key ,
                          capaciteMax double precision,
                          tarifEnWatt double precision,
                          label varchar(250)
);

--insert into panneausolaire(capaciteMax,tarifEnWatt,label) values(200,500,'Panneau');

create table PourcentagePanneauSolaire(
                          id serial primary key ,
                          id_panneau int references panneausolaire(id) ,
                          heureDebut time,
                          heureFin time,
                          pourcentage double precision
);

/*insert into PourcentagePanneauSolaire(id_panneau,heureDebut,heureFin,pourcentage) values(1,'08:00:00','11:00:00',100);
insert into PourcentagePanneauSolaire(id_panneau,heureDebut,heureFin,pourcentage) values(1,'11:00:00','14:00:00',100);
insert into PourcentagePanneauSolaire(id_panneau,heureDebut,heureFin,pourcentage) values(1,'14:00:00','17:00:00',100);*/


create table Groupe(
                           id serial primary key,
                           capaciteMax double precision,
                           capaciteReservoir double precision,
                           consoParLitreHeure double precision,
                           prixEssence double precision,
                           label varchar(250)
);

--insert into groupe(capaciteMax,capaciteReservoir,consoParLitreHeure,prixEssence,label) values(300,5,1,600,'Groupe');

create table Jirama(
            id serial primary key,
            coutParWatt double precision,
            capaciteMax double precision
);

--insert into Jirama(coutParWatt,capaciteMax) values(100,200);

create table CoupureJirama(
    id serial primary key ,
    id_jirama int references Jirama(id),
    heureDebut time,
    heureFin time
);
insert into coupurejirama(id_jirama,heureDebut, heurefin) values(1,'14:00:00','16:00:00');
delete from coupurejirama where id = 


create table EleveParTrancheHoraire(
    id serial primary key,
    heuredebut time,
    heurefin time,
    nombre int
);

/*
create table disponible(
  id serial primary key,
  total double precision,
  heure time
);*/


create table consommation(
    id serial primary key,
    nombreEleve int,
    puissanceMachine double precision,
    consoFixe double precision
);

--View sy ny tariny

--Pour panneau
create or replace view v_panneau as
SELECT PourcentagePanneauSolaire.*, PanneauSolaire.capaciteMax, PanneauSolaire.tarifEnWatt, PanneauSolaire.label
FROM PourcentagePanneauSolaire
JOIN PanneauSolaire ON PourcentagePanneauSolaire.id_panneau = PanneauSolaire.id;


--All table

CREATE or replace view TableRassemblee AS
SELECT
    ps.id AS panneau_id,
    ps.capaciteMax AS panneau_capacite_max,
    ps.tarifEnWatt AS panneau_tarif_en_watt,
    ps.label AS panneau_label,
    pps.id AS pourcentage_id,
    pps.id_panneau AS pourcentage_id_panneau,
    pps.heureDebut AS pourcentage_heure_debut,
    pps.heureFin AS pourcentage_heure_fin,
    pps.pourcentage AS pourcentage_pourcentage,
    g.id AS groupe_id,
    g.capaciteMax AS groupe_capacite_max,
    g.capaciteReservoir AS groupe_capacite_reservoir,
    g.consoParLitreHeure AS groupe_conso_par_litre_heure,
    g.prixEssence AS groupe_prix_essence,
    g.label AS groupe_label,
    j.id AS jirama_id,
    j.coutParWatt AS jirama_cout_par_watt,
    j.capaciteMax AS jirama_capacite_max
FROM
    PanneauSolaire ps
    LEFT JOIN PourcentagePanneauSolaire pps ON ps.id = pps.id_panneau
    LEFT JOIN Groupe g ON 1=1 -- Ajoutez vos conditions de jointure ici
    LEFT JOIN Jirama j ON 1=1; -- Ajoutez vos conditions de jointure ici


--avoir les heures

create or replace view heure as
 WITH RECURSIVE HeuresMinMax AS (
     SELECT
         MIN(pourcentage_heure_debut) AS min_heure,
         MAX(pourcentage_heure_fin) AS max_heure
     FROM TableRassemblee
 ),
 HeuresIntervalle AS (
     SELECT min_heure AS heure FROM HeuresMinMax

     UNION ALL

     SELECT (heure + INTERVAL '1 hour') AS heure
     FROM HeuresIntervalle, HeuresMinMax
     WHERE heure < (max_heure - INTERVAL '1 hour')
 )

 SELECT DISTINCT heure
 FROM HeuresIntervalle
 ORDER BY heure;

--avoir la consommation heure normal

CREATE OR REPLACE VIEW CalculConsommationNormal AS
SELECT
    c.id AS consommation_id,
    c.nombreEleve AS nombre_eleve,
    c.puissanceMachine AS puissance_machine2,
    c.consoFixe AS conso_fixe,
    (c.nombreEleve * c.puissanceMachine) + c.consoFixe AS resultat_consommation
FROM
    Consommation c;

--avoir la consommation entre midi-2

CREATE OR REPLACE VIEW CalculConsommationMidiDeux AS
SELECT
    e.id AS eleve_id,
    e.heuredebut,
    e.heurefin,
    (e.nombre * c.nombreEleve)/100 AS nombre_eleve,
    c.puissanceMachine AS puissance_machine,
    c.consofixe,
    ((e.nombre * c.nombreEleve)/100 * c.puissanceMachine) + c.consofixe AS resultat
FROM
    EleveParTrancheHoraire e
-- Ajoutez vos conditions de jointure ici
JOIN
    consommation c ON 1=1; 
    
    -- Ajoutez vos conditions de jointure ici;

create or replace view Consommationtable as
SELECT
    'Normal' AS type,
    consommation_id,
    nombre_eleve,
    puissance_machine2 AS puissance_machine,
    conso_fixe,
    resultat_consommation
FROM
    CalculConsommationNormal

UNION ALL

SELECT
    'MidiDeux' AS type,
    eleve_id,
    nombre_eleve,
    puissance_machine,
    consofixe,
    resultat
FROM
    CalculConsommationMidiDeux;

    --On a le tableau heure-Consommation

CREATE OR REPLACE VIEW heure_conso AS
SELECT
    h.heure,
    CASE
        WHEN h.heure < '12:00:00' OR h.heure >= '14:00:00' THEN 'Normal'
        ELSE 'MidiDeux'
    END AS type
FROM
    heure h
JOIN
    Consommationtable ct ON 1=1
GROUP BY
    h.heure,
    CASE
        WHEN h.heure < '12:00:00' OR h.heure >= '14:00:00' THEN 'Normal'
        ELSE 'MidiDeux'
    END
ORDER BY
    h.heure;

    --Affichage tableau détail heure-consommation
CREATE OR REPLACE VIEW heure_conso_detail AS
SELECT
    hc.heure,
    hc.type,
    ct.nombre_eleve,
    ct.puissance_machine,
    ct.conso_fixe,
    ct.resultat_consommation
FROM
    heure_conso hc
JOIN
    Consommationtable ct ON hc.type = ct.type
ORDER BY
    hc.heure;



---Production
CREATE OR REPLACE VIEW V_production AS
SELECT
    ROW_NUMBER() OVER () AS id,
    pourcentage_heure_debut,
    pourcentage_heure_fin,
    panneau_capacite_max,
    pourcentage_pourcentage,
    groupe_capacite_max,
    jirama_capacite_max,
    ((pourcentage_pourcentage * panneau_capacite_max)/100) AS capacite_panneau,
    groupe_capacite_max + jirama_capacite_max + ((pourcentage_pourcentage * panneau_capacite_max)/100) AS somme
FROM
    TableRassemblee;


---Correction V_production

CREATE OR REPLACE VIEW V_production AS
SELECT
    pourcentage_id as id,
    pourcentage_heure_debut,
    pourcentage_heure_fin,
    panneau_capacite_max,
    pourcentage_pourcentage,
    groupe_capacite_max,
    jirama_capacite_max,
    ((pourcentage_pourcentage * panneau_capacite_max)/100) AS capacite_panneau,
    groupe_capacite_max + jirama_capacite_max + ((pourcentage_pourcentage * panneau_capacite_max)/100) AS somme
FROM
    TableRassemblee
order by
    pourcentage_id;

--Production_heure

CREATE OR REPLACE VIEW heure_prod AS
    SELECT
        h.heure,
        CASE
            WHEN h.heure < '11:00:00' THEN 1
            WHEN h.heure >= '14:00:00' THEN 3
            ELSE 2
        END AS production,  -- Utilisez simplement un alias sans le AS
        CASE
            WHEN h.heure < '12:00:00' OR h.heure >= '14:00:00' THEN 'Normal'
            ELSE 'MidiDeux'
        END AS type
    FROM
        heure h
    JOIN
        Consommationtable ct ON 1=1
    JOIN
        V_production vp ON h.heure = h.heure
    Group BY
        h.heure,
        CASE
            WHEN h.heure < '11:00:00' THEN 1
            WHEN h.heure >= '14:00:00' THEN 3
            ELSE 2
        END,
        CASE
            WHEN h.heure < '12:00:00' OR h.heure >= '14:00:00' THEN 'Normal'
            ELSE 'MidiDeux'
        END
    ORDER BY
        h.heure;


--Affichage tableau détail heure-production
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
group by
    
ORDER BY
    hcp.heure;

-- production avec coupure

CREATE OR REPLACE VIEW heure_prod_detail_coupure AS
SELECT
    hpd.*,
    CASE
        WHEN cj.id IS NOT NULL THEN 1
        ELSE 0
    END AS coupure
FROM
    heure_prod_detail hpd
LEFT JOIN
    CoupureJirama cj ON hpd.heure BETWEEN cj.heureDebut AND cj.heureFin
ORDER BY
    hpd.heure;

                                        --avec jirama_coupure
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

--Affichage tableau détail heure-production
CREATE OR REPLACE VIEW heure_conso_prod_detail AS
SELECT
    hcp.heure,
    hcp.production,
    hcp.type,
    ct.nombre_eleve,
    ct.puissance_machine,
    ct.conso_fixe,
    ct.resultat_consommation,
    vp.pourcentage_heure_debut,
    vp.pourcentage_heure_fin,
    vp.panneau_capacite_max,
    vp.pourcentage_pourcentage,
    vp.groupe_capacite_max,
    vp.jirama_capacite_max,
    vp.capacite_panneau,
    vp.somme as resultat_production

FROM
    heure_prod hcp
JOIN
    V_production vp ON hcp.production = vp.id
JOIN
    Consommationtable ct ON hcp.type = ct.type
ORDER BY
    hcp.heure;




---Aleaaa

---heure et groupe_combinnee

CREATE OR REPLACE VIEW V_heure_groupe AS
WITH RECURSIVE HeuresMinMax AS (
    SELECT
        MIN(pourcentage_heure_debut) AS min_heure,
        MAX(pourcentage_heure_fin) AS max_heure
    FROM TableRassemblee
),
    HeuresIntervalle AS (
    SELECT min_heure AS heure FROM HeuresMinMax
    UNION ALL
    SELECT (heure + INTERVAL '1 hour') AS heure
    FROM HeuresIntervalle, HeuresMinMax
    WHERE heure < (max_heure - INTERVAL '1 hour')
)

 -- Sélectionner les heures générées et les données de la table Groupe
 SELECT DISTINCT hi.heure,
 CASE
     WHEN  ('08:00:00'::TIME + (g.capacitereservoir / g.consoParLitreHeure) * INTERVAL '1 hour') <= hi.heure THEN
         0
     ELSE
         g.capacitemax
 END as groupe,
 g.capaciteReservoir, g.consoParLitreHeure, g.prixEssence, g.label
 FROM HeuresIntervalle hi
 CROSS JOIN Groupe g
 ORDER BY hi.heure;





 --Somme des trois COMMENT

 
CREATE OR REPLACE VIEW V_heure_panneau_groupe_jirama AS
SELECT
    hcp.heure,
    vp.capacite_panneau,
    CASE
        WHEN ('08:00:00'::TIME + (g.capacitereservoir / g.consoParLitreHeure) * INTERVAL '1 hour') <= hcp.heure THEN
            0
        ELSE
            g.capacitemax
    END AS groupe,
    vp.jirama_capacite_max,
    (vp.capacite_panneau + 
        CASE
            WHEN ('08:00:00'::TIME + (g.capacitereservoir / g.consoParLitreHeure) * INTERVAL '1 hour') <= hcp.heure THEN
                0
            ELSE
                g.capacitemax
        END +
        vp.jirama_capacite_max
    ) AS production
FROM
    heure_prod hcp
JOIN
    V_production vp ON hcp.production = vp.id
CROSS JOIN Groupe g
ORDER BY
    hcp.heure;

--

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




---Vue pour avoir detail prod

CREATE OR REPLACE VIEW heure_conso_prod_detail2 AS
SELECT
    hcp.heure,
    hcp.production,
    hcp.type,
    ct.nombre_eleve,
    ct.puissance_machine,
    ct.conso_fixe,
    ct.resultat_consommation,
    vp.pourcentage_heure_debut,
    vp.pourcentage_heure_fin,
    vp.panneau_capacite_max,
    vp.pourcentage_pourcentage,
    vp.groupe_capacite_max,
    vp.jirama_capacite_max,
    vp.capacite_panneau,
    vp.somme as resultat_production,
    vc.production as production_res,
    vc.groupe

FROM
    heure_prod hcp
JOIN
    V_production vp ON hcp.production = vp.id
JOIN
    Consommationtable ct ON hcp.type = ct.type
JOIN
    V_combined vc on hcp.heure = vc.heure
ORDER BY
    hcp.heure;


--Calcul cout consommation

CREATE OR REPLACE VIEW heure_conso AS
SELECT
    heure,
    resultat_consommation
FROM
    heure_conso_prod_detail;



----Consommation
CREATE OR REPLACE VIEW heure_conso_detail_complet AS
SELECT
    hc.heure,
    hc.type,
    ct.nombre_eleve,
    ct.puissance_machine,
    ct.conso_fixe,
    ct.resultat_consommation
FROM
    heure_conso hc
JOIN
    Consommationtable ct ON hc.type = ct.type
ORDER BY
    hc.heure;

create or replace view v_conso_calcul as
select 
    panneau_capacite_max,
    panneau_tarif_en_watt,
    groupe_capacite_max,
    groupe_capacite_reservoir,
    groupe_conso_par_litre_heure,
    groupe_prix_essence,
    jirama_cout_par_watt,
    jirama_capacite_max
FROM
    TableRassemblee
GROUP BY
    panneau_capacite_max,panneau_tarif_en_watt,groupe_capacite_max,groupe_capacite_reservoir,
    groupe_conso_par_litre_heure,groupe_prix_essence,jirama_cout_par_watt,jirama_capacite_max;


    ---Vue pour la consommation calcul

CREATE OR REPLACE VIEW v_detail_prod AS
SELECT 
heure, 
vc.resultat_Consommation, 
capacite_panneau as capacite_panneauMax,

(CASE 
	WHEN vc.resultat_Consommation < capacite_panneau -- si conso < P
		THEN vc.resultat_Consommation -- capacite_panneau
	WHEN vc.resultat_Consommation >= capacite_panneau  -- si conso >= P
		THEN capacite_panneau -- P
END) AS capacite_panneau,

(CASE 
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)  < Groupe -- si reste < G 
		THEN (vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)) -- reste
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END) >= Groupe -- si reste >= G
		THEN Groupe -- G
END) AS groupe,

(CASE
	WHEN vc.resultat_Consommation - ((CASE 
	WHEN vc.resultat_Consommation < capacite_panneau -- si conso < P
		THEN vc.resultat_Consommation -- capacite_panneau
	WHEN vc.resultat_Consommation >= capacite_panneau  -- si conso >= P
		THEN capacite_panneau -- P
END) + (CASE 
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)  < Groupe -- si reste < G 
		THEN (vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)) -- reste
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END) >= Groupe -- si reste >= G
		THEN Groupe -- G
END)) < jirama_capacite_max
		THEN vc.resultat_Consommation - ((CASE 
	WHEN vc.resultat_Consommation < capacite_panneau -- si conso < P
		THEN vc.resultat_Consommation -- capacite_panneau
	WHEN vc.resultat_Consommation >= capacite_panneau  -- si conso >= P
		THEN capacite_panneau -- P
END) + (CASE 
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)  < Groupe -- si reste < G 
		THEN (vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)) -- reste
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END) >= Groupe -- si reste >= G
		THEN Groupe -- G
END))
	WHEN vc.resultat_Consommation - ((CASE 
	WHEN vc.resultat_Consommation < capacite_panneau -- si conso < P
		THEN vc.resultat_Consommation -- capacite_panneau
	WHEN vc.resultat_Consommation >= capacite_panneau  -- si conso >= P
		THEN capacite_panneau -- P
END) + (CASE 
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)  < Groupe -- si reste < G 
		THEN (vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END)) -- reste
	WHEN vc.resultat_Consommation - (CASE 
			WHEN vc.resultat_Consommation < capacite_panneau 
				THEN vc.resultat_Consommation
			WHEN vc.resultat_Consommation >= capacite_panneau 
				THEN capacite_panneau
			END) >= Groupe -- si reste >= G
		THEN Groupe -- G
END)) > jirama_capacite_max
		THEN jirama_capacite_max 
END) as jirama_capacite_max
FROM v_combined vc
GROUP BY heure, vc.resultat_Consommation, capacite_panneau, Groupe, jirama_capacite_max
ORDER BY heure;



--Cout



CREATE or REPLACE view operation as
SELECT
    vdc.heure,
    vdc.resultat_Consommation,
    vdc.capacite_panneau,
    vdc.jirama_capacite_max,
    j.coutparwatt AS jirama_coutparwatt,
    vdc.groupe,
    g.consoparlitreheure AS groupe_consoparlitreheure,
    g.prixessence AS groupe_prixessence
    
FROM
    v_detail_prod vdc
CROSS JOIN
    groupe g
CROSS JOIN
    jirama j;



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

select sum(coutGroupe)+sum(coutJirama) as operation from operationVrai;

SELECT tarifenwatt FROM panneausolaire LIMIT 1;

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
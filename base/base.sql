create database jiro;
	alter database jiro owner to dre;

	--drop table energie
	create table energie 
	(
		id serial primary key,
		designation varchar(20)
	);

	--drop table panneau;
	create table panneau 
	(
		id serial primary key,
		idenergie int,
		capacitemax decimal(25,2),
		pourcentageun decimal(5,2),
		pourcentagedeux decimal(5,2),
		pourcentagetrois decimal(5,2),
		tarif decimal (25,2),
		isdeleted boolean default false
	);

	create table groupe
	(
		id serial primary key ,
		capacitemax decimal (25,2),
		capacitereservoir decimal(25,2),
		consoparheur decimal(25,2),
		prixLittre decimal(25,2),
		isdeleted boolean default false 
	);

	create table jirama
	(
		id serial primary key,
		capacitemax decimal(25,2),
		tarif decimal(25,2)
	);

	create table etudiant 
		(
			id serial primary  key,
		 	debut int , 
		 	fin int ,
	 	 	pourcentage decimal (5,2)
 	 	);


	alter table panneau add foreign key ( idenergie) references energie(id);

	insert into energie (id , designation) values (1,'panneau'),(2,'groupe'),(3,'jirama') ;
	insert into panneau (idenergie,capacitemax,tarif,pourcentageun,pourcentagedeux,pourcentagetrois) 
		values ( 1,5000,5,70,100,60);
	insert into jirama (capacitemax,tarif) values (5000,5);
	insert into etudiant (debut , fin , pourcentage) values (12,14,25);	

	--drop table trancheHeure
	create table trancheHeure 
	(
		id serial primary key,
		debut int,
		fin int ,
		pourcentage decimal(5,2)
	);

	create table CONSO
	(
		id serial primary key ,
		nbelevetot int ,
		caplaptop decimal(25,2) default 0,
		capfixe decimal(25,2) default 0,
		pourceleve decimal(5,2) default 0
	);

--xxx
	insert into CONSO (nbelevetot,caplaptop,capfixe,pourceleve) values ( 150, 750, 5000,15);

	insert into trancheHeure (debut,fin,pourcentage) values 
		(08,11,70),
		(11,14,100),
		(14,16,60);

	insert into groupe (capacitemax,capacitereservoir,consoparheur,prixLittre)
		values
		(400,50,5,5000);

select  generate_series(8,17) as heure ;


-- PRODUCTION jirama
select 
	gs.heure as heure,
	j.capacitemax AS puissanceProdJ
	
	from jirama j

	cross join 

	generate_series(8,17) as gs(heure)

	;

-- PRODUCTION groupe
select 
	gs.heure as heure,
	g.capacitemax AS puissanceProdG
	
	from groupe g

	cross join 

	generate_series(8,17) as gs(heure)

	;

--production panneau
select 
	gs.heure as heure,
	p.capacitemax as puissanceMax,
	CASE 
		WHEN gs.heure >= 8 and gs.heure <= 11 THEN
			(( p.capacitemax * 70)/100)
		WHEN gs.heure > 11 and gs.heure <= 14 THEN
			(p.capacitemax )
		WHEN gs.heure > 14 and gs.heure <=17 THEN
			(( p.capacitemax * 60)/100)
			
	END AS puissanceProdP

	
	
	from panneau p

	cross join 
	generate_series(8,17) as gs(heure)


	;
--
--production panneau ray
-- -- 
create or replace VIEW prodpanneau
as	(
select 
	gs.heure as heure,
	p.capacitemax as puissanceMax,

	CASE 
		WHEN gs.heure >= 8 and gs.heure < 11 THEN
			(( p.capacitemax * p.pourcentageun)/100)
		WHEN gs.heure >= 11 and gs.heure < 14 THEN
			(( p.capacitemax * p.pourcentagedeux)/100)
		WHEN gs.heure >= 14 and gs.heure <=16 THEN
			(( p.capacitemax * p.pourcentagetrois)/100)
			
	END AS puissanceProdP

	
	
	from panneau p

	cross join 
	generate_series(8,16) as gs(heure)
	);

--  drop view PRODUCTION 

create or replace VIEW production as
 	(
 	select 

		p.heure ,
--ty no miala raha tsotra
		CASE 
			WHEN  (8 +(g.capacitereservoir / g.consoparheur ) ) < p.heure THEN
				(p.puissanceprodp + j.capacitemax) 
			ELSE
			(p.puissanceprodp + g.capacitemax + j.capacitemax) --mijanona

		END as production,
		
		p.puissanceprodp as panneau,
		
--ty ko		
		CASE 
			WHEN  (8 + (g.capacitereservoir / g.consoparheur ) ) < p.heure THEN
			0
			ELSE 
		g.capacitemax --mijanona
		END as groupe,

		j.capacitemax as jirama
		from prodpanneau p cross join groupe g
		cross join jirama j
	);

--PRODUCTION GROUPE FIANDRY TSOTRA TSY METY LANY RESERVOIR 
-- -- drop view production
-- create or replace VIEW production as
--  	(
--  	select 

-- 		p.heure ,

-- 			(p.puissanceprodp + g.capacitemax + j.capacitemax) --mijanona

-- 		as production,
		
-- 		p.puissanceprodp as panneau,
		
-- --ty ko		

-- 		g.capacitemax --mijanona
-- 		 as groupe,

-- 		j.capacitemax as jirama
-- 		from prodpanneau p cross join groupe g
-- 		cross join jirama j
-- 	);

--xxx

-- drop view CONSOMATION
create or replace VIEW CONSOMATION as 
	(
select 
	gs.heure,

	CASE
		WHEN
		 gs.heure >= 8 and gs.heure < 11 THEN
			( c.caplaptop * c.nbelevetot ) + (c.capfixe)
		WHEN 
		  gs.heure >= 11 and gs.heure < 14 THEN	
			(( c.nbelevetot * c.pourceleve / 100 ) * c.caplaptop) + (c.capfixe)
		WHEN 
		 gs.heure >= 14 and gs.heure <=16 THEN 
		 	(c.nbelevetot * c.caplaptop ) +c.capfixe

	END as consomation ,
	c.nbelevetot nbeleve,

	CASE 
		WHEN
		  gs.heure >= 12 and gs.heure <= 14 THEN	
			c.pourceleve  
		ELSE
			100.00 
		END AS eleverest ,
	c.caplaptop puisslap,
	c.capfixe consfixe

	from 
		conso c 
	cross join
		generate_series(8,16) as gs(heure)
	);


	-- cross join 
	-- 	consomation 

	-- group by heure,c.nbelevetot, 

-- nbeleve, eleverestant, puisslaptop,consofixe
-- CONSO GROUPE FIANDRY

-- PRODCONSO
create or replace VIEW  prodconso as
(
	select
	p.heure ,

coalesce( p.production ,0) as production, 
coalesce( c.consomation,0) as consomation
	

	from consomation c

	full join production p on p.heure =  c.heure
);


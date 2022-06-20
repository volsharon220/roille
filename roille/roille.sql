drop database if exists roille;
create database roille;
use roille;



DROP TABLE IF EXISTS client;
CREATE TABLE IF NOT EXISTS client(
id_client int auto_increment,
avatar varchar(50) null,
nom varchar(50) NOT NULL,
mdp varchar(50) NOT NULL,
addresse varchar(250) NOT NULL,
codeP char(10) NOT NULL,
ville varchar(40) NOT NULL,
pays varchar(20) DEFAULT NULL,
phone char(10) NOT NULL,
mail varchar(50) NOT NULL,
roleClient int NULL,
constraint pk_customer PRIMARY KEY (id_client)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS particulier;
CREATE TABLE IF NOT EXISTS particulier (
id_client int auto_increment,
avatar varchar(50) null,
nom varchar(50) not null,
prenom varchar(50) not null,
mdp varchar(50) not null,
addresse varchar(250) not null,
codeP char(10) not null,
ville varchar(40) not null,
pays varchar(20) not null,
phone char(10) not null,
mail varchar(50) not null,
PRIMARY KEY (id_client)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS professionnel;
CREATE TABLE IF NOT EXISTS professionnel (
id_client int(11) not null auto_increment,
avatar varchar(50) null,
nom varchar(50) not null,
mdp varchar(50) not null,
addresse varchar(250) not null,
codeP char(10) not null,
ville varchar(40) not null,
pays varchar(20) not null,
phone char(10) not null,
mail varchar(50) not null,
numSiret int(70) not null,
statut_juridique varchar(50) not null,
PRIMARY KEY (id_client)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS commande;
CREATE TABLE IF NOT EXISTS commande(
id_com int(11) NOT NULL auto_increment,
mtht decimal(12,2)default 0 ,
tva decimal(10,2) default 0,
mttc decimal(12,2) default 0,
date_comm datetime not null,
date_commliv datetime not null,
etat_comm set('valider','en attente','annuler'),
id_client int(11) NOT NULL,
constraint pk_order PRIMARY KEY (id_com),
foreign key (id_client) references client (id_client)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories(
id_categorie int(11) NOT NULL auto_increment,
imagec varchar(150) not null,
nom varchar(250) NOT NULL unique,
descc varchar (250) not null,
constraint pk_categories primary key (id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS produit;
CREATE TABLE IF NOT EXISTS produit(
id_produit int(11) NOT NULL auto_increment,
imagep varchar(150) not null,
nomp varchar(50) NOT NULL,
descpUn text NOT NULL,
descpDeux text NOT NULL,
prixUnite decimal(10,2) NOT NULL,
charge decimal(10,2) default NULL,
hauteurTravail decimal(10,2) default NULL,
largeur decimal(10,2) default NULL,
longueur decimal(10,2) default NULL,
environnementTravail varchar(20) default null,
energie decimal(10,2) default null,
puissance decimal(10,2) default null,
poids decimal(10,2) default null,
ref varchar(20) default null,
quantestock int not null,
nomcat varchar(150) not null,
constraint pk_productt primary key (id_produit),
foreign key (nomcat) references categories (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







DROP TABLE IF EXISTS detail_com;
CREATE TABLE IF NOT EXISTS detail_com(
quantite_com int(50) NOT NULL,
id_com integer not null auto_increment,
id_produit int(11) not null,
dateD date,
dateF date ,
constraint pk_detailsOrder primary key (id_com,id_produit),
foreign key (id_com) references commande (id_com), 
foreign key (id_produit) references produit (id_produit)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







drop table if exists bon_commande;
create table if not exists bon_commande(
id_bonComm int(11) not null auto_increment,
id_com integer not null,
constraint pk_deliveryNote primary key (id_bonComm),
foreign key (id_com) references commande (id_com)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







drop table if exists detail_livraison;
create table if not exists detail_livraison(
id_bonCom int(20) not null,
id_produit int(20) not null,
quantityLiv int(20) not null,
constraint pk_detailsDelivery PRIMARY KEY (id_bonCom,id_produit),
foreign key (id_bonCom) references bon_commande (id_bonComm),
foreign key (id_produit) references produit (id_produit)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







create table archiComm as
select * , sysdate() date_histo from commande
where 2=0;
alter table archiComm
add primary key (id_com);



-- Création de la table Erreur
drop table if exists Erreur;
CREATE TABLE Erreur (
id int(10) AUTO_INCREMENT PRIMARY KEY,
erreur VARCHAR(250));

/*
trigger pour l'ajout d'un professionnel
*/
drop trigger if exists ajout_professionnel ;
delimiter //
create trigger ajout_professionnel 
before insert on professionnel 
for each row  
begin 
declare x,e int ;
select max(id_client) into x 
from particulier;
if x =0
then 
set  x= 1;
else
set new.id_client= x+1;  
end if;
insert into client values (new.id_client,null,new.nom,new.mdp,new.addresse,
new.codeP,new.ville,new.pays,new.phone,new.mail,null);
end //
delimiter ;







/*
trigger pour l'ajout d'un particulier
*/
drop trigger if exists ajout_particulier ;
delimiter //
create trigger ajout_particulier 
before insert on particulier 
for each row  
begin 
declare a,x,e int ;
select max(id_client) into x 
from professionnel;
if x =0
then 
set  x= 1;
else
set new.id_client= x+1;  
end if;
insert into client values (new.id_client,null,new.nom,new.mdp,new.addresse,new.codeP,
new.ville,new.pays,new.phone,new.mail,null);
end //
delimiter ;






/*
trigger pour la mise à jour de la table client une fois que la table particulier est modifiée
*/
drop trigger if exists updatParticulier;
delimiter //
create trigger updatParticulier
after update on particulier
for each row
begin
update client
set 
id_client=new.id_client,
avatar=new.avatar,
nom=new.nom,
mdp=new.mdp,
addresse=new.addresse,
codeP=new.codeP,
ville=new.ville,
pays=new.pays,
phone=new.phone,
mail=new.mail,
roleClient=null
where id_client=old.id_client;
end //
delimiter ;







/*
trigger pour la mise à jour de la table client une fois que la table professionnel est modifiée
*/
drop trigger if exists updatProfessionnel;
delimiter //
create trigger updatProfessionnel
after update on professionnel
for each row
begin
update client
set 
id_client=new.id_client,
avatar=new.avatar,
nom=new.nom,
mdp=new.mdp,
addresse=new.addresse,
codeP=new.codeP,
ville=new.ville,
pays=new.pays,
phone=new.phone,
mail=new.mail,
roleClient=null
where id_client=old.id_client;
end //
delimiter ;







/* trigger qui permet de supprimer un particulier dans la table client*/
drop trigger if exists deleteParticulier;
delimiter //
create trigger deleteParticulier
after delete on particulier
for each row
begin
delete from client where id_client=old.id_client;
end //
delimiter ;







/* trigger qui permet de supprimer un professionnel dans la table client*/
drop trigger if exists delProfessionnel;
delimiter //
create trigger delProfessionnel
after delete on professionnel
for each row
begin
delete from client where id_client=old.id_client;
end //
delimiter ;

delete from particulier where id_client =1;







/*trigger qui permet la gestion de commande*/
drop trigger if exists gestionMontantComm;
delimiter //
create trigger gestionMontantComm
after insert on detail_com
for each row
begin
declare MTH decimal(10,2);
select sum(prixUnite * new.quantite_com) into MTH
from detail_com d,produit p
where  d.id_produit = p.id_produit and id_com=new.id_com;
update commande
set mtht=mtht+MTH,
tva=mtht*0.2,
mttc=mtht+tva
where id_com=new.id_com;
end //
delimiter ;

create table indexCom(
id_ic int auto_increment primary key  
);


drop trigger if exists gestionIdComm;
delimiter //
create trigger gestionIdComm
before insert on detail_com
for each row
begin
declare x int(10);

select max(id_com) into x from commande;
if x is null 
then
set x=0;
else 
set x=x+1;
end if;
insert into commande (new.id_com)
values (x+1);
end //
delimiter ;

/*trigger qui permet la gestion de commande*/
drop trigger if exists updateUestionMontantComm;
delimiter //
create trigger updateGestionMontantComm
before update  on detail_com 
for each row
begin
declare qte int ;
declare mth decimal(10,2) default 0;
if new.quantite_com < old.quantite_com 
then 
set qte=old.quantite_com - (select new.quantite_com from detail_com
where id_com=old.id_com
and id_produit=old.id_produit);
select sum(prixUnite * qte) into mth
from produit p 
where old.id_produit=p.id_produit ;
update commande   
set mtht=mtht- mth, 
tva= mtht * 0.2 ,
mttc=mtht + tva 
where id_com=old.id_com;
else

set qte=(select new.quantite_com from detail_com
where id_com=old.id_com
and id_produit=old.id_produit) -old.quantite_com ;
select sum(prixUnite * qte) into mth
from produit p 
where old.id_produit=p.id_produit ;
update commande   
set mtht=mtht + mth, 
tva= mtht * 0.2 ,
mttc=mtht + tva 
where id_com=old.id_com;
end if ;
end // 
delimiter ; 



/*trigger qui permet la gestion de commande*/
drop trigger if exists deleteUestionMontantComm;
delimiter //
create trigger deleteGestionMontantComm
before delete  on detail_com 
for each row
begin
update commande 
set mtht=mtht - (select sum(prixUnite * old.quantite_com)
from produit p 
where old.id_produit=p.id_produit 
group by old.id_com ) ,
tva= mtht * 0.2 ,
mttc=mtht + tva 
where id_com=old.id_com;
end //
delimiter ;




drop trigger if exists index_commande;
delimiter //
create trigger index_commande
before insert  on commande 
for each row
begin
declare x int;
select max(id_com) into x from detail_com;

set new.id_com=x;
end //
delimiter ;



/*trigger qui permet la gestion de stock des articles à louer*/
drop trigger if exists gestionStock;
delimiter //
create trigger gestionStock
after insert on detail_com
for each row
begin
update produit
set quantestock=quantestock-new.quantite_com
where id_produit=new.id_produit;
end //
delimiter ;






/*trigger qui permet la gestion de stock des articles à louer*/
drop trigger if exists updateGestionStock;
delimiter //
create trigger updateGestionStock
after update on detail_com
for each row
begin
update produit
set quantestock=quantestock-new.quantite_com
where id_produit=new.id_produit;
end //
delimiter ;






/*trigger qui permet la gestion de stock des articles à louer*/
drop trigger if exists deleteGestionStock;
delimiter //
create trigger deleteGestionStock 
after delete on detail_com
for each row
begin
update produit
set quantestock=quantestock+old.quantite_com
where id_produit=old.id_produit;
end //
delimiter ;







drop trigger if exists histocom;
delimiter //
create trigger histocom
before insert on commande
for each row
begin

delete from commande where etat_comm='valider' or etat_comm='annuler' ;
end //
delimiter ;


/*
delimiter //
drop trigger if exists deleteOrdderAttente;
create trigger deleteOrdderAttente
before delete on `order`
for each row
begin
if old.order_status != 'valider' or old.order_status != 'annuler'
then
signal sqlstate '45000'
set message_text='cette commande est en attente';
end if;
end //
delimiter ;
*/


UPDATE `commande` 
SET 
`etat_comm`="valider"
WHERE `id_com`=10;


insert into archiComm select *,curdate()
from commande where etat_comm='valider';

create view vArchiComm (id_com,mtht,tva,mttc,date_comm,date_commliv,etat_comm,id_client,datehisto)
as select * ,curdate() from commande
where etat_comm="valider";


/*
drop event `Something To Doo`;
SHOW VARIABLES LIKE 'event_schedulerr';
SET GLOBAL event_scheduler = 1;
CREATE EVENT `Something To Doo`
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 30 second
do delete from `order` where order_status='valider';
*/



SELECT * FROM detail_com 
WHERE 2022-02-30 BETWEEN dateD 
AND dateF OR 2022-02-30 > dateF 
AND ( 2023-12-10 BETWEEN dateD AND dateF OR 2023-12-10 < dateD )

drop procedure reservation;
delimiter //
create procedure reservation()
begin
declare fini int default 0;
declare idp int;
declare datd,datf date;
declare cures cursor for 
select id_produit, dateD,dateF from detail_com;
declare continue handler for not found set fini=1;
open cures;
fetch cures into idp,datd,datf;
while fini!=1
do
if datd not between datd and datf
then
select 'materiel est dispo',`idp`;
else
select 'materiel non dispo',`idp`;
end if;
fetch cures into idp,datd,datf;
end while;
close cures;
end //
delimiter ;


call reservation(1,'2022-04-05','2022-04-14');
call reservation(1,curdate(),curdate());


drop trigger if exists resr;
delimiter //
create trigger resr
before insert on detail_com
for each row
begin
declare x int(10);
select count(*) into x from detail_com where new.dateD between dateD and dateF;
if x>0
then
signal sqlstate '45000'
set message_text='date non dispo';
end if ;
end //
delimiter ;

insert into detail_com values(2,null,99,'2022-05-10','2022-04-15');


drop procedure reservation;
delimiter //
create procedure reservation(id int,dd date,df date)
begin
declare x,y int(10);
select count(*) into x from detail_com where id=id_produit and dd between dateD and dateF;
select count(*) into y from detail_com where id=id_produit and df between dateD and dateF;
if x=0 and y=0
then
select 'materiel est dispo';
else
select 'materiel non dispo';
end if;
end //
delimiter ;

call reservation(99,'2022-04-15','2022-05-30');

DELIMITER //
DROP FUNCTION IF EXISTS ressD //
CREATE FUNCTION ressD (idp int(11),datD date,datF date)
RETURNS INT
BEGIN
declare x int;
select count(*) into x from detail_com where datD between dateD and dateF;
RETURN x;
END//
DELIMITER ;

DELIMITER //
DROP FUNCTION IF EXISTS ressF //
CREATE FUNCTION ressF (idp int(11),datD date,datF date)
RETURNS INT
BEGIN
declare y int;
select count(*) into y from detail_com where datF between dateD and dateF;
RETURN y;
END//
DELIMITER ;

SELECT ressD (99,'2022-04-20','2022-05-26');
SELECT ressF (99,'2022-04-19','2022-05-27');

DELIMITER //
DROP TRIGGER IF EXISTS verif_reservation;
CREATE TRIGGER verif_reservation 
BEFORE INSERT ON detail_com 
FOR EACH ROW
BEGIN
IF ressD (new.id_produit,new.dateD,new.dateF) || ressF (new.id_produit,new.dateD,new.dateF)
THEN 

INSERT INTO Erreur (erreur) VALUES
("l'engein est déja réservé pour ses dates !");


END IF;
END //
DELIMITER ;


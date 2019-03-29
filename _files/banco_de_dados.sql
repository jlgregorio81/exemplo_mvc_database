/* 
1- create a database named 'exemplo_mvc';
2- run the script below to create the sequence and the table used in example.
*/

create sequence sid_client;

create table client(
	id integer not null default nextval('sid_client'),
	name varchar(50) not null,
	birth date not null,
	gender char(1) not null,
	constraint pk_client primary key (id),
	constraint ck_client_gender check(gender in ('M','F'))
);

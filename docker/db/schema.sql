create table post
(
	id int auto_increment
		primary key,
	posted_at datetime not null,
	subject varchar(255) not null,
	body text not null
)
;


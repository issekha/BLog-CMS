drop table if exists t_comment;
drop table if exists t_user;
drop table if exists t_chapter;

create table t_chapter (
    chpt_id integer not null primary key auto_increment,
    chpt_title varchar(100) not null,
    chpt_content varchar(8000) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_user (
    usr_id integer not null primary key auto_increment,
    usr_name varchar(50) not null,
    usr_password varchar(88) not null,
    usr_salt varchar(23) not null,
    usr_role varchar(50) not null 
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_comment (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    chpt_id integer not null,
    usr_id integer not null,
    constraint fk_com_chpt foreign key(chpt_id) references t_chapter(chpt_id),
    constraint fk_com_usr foreign key(usr_id) references t_user(usr_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;
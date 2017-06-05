create database if not exists wrtcms character set utf8 collate utf8_unicode_ci;
use wrtcms;

grant all privileges on wrtcms.* to 'wrtcms_user'@'localhost' identified by 'secret';
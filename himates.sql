create table `users` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `slug` varchar(255) not null, `password` varchar(255) not null, `profile_photo_path` longtext null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `users` add unique `users_name_unique`(`name`);
alter table `users` add unique `users_email_unique`(`email`);

create table `password_resets` (`id` bigint unsigned not null auto_increment primary key, `email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `password_resets` add index `password_resets_email_index`(`email`);

create table `teams` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `slug` varchar(255) not null, `join_code` varchar(255) not null, `created_by` bigint unsigned not null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `teams` add constraint `teams_created_by_foreign` foreign key (`created_by`) references `users` (`id`) on delete cascade;

create table `team_data` (`id` bigint unsigned not null auto_increment primary key, `team_id` bigint unsigned not null, `color` varchar(255) null, `background` longtext null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `team_data` add constraint `team_data_team_id_foreign` foreign key (`team_id`) references `teams` (`id`) on delete cascade;

create table `team_user` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `team_id` bigint unsigned not null, `nickname` varchar(255) null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `team_user` add constraint `team_user_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `team_user` add constraint `team_user_team_id_foreign` foreign key (`team_id`) references `teams` (`id`) on delete cascade;

create table `messages` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `team_id` bigint unsigned not null, `parent_id` bigint unsigned null, `content` longtext not null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8 collate 'utf8_unicode_ci';
alter table `messages` add constraint `messages_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `messages` add constraint `messages_team_id_foreign` foreign key (`team_id`) references `teams` (`id`) on delete cascade;

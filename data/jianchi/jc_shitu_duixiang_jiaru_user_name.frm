TYPE=VIEW
query=select distinct `jianchi`.`jc_duixiang_jiaru`.`dj_id` AS `dj_id`,`jianchi`.`jc_duixiang_jiaru`.`dx_id` AS `dx_id`,`jianchi`.`jc_duixiang_jiaru`.`dx_name` AS `dx_name`,`jianchi`.`jc_duixiang_jiaru`.`user_id` AS `user_id`,`jianchi`.`jc_duixiang_jiaru`.`dj_time` AS `dj_time`,`jianchi`.`jc_user_name`.`un_name` AS `un_name` from (`jianchi`.`jc_user_name` join `jianchi`.`jc_duixiang_jiaru`) where (`jianchi`.`jc_duixiang_jiaru`.`user_id` = `jianchi`.`jc_user_name`.`user_id`)
md5=61a9ce5ac33f6698b0e0ee5ef3cbf6b7
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2012-11-08 23:10:54
create-version=1
source=select distinct `jc_duixiang_jiaru`.`dj_id` AS `dj_id`,`jc_duixiang_jiaru`.`dx_id` AS `dx_id`,`jc_duixiang_jiaru`.`dx_name` AS `dx_name`,`jc_duixiang_jiaru`.`user_id` AS `user_id`,`jc_duixiang_jiaru`.`dj_time` AS `dj_time`,`jc_user_name`.`un_name` AS `un_name`\nfrom (`jc_user_name` join `jc_duixiang_jiaru`)\nwhere (`jc_duixiang_jiaru`.`user_id` = `jc_user_name`.`user_id`)

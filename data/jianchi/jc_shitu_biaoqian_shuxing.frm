TYPE=VIEW
query=select `jianchi`.`jc_biaoqian`.`bq_id` AS `bq_id`,`jianchi`.`jc_biaoqian`.`bs_id` AS `bs_id`,`jianchi`.`jc_biaoqian`.`bq_name` AS `bq_name`,`jianchi`.`jc_biaoqian`.`user_id` AS `user_id`,`jianchi`.`jc_biaoqian`.`bq_time` AS `bq_time`,`jianchi`.`jc_biaoqian_shuxing`.`bs_name` AS `bs_name` from `jianchi`.`jc_biaoqian` join `jianchi`.`jc_biaoqian_shuxing` where (`jianchi`.`jc_biaoqian`.`bs_id` = `jianchi`.`jc_biaoqian_shuxing`.`bs_id`)
md5=22c0b0deeebff9e704bc9a4dbe786ce1
updatable=1
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
timestamp=2012-11-04 09:44:09
create-version=1
source=SELECT\njc_biaoqian.bq_id,\njc_biaoqian.bs_id,\njc_biaoqian.bq_name,\njc_biaoqian.user_id,\njc_biaoqian.bq_time,\njc_biaoqian_shuxing.bs_name\nFROM\njc_biaoqian ,\njc_biaoqian_shuxing\nWHERE\njc_biaoqian.bs_id = jc_biaoqian_shuxing.bs_id

TYPE=VIEW
query=select `jianchi`.`jc_biaoqian_neirong`.`bn_id` AS `bn_id`,`jianchi`.`jc_biaoqian_neirong`.`dx_id` AS `dx_id`,`jianchi`.`jc_biaoqian_neirong`.`bq_id` AS `bq_id`,`jianchi`.`jc_biaoqian_neirong`.`bn_neirong` AS `bn_neirong`,`jianchi`.`jc_biaoqian_neirong`.`user_id` AS `user_id`,`jianchi`.`jc_biaoqian_neirong`.`bn_paixu` AS `bn_paixu`,`jianchi`.`jc_biaoqian_neirong`.`bn_time` AS `bn_time`,count(`jianchi`.`jc_biaoqian_taidu`.`bn_id`) AS `paixu` from (`jianchi`.`jc_biaoqian_neirong` join `jianchi`.`jc_biaoqian_taidu`) where ((`jianchi`.`jc_biaoqian_neirong`.`bn_id` = `jianchi`.`jc_biaoqian_taidu`.`bn_id`) and (`jianchi`.`jc_biaoqian_taidu`.`bt_taidu` = 1)) group by `jianchi`.`jc_biaoqian_taidu`.`bn_id`
md5=eb34f83d0b21789df94a80402e2b6977
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2012-11-13 14:46:15
create-version=1
source=select `jc_biaoqian_neirong`.`bn_id` AS `bn_id`,`jc_biaoqian_neirong`.`dx_id` AS `dx_id`,`jc_biaoqian_neirong`.`bq_id` AS `bq_id`,`jc_biaoqian_neirong`.`bn_neirong` AS `bn_neirong`,`jc_biaoqian_neirong`.`user_id` AS `user_id`,`jc_biaoqian_neirong`.`bn_paixu` AS `bn_paixu`,`jc_biaoqian_neirong`.`bn_time` AS `bn_time`,count(`jc_biaoqian_taidu`.`bn_id`) AS `paixu`\nfrom (`jc_biaoqian_neirong` join `jc_biaoqian_taidu`)\nwhere ((`jc_biaoqian_neirong`.`bn_id` = `jc_biaoqian_taidu`.`bn_id`) and (`jc_biaoqian_taidu`.`bt_taidu` = 1))\nGROUP BY\njc_biaoqian_taidu.bn_id

<?php

class pos_new
{

    function check_item($code)
    {
        $dbpdo = DB::create();

        $sqlstr = "select * from item where old_code=? LIMIT 1";
        $sql = $dbpdo->prepare($sqlstr);
        $sql->execute([$code]);

        return $sql->fetch();
    }

    function check_price($code)
    {
        $dbpdo = DB::create();

        $sqlstr = "select * from set_item_price where item_code=? ORDER BY date DESC LIMIT 1";
        $sql = $dbpdo->prepare($sqlstr);
        $sql->execute([$code]);

        return $sql->fetch();
    }

    function check_invoice()
    {
        $date = date('Y-m-d');
        $dbpdo = DB::create();

        $sqlstr = "select COUNT(*) from sales_invoice where date=?";
        $sql = $dbpdo->prepare($sqlstr);
        $sql->execute([$date]);

        return $sql->fetchColumn();
    }

    function get_data_invoice()
    {
        $dbpdo = DB::create();
        $code = $_POST['code'];

        $sqlstr = "select a.ref, a.client_code, a.cash, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.end_date_discount, a.qty, a.discount, a.unit_price, a.amount, a.discount2, a.discount3, a.deposit, a.total, a.non_discount, a.qty_discount, a.ref_near_expired, a.upd_approved_over, a.line from sales_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$code' order by a.line desc ";
        $sql = $dbpdo->prepare($sqlstr);
        $sql->execute();

        return $sql->fetchAll();
    }

    function check_item_sales($code)
    {
        $dbpdo = DB::create();

        $sqlstr = "select COUNT(*) from sales_invoice_tmp where ref=?";
        $sql = $dbpdo->prepare($sqlstr);
        $sql->execute([$code]);

        return $sql->fetchColumn();
    }

    function check_item_tmp($code, $item_code)
    {
        $dbpdo = DB::create();

        $sqlstr = "select COUNT(*) from sales_invoice_tmp where ref='" . $code . "' AND item_code='" . $item_code . "'";
        $runsql = $dbpdo->prepare($sqlstr);
        $runsql->execute();

        $sql = "select * from sales_invoice_tmp where ref='" . $code . "' AND item_code='" . $item_code . "'";
        $datasql = $dbpdo->prepare($sql);
        $datasql->execute();

        $data = ['column' => $runsql->fetchColumn(), 'line' => $datasql->fetch()];
        return $data;
    }
}

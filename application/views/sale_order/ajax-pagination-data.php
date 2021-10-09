<tr>
    <th>Sr#</th>
    <th>ID</th>
    <th>Date</th>
    <th>Account Name</th>
    <th>Manage</th>
</tr>


 <?php
                                                if (!empty($sales)): $count = 1;

                                                    foreach ($sales as $sale):
                                                        ?>
                                                        <tr <?=(!empty($sale['invoice_id']) ? "style='background:#d5fdd5 !important'":"")?>>
                                                            <td><?= $count ?></td>
                                                            <td><?= $sale['ordr_id'] ?></td>
                                                            <td><?= $sale['ordr_date'] ?></td>
                                                            <td><?= $sale['account_name'] ?></td>
                                                            

                                                            <td>
                                                                <?php if ($this->session->userdata('user_group_id') == 1) { ?>
                                                                    <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditSaleOrder('<?= $sale['ordr_id'] ?>');">
                                                                        <i class="glyph-icon icon-pencil"></i>
                                                                    </button>
                                                                    <button class="btn btn-round btn-danger" onclick="DeleteSaleOrder('<?= $sale['ordr_id'] ?>');">
                                                                        <i class="glyph-icon icon-trash"></i>
                                                                    </button>
                                                                <?php } ?>
                                                                <button class="btn btn-round btn-success" onclick="ViewSaleOrder('<?= $sale['ordr_id'] ?>');">
                                                                    <i class="glyph-icon icon-file-text-o"></i>
                                                                </button>

                                                                <button class="btn btn-round btn-warning" onclick="ConvertSale('<?= $sale['ordr_id'] ?>');">
                                                                    <i style="font-size: 20px; font-weight: bold;" class="glyphicon glyphicon-plus"></i>
                                                                </button>


                                                            </td>

        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Sale(s) Order not available.</p>
<?php endif; ?>
<?php
if (isset($search)) {
    if (!empty($search)) {
        echo $this->ajax_pagination->create_links(NULL, NULL, $search);
    }
}
if (isset($cat) && isset($pro_name) && isset($pro) && isset($date_from) && isset($date_to)) {
    if (!empty($cat) || !empty($war) || !empty($pro_name) || !empty($date_from) || !empty($date_to)) {
        if (empty($cat)) {
            $cat = NULL;
        }
        if (empty($pro_name)) {
            $pro_name = NULL;
        }
        if (empty($pro)) {
            $pro = NULL;
        }
        if (empty($date_from)) {
            $date_from = NULL;
        }
        if (empty($date_to)) {
            $date_to = NULL;
        }
        echo $this->ajax_pagination->create_links($date_from, $date_to, NULL, $cat, $pro_name, $pro);
    }
} if (isset($search) && isset($cat) && isset($pro_name) && isset($pro)) {
    if (empty($search) && empty($cat) && empty($pro_name) && empty($pro)) {
        echo $this->ajax_pagination->create_links();
    }
}
?>

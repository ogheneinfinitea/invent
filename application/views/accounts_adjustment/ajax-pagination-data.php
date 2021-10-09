<tr >
 
        <th>ID</th>
        <th>Date</th>
        <th>Account Name</th>
        <th>Credit Amount</th>
        <th>Debit Amount</th>
        <th>Manage</th>
</tr>
<?php
if (!empty($ledger)):
    foreach ($ledger as $ledgers):
        ?>
        <tr>
             <td><?= $ledger->ledger_id ?></td>
            <td ><?php echo $ledger['date']; ?></td>
            <td ><?php echo $ledger['account_name']; ?></td>
            <td ><?php echo $ledger['credit_amount']; ?></td>
            <td ><?php echo $ledger['debit_amount']; ?></td>
            <td>  
                <button class="btn btn-round btn-success" onclick="ViewAdjustment('<?= $ledger['ledger_id'] ?>');">
                    <i class="glyph-icon icon-file-text-o"></i>
                </button>
            </td>
        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Adjustment(s) not available.</p>
<?php endif; ?>
<?php
if (isset($search)) {

    if (!empty($search)) {

        echo $this->ajax_pagination->create_links(NULL, NULL, $search);
    }
}
if (isset($date_from) && isset($date_to)) {

    if (!empty($date_from) && !empty($date_to)) {

        echo $this->ajax_pagination->create_links($date_from, $date_to);
    }
} if (isset($search) && isset($date_from) && isset($date_to)) {
    if (empty($search) && empty($date_from) && empty($date_to)) {
        echo $this->ajax_pagination->create_links();
    }
}
?>
<tr>
    <th>Sr#</th>
    <th>ID</th>
    <th>Date</th>
    <th>From Account</th>
    <th>To Account</th>
    <th>Amount</th>
    <th>J.V #</th>
    <th>CRV / CPV #</th>
    <th>Description</th>
    <th style="width:14%">Manage</th>
</tr>


<?php
if (!empty($journals)):
    foreach ($journals as $journal):
        ?>
        <tr>
            <td><?php echo $count ?></td>
            <td><?php echo $journal['journal_id'] ?></td>
            <td><?php echo $journal['date'] ?></td>
            <td><?php echo $journal['from_account'] == "" ? "Cash Book" : $journal['from_account'] ?></td>
            <td><?php echo $journal['to_account'] == "" ? "Cash Book" : $journal['to_account'] ?></td>
            <td><?php echo $journal['amount'] ?></td>
            <td><?php echo $journal['voucher_no'] ?></td>
            <td><?= $journal['CPV']!=NULL ? $journal['CPV'] : $journal['CRV'] ?></td>
            <td style="width:14%"><?php echo html_entity_decode($journal['description']) ?></td>
            
            <td>
            <?php if($this->session->userdata('user_group_id') == 1){ ?>
                <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditJournal('<?php echo $journal['journal_id'] ?>');">
                    <i class="glyph-icon icon-pencil"></i>
                </button>
                <button class="btn btn-round btn-danger" onclick="DeleteJournal('<?php echo $journal['journal_id'] ?>');">
                    <i class="glyph-icon icon-trash"></i>
                </button>
                <button class="btn btn-round btn-success" onclick="ViewJournal('<?php echo $journal['journal_id'] ?>');">
                    <i class="glyph-icon icon-file-text-o"></i>
                </button>
            <?php } ?>    
            </td>
        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Journal(s) not available.</p>
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


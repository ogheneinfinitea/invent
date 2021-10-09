
////////////////Account Ajax Pagination Heading//////////////////////////////

<tr>
    <th >Sr#</th>
    <th>ID</th>
    <th>Name</th>
    <th>Account Number</th>
    <th>Account Address</th>
    <th>Description</th>
    <th>Phone</th>
    <th>Manage</th>
</tr>


////////////////Account Ajax Pagination Data//////////////////////////////


<?php
if (!empty($accounts)):

    foreach ($accounts as $account) :
        ?>
        <tr>
            <td ><?php echo $count; ?></td>
            <td><?= $account['account_id'] ?></td>
            <td><?= $account['account_name'] ?></td>
            <td><?= $account['account_number'] ?></td>
            <td><?= $account['account_address'] ?></td>
            <td><?= html_entity_decode($account['description']) ?></td>
            <td><?= $account['ph_number'] ?></td>
            <td>
            <?php if($this->session->userdata('user_group_id') == 1){ ?>

                <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditAccount('<?= $account['account_id'] ?>');">
                    <i class="glyph-icon icon-pencil"></i>
                </button>
                <button class="btn btn-round btn-danger" onclick="DeleteAccount('<?= $account['account_id'] ?>');">
                    <i class="glyph-icon icon-trash"></i>
                </button>

            <?php } ?>

            </td>
        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Account(s) not available.</p>
<?php endif; ?>
<?php
if (isset($search)) {
    echo $this->ajax_pagination->create_links(NULL, NULL, $search);
}
if (isset($date_from) && isset($date_to)) {
//    echo $this->ajax_pagination->create_links($date_from, $date_to);
} if (!isset($search) && !isset($date_from) && !isset($date_to)) {
    echo $this->ajax_pagination->create_links();
}
?>
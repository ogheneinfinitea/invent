<tr >
    <th >Sr#</th>
    <th >ID</th>
    <th >Date</th>
    <th >Warehouse</th>
    <th >Section</th>
    <th >Manage</th>
</tr>
<?php
if (!empty($issues)):
    foreach ($issues as $issue):
        ?>
        <tr >
            <td ><?php echo $count; ?></td>
            <td ><?php echo $issue['issue_id']; ?></td>
            <td ><?php echo $issue['date']; ?></td>
            <td ><?php echo $issue['warehouse_name']; ?></td>
            <td ><?php echo $issue['section_name']; ?></td>
            <td >
             <?php if($this->session->userdata('user_group_id') == 1){ ?>    
                <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditIssue('<?= $issue['issue_id'] ?>');">
                    <i class="glyph-icon icon-pencil"></i>
                </button>
                <button class="btn btn-round btn-danger" onclick="DeleteIssue('<?= $issue['issue_id'] ?>');">
                    <i class="glyph-icon icon-trash"></i>
                </button>
            <?php } ?>    
                <button class="btn btn-round btn-success" onclick="ViewIssue('<?= $issue['issue_id'] ?>');">
                    <i class="glyph-icon icon-file-text-o"></i>
                </button>
            </td>
        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Issue(s) not available.</p>
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
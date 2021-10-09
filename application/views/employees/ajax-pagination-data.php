
////////////////Account Ajax Pagination Heading//////////////////////////////

<tr>
    <th >Sr#</th>
    <th>ID</th>
    <th>Name</th>
    <th>Salary</th>
    <th>Address(Local)</th>
    <th>Designation</th>
    <th>Manage</th>
</tr>


////////////////Account Ajax Pagination Data//////////////////////////////


<?php
if (!empty($employees)):

    foreach ($employees as $employee) :
        ?>
        <tr>
            <td ><?php echo $count; ?></td>
            <td><?= $employee['employee_id'] ?></td>
            <td><?= $employee['emp_name'] ?></td>
            <td><?= $employee['salary'] ?></td>
            <td><?= $employee['emp_local_address'] ?></td>
            <td><?= $employee['emp_designation'] ?></td>
            <td>
                <?php if ($this->session->userdata('user_group_id') == 1) { ?>

                    <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditAccount('<?= $employee['employee_id'] ?>');">
                        <i class="glyph-icon icon-pencil"></i>
                    </button>
                    <button class="btn btn-round btn-danger" onclick="DeleteAccount('<?= $employee['employee_id'] ?>');">
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
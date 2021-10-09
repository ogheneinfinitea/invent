<tr>
    <th>ID</th>
    <th>Date</th>
    <th>Section</th>
    <th>Manage</th>
</tr>
<?php
if (!empty($productions)):
    foreach ($productions as $production):
        ?>
        <tr>
            <td><?= $production->issue_id ?></td>
            <td><?= $production->date ?></td>
            <td><?= $production->section_name ?></td>

            <td>
            <?php if($this->session->userdata('user_group_id') == 1){ ?>
                <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditProduction('<?= $production->issue_id ?>');">
                    <i class="glyph-icon icon-pencil"></i>
                </button>
                <button class="btn btn-round btn-danger" onclick="DeleteProduction('<?= $production->issue_id ?>');">
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
    <p>Productions(s) not available.</p>
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

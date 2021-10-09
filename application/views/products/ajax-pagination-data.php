<tr>
    <th>Sr#</th>
    <th>ID</th>
    <th>Name</th>
    <th>In Stock</th>
    <th>Unit</th>
    <th>Description</th>
    <th>Manage</th>
</tr>



<?php
if (!empty($products)):
    foreach ($products as $product):
        ?>
        <tr>
            <td><?= $count ?></td>
            <td><?= $product['product_id'] ?></td>
            <td><?= $product['product_name'] ?></td>
            <td><?= $product['instock'] ?></td>
            <td><?= $product['unit_symbol'] ?></td>
            <td><?= html_entity_decode($product['description']) ?></td>

            <td>

            <?php if($this->session->userdata('user_group_id') == 1){ ?>

                <button class="btn btn-round btn-info" data-toggle="modal" data-target="#myModal" onclick="EditProduct('<?= $product['product_id'] ?>');">
                    <i class="glyph-icon icon-pencil"></i>
                </button>
                <button class="btn btn-round btn-danger" onclick="DeleteProduct('<?= $product['product_id'] ?>');">
                    <i class="glyph-icon icon-trash"></i>
                </button>
            <?php } ?> 
                <button onclick="GoLedger('<?= $product['product_id'] ?>');"  class="btn btn-round btn-success" >
                    <i class="glyph-icon icon-file-image-o"></i>
                </button>

              
            </td>

        </tr>
        <?php
        $count++;
    endforeach;
else:
    ?>
    <p>Product(s) not available.</p>
<?php endif; ?>
<?php
if (isset($search)) {
    if (!empty($search)) {
        echo $this->ajax_pagination->create_links(NULL, NULL, $search);
    }
}
if (isset($cat) && isset($war) && isset($pro)) {
    if (!empty($cat) || !empty($war) || !empty($pro)) {
        if (empty($cat)) {
            $cat = NULL;
        }
        if (empty($war)) {
            $pro_name = NULL;
        }
        if (empty($war)) {
            $pro = NULL;
        }
        echo $this->ajax_pagination->create_links(NULL, NULL, NULL, $cat, $war, $pro);
    }
} if (isset($search) && isset($cat) && isset($war) && isset($pro)) {
    if (empty($search) && empty($cat) && empty($war) && empty($pro)) {
        echo $this->ajax_pagination->create_links();
    }
}
?>

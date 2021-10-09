<!DOCTYPE html>
<html  lang="en">

    <!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:12:30 GMT -->
    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
         <title> Facteezo: Received </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Favicons -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?= base_url() ?>assets/images/icons/favicon.png">



        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets-minified/admin-all-demo.css">

        <!-- JS Core -->

        <script type="text/javascript" src="<?= base_url() ?>assets-minified/js-core.js"></script>





        <script type="text/javascript">
            $(window).load(function () {
                setTimeout(function () {
                    $('#loading').fadeOut(400, "linear");
                }, 300);
            });
        </script>
        <script>
            function print_me() {
                window.print();
                window.location.href = "<?= base_url() ?>issue/view_slip/<?= $issue[0]->issue_id ?>";
                    }
        </script>



    </head>


    <body onload="print_me();">
        <table width="100%">
            <tr>
                <td colspan="3" width="30%">
                    <div class="">
                        <img src="<?= base_url() ?>/images/Kohinoor_logo.png" />
                    </div>

                    <address class="invoice-address">
                        <b><?= $issue[0]->warehouse_name ?></b>
                    </address>
                </td>
                <td colspan="6" class="text-right mrg10L" valign="top">
                    <h4 class="invoice-title">Issue Slip</h4>
                    No. <b>#<?= $issue[0]->issue_id ?></b>
                    <hr>
                    <div class="invoice-date mrg20B"><?= date("j F Y", strtotime($issue[0]->date)) ?></div>


                </td>
            </tr>
        </table>


        <hr>
        <table width="100%">
            <tr>
                <td colspan="4">
                    <h2 class="invoice-client mrg10T">Receiver information:</h2>
                    <h5><?= $issue[0]->section_name ?></h5>

                </td>
                <td colspan="4">
                    <h2 class="invoice-client mrg10T">Order Info:</h2>
                    <ul class="reset-ul">
                        <li><b>Date:</b><?= date("F j, Y", strtotime($issue[0]->date)) ?></li>

                    </ul>
                </td>
                <td colspan="4" width="30%" valign="top">
                    <h2 class="invoice-client">Handling Details:</h2>
                    <p>To achieve this, it would be necessary.</p>
                </td>
            </tr>
        </table>
        <hr>

        <table class="table mrg20T table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th class="text-center">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $qty = 0;
                $count = 1;
                foreach ($issue_items as $issue_item) {
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $issue_item->product_name ?></td>
                        <td class="text-center"><?= $issue_item->credit_qty . " " . $issue_item->unit ?></td>
                    </tr>
                    <?php
                    $qty = $qty + $issue_item->credit_qty;
                    $count++;
                }
                ?>
            </tbody>
        </table>
        <table width="100%" style="margin-top: 50px !important;">
            <tr>
                <td class="mrg20L">
                    Authorized Stamp
                </td>
                <td class="mrg20R text-right">
                    Authorized Signature
                </td>
            </tr>
            <tr>
                <td class="mrg20L">

                </td>
                <td class="mrg20R text-right">
                    ---------------------
                </td>
            </tr>
        </table>
    </body>

    <!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:12:30 GMT -->
</html>
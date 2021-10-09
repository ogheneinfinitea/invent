<!DOCTYPE html>
<html  lang="en">

    
    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: purchases Order</title>
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
                window.location.href = "<?= base_url() ?>purchase/view_ordr/<?= $ordr[0]->ordr_id ?>";
                    }
        </script>



    </head>


    <body onload="print_me();">
        <table width="100%">
            <tr>
                <td colspan="3" width="40%">
                    <div class="">
                        <img src="<?= base_url() ?>/images/Kohinoor_logo.png" />
                    </div>
                    <address class="ordr-address">

                      160/B,Small Industries Estate,Sahiwal - Pakistan. 
                    <br>
                        Tel: +92-40-4502650-51
                    </address>
                </td>
                <td colspan="6" class="text-right mrg10L" valign="top">
                    <h4 class="ordr-title">Outward Gate Pass</h4>
                    No. <b>#<?= $ordr[0]->ordr_id ?></b>
                    <hr>
                    <div class="ordr-date mrg20B"><?= date("j F Y", strtotime($ordr[0]->date_created)) ?></div>


                </td>
            </tr>
        </table>


        <hr>
        <table width="100%">
            <tr><th  colspan="4"><h2 class="ordr-client mrg10T">Client information:</h2></th>
                <th colspan="4"><h2 class="ordr-client mrg10T">ordr Info:</h2></th>
                <th colspan="4"><h2 class="ordr-client">ordr Details:</h2></th>
            </tr>
            <tr>

                <td colspan="4">

                    <h5><?= $ordr[0]->account_name ?></h5>
                    <address class="ordr-address">
                        <?= html_entity_decode($ordr[0]->account_desc) ?>
                        <?= $ordr[0]->ph_number ?>
                    </address>

                </td>

                <td colspan="4"  valign="top">

                    <ul class="reset-ul">
                        <li><b>Date:</b><?= date("F j, Y", strtotime($ordr[0]->date_created)) ?></li>
                        <li><b>Id:</b> #<?= $ordr[0]->ordr_id ?></li>

                    </ul>
                </td>
                <td colspan="4" width="30%" valign="top">

                    <?= html_entity_decode($ordr[0]->voucher_no) ?>
                </td>
            </tr>
        </table>
        <hr>

        <table class="table  table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th class="text-center">Quantity</th>
					<th class="text-center">Batch</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                foreach ($ordr_items as $inv_item) {
                    ?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= $inv_item->product_name ?></td>
                        <td class="text-center"><?= $inv_item->qty . " " . $inv_item->unit ?></td>
						<td class="text-center"><?= $inv_item->batch ?></td>

                    </tr>
                    <?php
                    $counter++;
                }
                ?>


            </tbody>
        </table>
        <table width="100%" style="margin-top: 50px !important;">
            <tr>
                <td class="mrg20R text-left">
                    -------------------
                </td>
                <td class="mrg20R text-center">
                    -------------------------
                </td>
                <td class="mrg20R text-right">
                    -------------------------
                </td>
            </tr>
            <tr>
                <td class="mrg20L text-left">
                    Prepared By
                </td>
                <td class="mrg20R text-center">
                    Receiver's Signature
                </td>
                <td class="mrg20R text-right">
                    Manager Signature
                </td>
            </tr>
            
        </table>
        <style>
            .tdstyle{
                border:solid 1px;
            }
        </style>
        <table  cellspacing="0" cellpadding="0" style="margin-top:40px;width: 100%; border:solid 1px" >
            <thead>
                <tr>
                    <th colspan="4" style="" class="text-center tdstyle">No of Bags</th>

                    <th colspan="4" class="text-center  tdstyle">No of Carton</th>

                    <th colspan="4" class="text-center  tdstyle">Cargo</th>

                    <th colspan="4" class="text-center  tdstyle">Bilty No</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $ordr[0]->bag ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $ordr[0]->carton ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $ordr[0]->cargo ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $ordr[0]->builty_no ?>
                    </td>

                </tr>
            </tbody>

        </table>
        
         <footer style="font-size: 10px; bottom: 0; position: fixed; left: 0; width: 100%; text-align: center" class="footer">
        <p>Software Developed By EEIZO INVENT OR ADOPT, SAHIWAL. +(92) (315) 2021990 | info@eeizo.com</p>
    </footer>
    </body>

    
</html>
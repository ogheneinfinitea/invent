<!DOCTYPE html>
<html  lang="en">

    
    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: Account Adjustment </title>
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
                window.location.href = "<?= base_url() ?>accounts_adjustment/view_adjustment/<?= $ledger[0]->ledger_id ?>";
                    }
        </script>



    </head>


    <body onload="print_me();">
        <table width="100%">
            <tr>
                <td colspan="3" width="40%">
                    <div class="">
                        <img style="height: 50px;" src="<?= base_url() ?>/images/Kohinoor_logo.png" />
                    </div>
                    <address class="invoice-address">

                        160/B,Small Industries Estate,Sahiwal - Pakistan. 
                        <br>
                        Tel: +92-40-4502650-51
                    </address>
                </td>
                <td colspan="6" class="text-right " valign="top">
                    <h4 class="invoice-title" style="font-size: 22px">Adjustment</h4>
                    No. <b>#<?= $ledger[0]->ledger_id ?></b>
                 
                    <div class="invoice-date"><?= date("j F Y", strtotime($ledger[0]->ledger_date)) ?></div>


                </td>
            </tr>
        </table>


     <hr style="margin-top: 0px; margin-bottom: 0px;">
        <table width="100%" >
            <tr><th  style="width: 50%;" ><h2 class="invoice-client ">Client information:</h2></th>
                <th ><h2 class="invoice-client ">Adjustment Info:</h2></th>
            </tr>
            <tr>
                <td style="text-align: left">

                    <h5><?= $ledger[0]->account_name ?></h5>
                    <address class="invoice-address">
                        <?= html_entity_decode($ledger[0]->account_address) ?></br>
                        <?= $ledger[0]->ph_number ?>
                    </address>
                </td>
                <td style="text-align: left" valign="top">

                    <ul class="reset-ul">
                        <li><b>Date:</b><?= date("F j, Y", strtotime($ledger[0]->ledger_date)) ?></li>
                        <li><b>id:<b><?= $ledger[0]->ledger_id ?></li>
                        
                    </ul>
                </td>  
                </td>
            </tr>
        </table>
     <hr style="margin-top: 0px; margin-bottom: 0px;">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($ledger as $ledgers) {
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $ledger[0]->ledger_desc ?></td>
                        <td class="text-center"><?= ($ledger[0]->credit_amount!='0.00')?$ledger[0]->credit_amount: $ledger[0]->debit_amount ?></td>
                    </tr>
                    <?php
                    $count++;
                }
                ?>
            </tbody>
        </table>
        <table width="100%" style="margin-top: 10px !important;">
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

    <footer style="font-size: 10px; bottom: 0; position: fixed; left: 0; width: 100%; text-align: center" class="footer">
        <!-- <p>Software Developed By EEIZO INVENT OR ADOPT, SAHIWAL. +(92) (315) 2021990 | info@eeizo.com</p> -->
    </footer>

    </body>

    
</html>
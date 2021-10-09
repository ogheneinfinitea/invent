<!DOCTYPE html>
<html  lang="en">


    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: Journals Slip</title>
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
                window.location.href = "<?= base_url() ?>journal/view_journal/<?= $journal[0]->journal_id ?>";

                    }
        </script>



    </head>


    <body onload="print_me();">
        <table width="100%">
            <tr>
                <td colspan="3" width="30%">
                    <div class="">
                        <img style="height:50px" src="<?= base_url() ?>/images/Kohinoor_logo.png" />
                    </div>
                    <address class="ordr-address" style="height:50px">

                        160/B,Small Industries Estate,Sahiwal - Pakistan.
                        <br>
                        Tel: +92-40-4502650-51
                    </address>
                </td>
                <td colspan="6" class="text-right" valign="top" style="height:50px">
                    <h4 class="invoice-title" style="font-size: 22px">Journals Slip</h4>
                    No. <b>#<?= $journal[0]->journal_id ?></b>
                    
                    <div class="invoice-date "><?= date("j F Y", strtotime($journal[0]->date)) ?></div>


                </td>
            </tr>
        </table>

<hr style="margin-top: 0px; margin-bottom: 0px;">
       
        <table width="100%" >
            <tr><th  colspan="4"><h3 class="invoice-client">From Client info:</h3></th>
                <th colspan="4"><h3 class="invoice-client ">To Client Info:</h2></th>
                <th colspan="4"><h3 class="invoice-client">Journals Info:</h2></th>
            </tr>
            <tr>
                <td colspan="4">
                    <h5><?= (!empty($journal[0]->from_account_name)?$journal[0]->from_account_name:"Cash Book") ?></h5>
                    <address class=>
                        <?= html_entity_decode($journal[0]->from_account_address) ?>
                        <br>
                        <?= $journal[0]->from_account_ph_number ?>
                    </address>
                </td>
                <td colspan="4">
                    <h5><?= (!empty($journal[0]->to_account_name)?$journal[0]->to_account_name:"Cash Book") ?></h5>
                    <address class="">
                        <?= html_entity_decode($journal[0]->to_account_address) ?>
                        <br>
                        <?= $journal[0]->to_account_ph_number ?>
                    </address>
                </td>
                <td colspan="4" valign="top">

                    <ul class="reset-ul">
                        <li><?= date("F j, Y", strtotime($journal[0]->date)) ?></li>
                        <li><?= html_entity_decode($journal[0]->voucher_no) ?></li>
                        <li><?= html_entity_decode($journal[0]->CRV) ?><?= html_entity_decode($journal[0]->CPV) ?></li>
            
                    
                    </ul>
                </td>
                
            </tr>
        </table>
        

        <table class="table-bordered table-hover" width="100%">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th> 
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>
                    <span><b><?= (!empty($journal[0]->from_account_name)?$journal[0]->from_account_name:"Cash Book") ?></b></span>
                   TO
                    <span><b><?= (!empty($journal[0]->to_account_name)?$journal[0]->to_account_name:"Cash Book") ?></b></span>
                    <span> <?= html_entity_decode($journal[0]->description) ?></span>
                </td>
                    
                    <td>Rs:<?= $word=$journal[0]->amount ?></td>
                </tr>
                 <tr>   
                    <td colspan="2" style="text-align: right;">Amount In Words:  <b><?= getPakistaniCurrency($word) ?></b></td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="margin-top: 30px !important;">
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
   
    <footer style="font-size: 10px; bottom: 0; position: fixed; left: 0; width: 100%; text-align: center" class="footer">
        <!-- <p>Software Developed By EEIZO INVENT OR ADOPT, SAHIWAL. +(92) (315) 2021990 | info@eeizo.com</p> -->
    </footer>


    </body>


</html>
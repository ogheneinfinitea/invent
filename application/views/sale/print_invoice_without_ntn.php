<!DOCTYPE html>
<html  lang="en">

    <head>
        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>
        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: Sales </title>
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
                window.location.href = "<?= base_url() ?>sale/view_invoice/<?= $invoice[0]->invoice_id ?>";                    }
        </script>

    </head>
    <body onload="print_me();">

        <!-- Header Div -->
        <header>
        <div class="row">
            <div class="col-md-12"  >
                <img height="80px" width="100%" src="<?= base_url() ?>/images/invoice_header1.jpg" />
            </div>
        </div>
        <hr style="margin-top: 0px; margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-12" >
                <p class="text-center font-size-26">
                <b>SALE INVOICE</b>
                </p>
            </div>
        </div>   
        </header>             
        <!-- <hr> -->
        <!-- Header Div End -->

        <!-- Div Invoice Information -->
        <table width="100%" style="height: 36px;" >
          <thead >  
            <tr>
                <th><h2 class="font-size-16 font-bold">Client information</h2></th>
                <th><h2 class="font-size-16 font-bold">Invoice Information:</h2></th>
            </tr>
          </thead>
        <tbody>
            <tr>
                <td style="text-align: left">
                    <h5><?= $invoice[0]->account_name ?></h5>
                    <address class="">
                        <?= html_entity_decode($invoice[0]->account_desc) ?>
                        <?= $invoice[0]->ph_number ?>
                    </address>
                </td>
                <td valign="top"  >
                    <ul class="reset-ul">
                        <li><b style="text-align: left">Sale Voucher:</b>
                            <span style="text-align: right;"><?= html_entity_decode($invoice[0]->voucher_no) ?></span>
                        </li>
                        <li><b style="text-align: justify;">Date:</b>
                            <span style="text-align: right"><?= date("F j, Y", strtotime($invoice[0]->date_created)) ?></span>
                        </li>
                        <li><b style="text-align: left">Status:</b>
                            <span style="text-align: right"><?= $invoice[0]->payment_status == 'Pending' ? '<span class="bs-label label-warning">Pending</span>' : '<span class="bs-label label-success">Confirmed</span>' ?></span>
                        </li>
                        <li><b style="text-align: left">Purchase Order:</b></li>
                    </ul>
                </td>
            </tr>
        </tbody>
        </table>
        <!-- Div Invoice Information End -->

     
      
       <!-- table Data DIv Start -->
<div class="table-data">
        <table class=" mrg20T table-hover table-bordered" width="100%" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th class="text-center">Qty</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Batch</th>
                    <th>Discount</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                foreach ($invoice_items as $inv_item) {
                    ?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= $inv_item->product_name ?></td>
                        <td align="right"><?= $inv_item->qty . " " . $inv_item->unit ?></td>
						<td align="right"><?= $inv_item->product_sale_price ?> Rs</td>
                        <td align="right"><?= $inv_item->batch ?></td>
						<td align="right"><?= $inv_item->discount ?> Rs</td>
                        <td align="right"><?= $inv_item->invoice_subtotal ?> Rs</td>
                    </tr>
                    <?php
                    $counter++;
                }
                ?>
                <tr class="font-bold font-black">
                    <td colspan="4" class="text-right">Discount on Sub Total:</td>
                    <td colspan="3" class="font-red text-right"><?= $invoice[0]->total_discount ?> Rs</td>
                </tr>
            </tbody>
        </table>
        <table class="">
            <tr class="font-bold font-black">
                <td colspan="2" class="text-right font-size-18">TOTAL: &nbsp;&nbsp;</td>
                <?php $amount_total = $invoice[0]->invoice_total; ?>
                    <td colspan="5" class="font-blue font-size-16"><?= getPakistaniCurrency($amount_total) ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td></td>
                    <td  float="right" class="font-Black font-size-16 text-right"><?= $invoice[0]->invoice_total ?> Rs</td>
            </tr>
        </table>
        
   </div>  
     <!-- table Data DIv ENd -->   
        
<footer style="font-size: 10px; bottom: 0; position: fixed; left: 0; width: 100%; text-align: center" class="footer">    
    
        <table width="100%"  style="margin-top: 10px !important; height: 20px">
            <tr>
                <td class="mrg20R text-left">
                    ---------------------
                </td>
                <td class="mrg20R text-center">
                    ---------------------
                </td>
                <td class="mrg20R text-right">
                    ---------------------
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
        <table   cellspacing="0" cellpadding="0" style="margin-top:10px; width: 100%; border:solid 1px" >
            <thead>
                <tr>
                    <th colspan="4" style="" class="text-center tdstyle">No of Bags</th>

                    <th colspan="4" class="text-center  tdstyle">No of Carton</th>

                    <th colspan="4" class="text-center  tdstyle">Cargo</th>

                    <th colspan="4" class="text-center  tdstyle">Bilty No</th>

                    <th colspan="4" class="text-center  tdstyle">Destination</th>

                    <th colspan="4" class="text-center  tdstyle">Driver Name</th>

                    <th colspan="4" class="text-center  tdstyle">Mobile No</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->bag ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->carton ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->cargo ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->builty_no ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->destination ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->driver_name ?>
                    </td>
                    <td colspan="4" class="text-center tdstyle">
                        <?= $invoice[0]->mobile_no ?>
                    </td>

                </tr>
            </tbody>
        </table>

 

        <p>Email: kohinoorsurgical@hotmail.com &nbsp;&nbsp;&nbsp;  Website: www.kohinoorpharma.com</p>
        <!-- <p>Software Developed By EEIZO INVENT OR ADOPT, SAHIWAL. +(92) (315) 2021990 | info@eeizo.com</p> -->
    </footer>
    
    </body>


    
</html>
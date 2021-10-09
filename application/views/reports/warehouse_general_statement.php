<!DOCTYPE html>
<html  lang="en">

    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: Warehouse Statement </title>
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

        <!-- Chosen -->

        <!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/chosen/chosen.css">-->
        <script type="text/javascript" src="<?= base_url() ?>assets/widgets/chosen/chosen.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/widgets/chosen/chosen-demo.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/widgets/datepicker/datepicker.js"></script>
        <script type="text/javascript">
            /* Datepicker bootstrap */

            // $(function () {
            //     "use strict";
            //     $('.bootstrap-datepicker').bsdatepicker({
            //         format: 'mm-dd-yyyy'
            //     });
            // });
        </script>


        <script type="text/javascript">
            $(window).load(function () {
                setTimeout(function () {
                    $('#loading').fadeOut(400, "linear");
                }, 300);
            });
        </script>
        <script>
            function OpenModal() {
                $('#myModal').modal('show');
            }
            function SubmitWarehouseForm() {
                var warehouse = $("#warehouse").val();
                var err = false;
                if (warehouse == "" || warehouse == null) {
                    $("#warehouse_chosen").css("border", "1px solid red");
                    err = true;
                }
                if (err == true) {
                    return false;
                } else {
                    $("#WarehouseForm").submit();
                }
            }
            function printReport(divName) {
                var printContents = '<table id="" width="100%" border="1" style="font-size:10px;padding-top:5px;padding-bottom:5px;" >' + document.getElementById(divName).innerHTML + '</table>';
                var header = document.getElementById('page-title').innerHTML;
                $(".my_hidden").removeClass("hidden-print");


                var originalContents = document.body.innerHTML;
                document.body.innerHTML = header + printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>

        <style>
            @media print {
                .btn-print { display:none;}
            }
        </style>

    </head>


    <body<?= $modal == TRUE ? ' onload="OpenModal();"' : '' ?>>
        <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Select Warehouse and Dates</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form name="WarehouseForm" method="post" id="WarehouseForm" action="<?= base_url() ?>reports/warehouse_general_statement" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Select Warehouse</label>
                                    <div class="col-sm-5" id="warehouse_div">
                                        <select name="warehouse" id="warehouse" class="chosen-select">
                                            <option id="option_after" value="">Select Option</option>
                                            <?php foreach ($warehouses as $warehouse) { ?>
                                                <option value="<?= $warehouse->warehouse_id ?>"><?= $warehouse->warehouse_name ?></option>

                                            <?php } ?>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">From Date</label>
                                    <div class="col-sm-6">
                                        <div class="input-prepend input-group">
                                            <span class="add-on input-group-addon">
                                                <i class="glyph-icon icon-calendar"></i>
                                            </span>
                                            <input id="from_date" name="from_date" type="text" class="bootstrap-datepicker form-control" value="<?php echo date("m-d-Y") ?>" data-date-format="mm/dd/yy">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">To Date</label>
                                    <div class="col-sm-6">
                                        <div class="input-prepend input-group">
                                            <span class="add-on input-group-addon">
                                                <i class="glyph-icon icon-calendar"></i>
                                            </span>
                                            <input id="to_date" name="to_date" type="text" class="bootstrap-datepicker form-control" value="<?php echo date("m-d-Y") ?>" data-date-format="mm/dd/yy">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button onclick="SubmitWarehouseForm();" type="button" class="btn btn-primary">Show Report</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="sb-site">
            <div class="sb-slidebar bg-black sb-left sb-style-overlay">
                <div class="scrollable-content scrollable-slim-sidebar">
                    <div class="pad10A">
                        <div class="divider-header">Online</div>
                        <ul class="chat-box">
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial1.jpg" alt="">
                                    <div class="small-badge bg-green"></div>
                                </div>
                                <b>
                                    Grace Padilla
                                </b>
                                <p>On the other hand, we denounce...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial2.jpg" alt="">
                                    <div class="small-badge bg-green"></div>
                                </div>
                                <b>
                                    Carl Gamble
                                </b>
                                <p>Dislike men who are so beguiled...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial3.jpg" alt="">
                                    <div class="small-badge bg-green"></div>
                                </div>
                                <b>
                                    Michael Poole
                                </b>
                                <p>Of pleasure of the moment, so...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial4.jpg" alt="">
                                    <div class="small-badge bg-green"></div>
                                </div>
                                <b>
                                    Bill Green
                                </b>
                                <p>That they cannot foresee the...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial5.jpg" alt="">
                                    <div class="small-badge bg-green"></div>
                                </div>
                                <b>
                                    Cheryl Soucy
                                </b>
                                <p>Pain and trouble that are bound...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                        </ul>
                        <div class="divider-header">Idle</div>
                        <ul class="chat-box">
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial6.jpg" alt="">
                                    <div class="small-badge bg-orange"></div>
                                </div>
                                <b>
                                    Jose Kramer
                                </b>
                                <p>Equal blame belongs to those...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial7.jpg" alt="">
                                    <div class="small-badge bg-orange"></div>
                                </div>
                                <b>
                                    Dan Garcia
                                </b>
                                <p>Weakness of will, which is same...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial8.jpg" alt="">
                                    <div class="small-badge bg-orange"></div>
                                </div>
                                <b>
                                    Edward Bridges
                                </b>
                                <p>These cases are perfectly simple...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                        </ul>
                        <div class="divider-header">Offline</div>
                        <ul class="chat-box">
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial1.jpg" alt="">
                                    <div class="small-badge bg-red"></div>
                                </div>
                                <b>
                                    Randy Herod
                                </b>
                                <p>In a free hour, when our power...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                            <li>
                                <div class="status-badge">
                                    <img class="img-circle" width="40" src="<?= base_url() ?>assets/image-resources/people/testimonial2.jpg" alt="">
                                    <div class="small-badge bg-red"></div>
                                </div>
                                <b>
                                    Patricia Bagley
                                </b>
                                <p>when nothing prevents our being...</p>
                                <a href="#" class="btn btn-md no-border radius-all-100 btn-black"><i class="glyph-icon icon-comments-o"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="sb-slidebar bg-black sb-right sb-style-overlay">
                <div class="scrollable-content scrollable-slim-sidebar">
                    <div class="pad15A">
                        <a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-1" class="popover-title">
                            Cloud status
                            <span class="caret"></span>
                        </a>
                        <div id="sidebar-toggle-1" class="collapse in">
                            <div class="pad15A container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center font-gray pad5B text-transform-upr font-size-12">New visits</div>
                                        <div class="chart-alt-3 font-gray-dark" data-percent="55"><span>55</span>%</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center font-gray pad5B text-transform-upr font-size-12">Bounce rate</div>
                                        <div class="chart-alt-3 font-gray-dark" data-percent="46"><span>46</span>%</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center font-gray pad5B text-transform-upr font-size-12">Server load</div>
                                        <div class="chart-alt-3 font-gray-dark" data-percent="92"><span>92</span>%</div>
                                    </div>
                                </div>
                                <div class="divider mrg15T mrg15B"></div>
                                <div class="text-center">
                                    <a href="#" class="btn center-div btn-info mrg5T btn-sm text-transform-upr updateEasyPieChart">
                                        <i class="glyph-icon icon-refresh"></i>
                                        Update charts
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-6" class="popover-title">
                            Latest transfers
                            <span class="caret"></span>
                        </a>
                        <div id="sidebar-toggle-6" class="collapse in">

                            <ul class="files-box">
                                <li>
                                    <i class="files-icon glyph-icon font-red icon-file-archive-o"></i>
                                    <div class="files-content">
                                        <b>blog_export.zip</b>
                                        <div class="files-date">
                                            <i class="glyph-icon icon-clock-o"></i>
                                            added on <b>22.10.2014</b>
                                        </div>
                                    </div>
                                    <div class="files-buttons">
                                        <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                                            <i class="glyph-icon icon-cloud-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                                            <i class="glyph-icon icon-times"></i>
                                        </a>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <i class="files-icon glyph-icon icon-file-code-o"></i>
                                    <div class="files-content">
                                        <b>homepage-test.html</b>
                                        <div class="files-date">
                                            <i class="glyph-icon icon-clock-o"></i>
                                            added  <b>19.10.2014</b>
                                        </div>
                                    </div>
                                    <div class="files-buttons">
                                        <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                                            <i class="glyph-icon icon-cloud-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                                            <i class="glyph-icon icon-times"></i>
                                        </a>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <i class="files-icon glyph-icon font-yellow icon-file-image-o"></i>
                                    <div class="files-content">
                                        <b>monthlyReport.jpg</b>
                                        <div class="files-date">
                                            <i class="glyph-icon icon-clock-o"></i>
                                            added on <b>10.9.2014</b>
                                        </div>
                                    </div>
                                    <div class="files-buttons">
                                        <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                                            <i class="glyph-icon icon-cloud-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                                            <i class="glyph-icon icon-times"></i>
                                        </a>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <i class="files-icon glyph-icon font-green icon-file-word-o"></i>
                                    <div class="files-content">
                                        <b>new_presentation.doc</b>
                                        <div class="files-date">
                                            <i class="glyph-icon icon-clock-o"></i>
                                            added on <b>5.9.2014</b>
                                        </div>
                                    </div>
                                    <div class="files-buttons">
                                        <a href="#" class="btn btn-xs hover-info tooltip-button" data-placement="left" title="Download">
                                            <i class="glyph-icon icon-cloud-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs hover-danger tooltip-button" data-placement="left" title="Delete">
                                            <i class="glyph-icon icon-times"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>

                        </div>

                        <div class="clear"></div>

                        <a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-3" class="popover-title">
                            Tasks for today
                            <span class="caret"></span>
                        </a>
                        <div id="sidebar-toggle-3" class="collapse in">

                            <ul class="progress-box">
                                <li>
                                    <div class="progress-title">
                                        New features development
                                        <b>87%</b>
                                    </div>
                                    <div class="progressbar-smaller progressbar" data-value="87">
                                        <div class="progressbar-value bg-azure">
                                            <div class="progressbar-overlay"></div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <b class="pull-right">66%</b>
                                    <div class="progress-title">
                                        Finishing uploading files

                                    </div>
                                    <div class="progressbar-smaller progressbar" data-value="66">
                                        <div class="progressbar-value bg-red">
                                            <div class="progressbar-overlay"></div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-title">
                                        Creating tutorials
                                        <b>58%</b>
                                    </div>
                                    <div class="progressbar-smaller progressbar" data-value="58">
                                        <div class="progressbar-value bg-blue-alt"></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-title">
                                        Frontend bonus theme
                                        <b>74%</b>
                                    </div>
                                    <div class="progressbar-smaller progressbar" data-value="74">
                                        <div class="progressbar-value bg-purple"></div>
                                    </div>
                                </li>
                            </ul>

                        </div>

                        <div class="clear"></div>

                        <a href="#" title="" data-toggle="collapse" data-target="#sidebar-toggle-4" class="popover-title">
                            Pending notifications
                            <span class="bs-label bg-orange tooltip-button" title="Label example">New</span>
                            <span class="caret"></span>
                        </a>
                        <div id="sidebar-toggle-4" class="collapse in">
                            <ul class="notifications-box notifications-box-alt">
                                <li>
                                    <span class="bg-purple icon-notification glyph-icon icon-users"></span>
                                    <span class="notification-text">This is an error notification</span>
                                    <div class="notification-time">
                                        a few seconds ago
                                        <span class="glyph-icon icon-clock-o"></span>
                                    </div>
                                    <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <span class="bg-warning icon-notification glyph-icon icon-ticket"></span>
                                    <span class="notification-text">This is a warning notification</span>
                                    <div class="notification-time">
                                        <b>15</b> minutes ago
                                        <span class="glyph-icon icon-clock-o"></span>
                                    </div>
                                    <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <span class="bg-green icon-notification glyph-icon icon-random"></span>
                                    <span class="notification-text font-green">A success message example.</span>
                                    <div class="notification-time">
                                        <b>2 hours</b> ago
                                        <span class="glyph-icon icon-clock-o"></span>
                                    </div>
                                    <a href="#" class="notification-btn btn btn-xs btn-black tooltip-button" data-placement="left" title="View details">
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loading">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>

            <div id="page-wrapper">
                <div class="hidden-print">
                    <?php $this->load->view("components/header") ?>
                </div>
                <?php $this->load->view("components/sidebar") ?>
                <div id="page-content-wrapper">
                    <div id="page-content">

                        <div class="container">


                            <!-- Data tables -->

    <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/datatable/datatable.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/datatable/datatable.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/datatable/datatable-responsive.js"></script>

                            <script type="text/javascript">

                            /* Datatables responsive */

                            $(document).ready(function () {
                                $('#datatable-responsive').DataTable({
                                    responsive: true
                                });
                            });

                            $(document).ready(function () {
                                $('.dataTables_filter input').attr("placeholder", "Search...");
                            });

                            </script>

                            <div id="page-title" style="overflow: hidden;">

                                <h2>Warehouse Statement<?= !empty($warhous) ? " for <i>" . $warhous . "</i>" : "" ?></h2>
                                <p>Detailed report<?= isset($from_date) ? " from <b>" . date("j F, Y", strtotime($from_date)) . "</b> To <b>" . date("j F, Y", strtotime($to_date)) . "</b>" : "" ?></p>
                                <button class="btn btn-primary btn-print" onclick="printReport('PrintArea');">Print </button>
                            </div>

                            <div class="panel">
                                <div class="panel-body">
                                    <div class="example-box-wrapper">
                                        <table id="PrintArea" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th colspan="3" style="text-align: center">Opening Balance</th>
                                                    <th colspan="3" style="text-align: center">RECEIEVED</th>
                                                    <th >ISSUE</th>
                                                    <th colspan="3" style="text-align: center">BALANCE</th>
                                                </tr>
                                                <tr style="text-align: justify;">
                                                    <th></th>
                                                    <th>QTY</th>
                                                    <th>RATE</th>
                                                    <th>AMOUNT</th>
                                                    <th>QTY</th>
                                                    <th>RATE</th>
                                                    <th>AMOUNT</th>
                                                    <th>Qty</th>
                                                    <th>QTY</th>
                                                    <th>AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_debit = 0;
                                                $total_credit = 0;
                                                $total_debit1 = 0;
                                                $total_credit1 = 0;
                                                $balance=0;
                                                $total_balance = 0;
                                                $total_issue_qty=0.00;
                                                $my_counter = 1;
                                                $total_current_instock=0;
                                                $total_amount_received=0;
                                                $total_amount_opening_balance=0.00;
                                                $total_amount_balance = 0.00;


                                                if (!empty($prev_balnc)) {
                                                    foreach ($prev_balnc as $balnc) {

                                                        $balance = $balnc["product_balnc"];
                                                        $current_instock = $balnc["product_balnc"];
                                                        
//                                                        print_r($balance);
                                                        //product
                                                        if (!empty($products_report)) {

                                                            foreach ($products_report as $value) {

                                                                if ($balnc["product_id"] == $value[0]->product_id) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $balnc["product_name"] . "</td>";
                                                                    echo "<td>" . number_format((float) $balnc["product_balnc"], 2, '.', '') . " " . $balnc["unit_symbol"] . "</td>";

                                                                    $value[0]->issued == null ? $value[0]->issued = 0 : $value[0]->issued = $value[0]->issued;
                                                                    
                                                                    $value[0]->received == null ? $value[0]->received = 0 : $value[0]->received = $value[0]->received;
                                                                    
                                                                    $balance = ($balance + $value[0]->received) - $value[0]->issued;
                                                                    


                                                                    //loop through avg prices
                                                                    // foreach ($product_avg_price as $key => $val) {
                                                                    //     if($value[0]->product_id==$key){
                                                                    //         $rate=$val;
                                                                    //     }
                                                                    //     # code...
                                                                    // }
                                                                    //loop through avg prices
                                                                   $rate = !empty($value[0]->purchase_price) ? $value[0]->purchase_price : $value[0]->sale_price;
                                                                    $rate=number_format((float) $rate, 2, '.', '');
                                                                    $amount_received = (abs($value[0]->received)) * ($rate);
                                                                    $amount_received = number_format((float) $amount_received, 2, '.', '');
                                                                    

                                                                    $amount_opening_balance = (abs($balnc["product_balnc"])) * ($rate);
                                                                    $amount_opening_balance = number_format((float) $amount_opening_balance, 2, '.', '');
                                                                    

                                                                    $amount_balance = (abs($balance)) * ($rate);
                                                                    $amount_balance = number_format((float) $amount_balance, 2, '.', '');
                                                                    

                                                                    ?>
                                                                <td><?= number_format((float) $rate, 2, '.', '') . " Rs" ?></td>
                                                                <td><?= $amount_opening_balance . " Rs" ?></td>
                                                                <td><?= number_format((float) $value[0]->received, 2, '.', '') . " " . $value[0]->unit_symbol ?></td>
                                                                <td><?= number_format((float) $rate, 2, '.', '') . " Rs" ?></td>
                                                                <td><?= $amount_received . " Rs" ?></td>
                                                                <td><?= number_format((float) $value[0]->issued, 2, '.', '') . " " . $value[0]->unit_symbol ?> </td>
                                                                <td><?= number_format($balance, 2, '.', '') . " " . $value[0]->unit_symbol ?></td>
                                                                <td><?= $amount_balance . " Rs" ?></td>



                                                                <?php

                                                                $total_current_instock += $current_instock; 
                                                                $total_issue_qty+=$value[0]->issued;
                                                                $total_balance +=  $balance;
                                                               
                                                                $total_amount_received+= $amount_received;
                                                                $total_amount_opening_balance+= $amount_opening_balance;
                                                                $total_amount_balance+= $amount_balance;
                                                                 $total_credit1= $total_credit+ $value[0]->received;


                                                                $current_instock = number_format($balance, 2, '.', '');
                                                                $total_debit = $total_debit + $value[0]->issued;
                                                                $total_credit = $total_credit + $value[0]->received;



                                                                
                                                                echo "</tr>";

                                                            }
                                                        }
                                                    }
                                                    ?>



                                                    <?php
                                                    $my_counter++;
                                                    //product
                                                }
                                            }
                                            ?>
<tr>
    <td style="font-size: 18px; font-style: italic"><b>Total</b></td>
    <td style="font-size: 18px; font-style: italic"><b></b></td>
    <td style="font-size: 18px; font-style: italic"></td>
    <td style="font-size: 18px; font-style: italic"><b><?=$total_amount_opening_balance?> Rs</b></td>
    <td style="font-size: 18px; font-style: italic"><b></b></td>
    <td style="font-size: 18px; font-style: italic"></td>
    <td style="font-size: 18px; font-style: italic"><b><?=$total_amount_received?></b> Rs</td>
    
    
    <td style="font-size: 18px; font-style: italic"><b></b></td>
    <td style="font-size: 18px; font-style: italic"><b></b></td>
    <td style="font-size: 18px; font-style: italic"><b><?=$total_amount_balance?></b> Rs</td>
    


</tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>



                    </div>
                </div>
            </div>


            <!-- JS Demo -->
            <script type="text/javascript" src="<?= base_url() ?>assets-minified/admin-all-demo.js"></script>

            <script>
                                    function EditUnit(unit_id) {
                                        window.location.href = "<?= base_url() ?>units/view/" + unit_id;
                                        //        $.post("<?//= base_url() ?>users/edit", {id: user_id})
                                        //            .done(function (data) {
                                        //                if ($.trim(data) == 'done') {
                                        //                    window.location.href = "<?= base_url() ?>dashboard";
                                        //                }
                                        //                if ($.trim(data) == 'failed') {
                                        ////                                                            alert('here');
                                        //                    window.location.href = "<?= base_url() ?>";
                                        //
                                        //                }
                                        //            });
                                    }
                                    function DeleteUnit(unit_id) {
                                        var cnfirm = confirm("Are You Sure?");
                                        if (cnfirm) {
                                            $.post("<?= base_url() ?>units/delete", {id: unit_id})
                                                    .done(function (data) {
                                                        //                                                                                    alert(data);
                                                        if ($.trim(data) == 'done') {
                                                            location.reload(true);
                                                        }
                                                    });
                                        }
                                    }
                                    function AddUser() {
                                        window.location.href = "<?= base_url() ?>units/add";
                                    }
                                    $("#sld").click(function () {
                                        $("#sld_u_d").slideUp();
                                    });
                                    function OpenBox(counter) {

                                        $("#tbody-" + counter).toggle("slow");
                                    }


            </script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#from_date").bsdatepicker({
                        format: 'mm-dd-yyyy',
                    });
                    $("#to_date").bsdatepicker({
                        format: 'mm-dd-yyyy',
                    });
                    $('#from_date').on('changeDate', function (ev) {
                        $(this).bsdatepicker('hide');
                    });
                    $('#to_date').on('changeDate', function (ev) {
                        $(this).bsdatepicker('hide');
                    });
                });
            </script>
        </div>
        <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">Edit User</h4>
                                        </div>
                                        <div class="modal-body">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
    </body>

</html>
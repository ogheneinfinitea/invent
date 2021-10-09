<!DOCTYPE html>
<html  lang="en">

    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: General Statement </title>
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
            function SubmitAccountForm(key = null) {
                if (key == 'today') {
                    $("#today_hidden").val('1');
                    $("#AccountForm").submit();
                }
                if (key == 'month') {
                    $("#month_hidden").val('1');

                    $("#AccountForm").submit();
                }
                if (key == 'week') {
                    $("#week_hidden").val('1');
                    $("#AccountForm").submit();
                }
                if (key == null) {
                    $("#AccountForm").submit();
            }

            }
            function printdetailedsummary(divName) {
                $(".sales").show();
                $("tr[class^='account_sales']").show();
                $(".purchases").show();
                $("tr[class^='account_purchases']").show();
                $(".journals").show();
                $("tr[class^='account_purchases']").show();
                var printContents = document.getElementById(divName).innerHTML;
                var header = document.getElementById('page-title').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = header + printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
            function printaccountsummary(divName) {
                $(".sales").show();
                $("tr[class^='account_sales']").hide();
                $(".purchases").show();
                $("tr[class^='account_purchases']").hide();
                $(".journals").show();
                $("tr[class^='account_purchases']").hide();
                var printContents = document.getElementById(divName).innerHTML;
                var header = document.getElementById('page-title').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = header + printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
            function printsummary(divName) {
                $(".sales").hide();
                $("tr[class^='account_sales']").hide();
                $(".purchases").hide();
                $("tr[class^='account_purchases']").hide();
                $(".journals").hide();
                $("tr[class^='account_purchases']").hide();
                var printContents = document.getElementById(divName).innerHTML;
                var header = document.getElementById('page-title').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = header + printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
        <style>
            @media print {
                .btn-print { display:none;}
                .pluss { display:none;}

            }
        </style>


    </head>


    <body<?= $modal == TRUE ? ' onload="OpenModal();"' : '' ?>>
        <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Select Account and Dates</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form name="AccountForm" method="post" id="AccountForm" action="<?= base_url() ?>reports/general_statement" class="form-horizontal">

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
                                <input type="hidden" name="today_hidden" id="today_hidden" value="0"/>
                                <input type="hidden" name="month_hidden" id="month_hidden" value="0"/>
                                <input type="hidden" name="week_hidden" id="week_hidden" value="0"/>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" btn btn-default" data-dismiss="modal">Close</button>
                        <button onclick="SubmitAccountForm('today');" type="button" class=" btn btn-primary">Today</button>
                        <button onclick="SubmitAccountForm('month');" type="button" class=" btn btn-primary">Last Month</button>
                        <button onclick="SubmitAccountForm('week');" type="button" class=" btn btn-primary">Last Week</button>
                        <button onclick="SubmitAccountForm();" type="button" class=" btn btn-primary">Show Report</button>
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
                                <h2>General Statement Report<?= !empty($account_name) ? " for <i>" . $account_name . "</i>" : "" ?></h2>
                                <p>Detailed report<?= isset($from_date) ? " from <b>" . date("j F, Y", strtotime($from_date)) . "</b> To <b>" . date("j F, Y", strtotime($to_date)) . "</b>" : "" ?></p>
                               <!--  <button class="btn btn-success btn-print" onclick="OpenModal()
                                                ;">Filter</button> -->
                                <button class="btn btn-primary btn-print" onclick="printdetailedsummary('PrintArea');">Print Detailed Summary</button>
                                <button class="btn btn-primary btn-print" onclick="printaccountsummary('PrintArea');">Print Summary With Accounts </button>
                                <button class="btn btn-primary btn-print" onclick="printsummary('PrintArea');">Print Summary </button>
                            </div>

                            <div id='PrintArea' class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">
                                        General Statement
                                    </h3>
                                    <div class="example-box-wrapper">
                                        <h2> Sales</h2><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('sales')
                                                        ;">+</span>
                                        <table class="table">



                                            <tbody>
                                                <tr class="sales">
                                                    <th><h3><strong>Date</strong></h3></th>
                                                    <th><h3><strong>Account</strong></h3></th>
                                                    <th><h3><strong>Description</strong></h3></th>
                                                    <th><h3><strong>Amount</strong></h3></th>
<!--                                                    <th><h3><strong>Debit Amount</strong></h3></th>-->
<!--                                                    <th><h3><strong>Credit Amount</strong></h3></th>-->
                                                </tr>
                                                <?php
                                                $grand_total_sales = 0.00;
                                                if (isset($sales)) {
                                                    if (!empty($purchases)) {
                                                        foreach ($sales as $a => $s) {
                                                            ?>
                                                            <tr class="sales">
                                                                <th></th>
                                                                <th >
                                                                    <h3 ><strong><?= $a ?></strong></h3>
                                                                </th>

                                                                <th></th>
                                                                <th><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('account_sales<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>')
                                                                                            ;">+</span></th>
                                                            </tr>
                                                            <?php
                                                            $total_sales_debit = 0.00;
                                                            $total_sales_credit = 0.00;
                                                            foreach ($s as $ss) {
                                                                $ss = explode("%", $ss);

//
                                                                ?>
                                                                <tr class="account_sales<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>">
                                                                    <td><?= date("j/F/Y", strtotime($ss[1])) ?></td>
                                                                    <td></td>
                                                                    <td><?= html_entity_decode($ss[2]) ?></td>
                                                                    <td>
                                                                        <?= $ss[3] == 'd' ? $ss[0] . ' Rs/-' : '0 Rs/-' ?>
                                                                    </td>
                <!--                                                                    <td>
                                                                    <?php // $ss[3] == 'c' ? $ss[0] . ' Rs/-' : '0 Rs/-' ?>
                                                                    </td>-->
                                                                </tr>
                                                                <?php
                                                                $total_sales_debit += $ss[3] == 'd' ? $ss[0] : 0;
                                                                //$total_sales_credit += $ss[3] == 'c' ? $ss[0] : 0;
                                                            }
                                                            ?>
                                                            <tr class="sales"><td colspan="3"><h3 class=" font-italic"><strong>Total Sales</strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?php
                                                                            $grand_total_sales += $total_sales_debit - $total_sales_credit;
                                                                            echo $total_sales_debit - $total_sales_credit . ' Rs/-'
                                                                            ?></strong></h3></td></tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr><td colspan="3"><h3 class=" font-italic"><strong>Grand Total<small>(Sales)</small></strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?= $grand_total_sales . ' Rs/-' ?></strong></h3></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="example-box-wrapper">
                                        <h2> Purchases</h2><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('purchases');">+</span>
                                        <table class="table">



                                            <tbody>
                                                <tr class="purchases">
                                                    <th><h3><strong>Date</strong></h3></th>
                                                    <th><h3><strong>Account</strong></h3></th>
                                                    <th><h3><strong>Description</strong></h3></th>
                                                    <th><h3><strong>Amount</strong></h3></th>
<!--                                                    <th><h3><strong>Debit Amount</strong></h3></th>
                                                    <th><h3><strong>Credit Amount</strong></h3></th>-->
                                                </tr>
                                                <?php
                                                $grand_total_purchases = 0.00;
                                                if (isset($purchases)) {
                                                    if (!empty($purchases)) {
                                                        foreach ($purchases as $a => $p) {
                                                            ?>
                                                            <tr class="purchases">
                                                                <th></th>
                                                                <th >
                                                                    <h3><strong><?= $a ?></strong></h3>
                                                                </th>

                                                                <th></th>
                                                                <th><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('account_purchases<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>')
                                                                                            ;">+</span></th>
                                                            </tr>
                                                            <?php
                                                            $total_purchases_debit = 0.00;
                                                            $total_purchases_credit = 0.00;

                                                            foreach ($p as $pp) {
                                                                $pp = explode("%", $pp);
//
                                                                ?>
                                                                <tr class="account_purchases<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>">
                                                                    <td><?= date("j/F/Y", strtotime($pp[1])) ?></td>
                                                                    <td></td>
                                                                    <td><?= html_entity_decode($pp[2]) ?></td>
                <!--                                                                    <td>
                                                                    <?php // $pp[3] == 'd' ? $pp[0] . ' Rs/-' : '0 Rs/-' ?>
                                                                    </td>-->
                                                                    <td>
                                                                        <?= $pp[3] == 'c' ? $pp[0] . ' Rs/-' : '0 Rs/-' ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                //$total_purchases_debit += $pp[3] == 'd' ? $pp[0] : 0;
                                                                $total_purchases_credit += $pp[3] == 'c' ? $pp[0] : 0;
                                                            }
                                                            ?>
                                                            <tr class="purchases"><td colspan="3"><h3 class=" font-italic"><strong>Total Purchases</strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?php
                                                                            $grand_total_purchases += $total_purchases_debit - $total_purchases_credit;
                                                                            echo $total_purchases_debit - $total_purchases_credit . ' Rs/-'
                                                                            ?></strong></h3></td></tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr><td colspan="3"><h3 class=" font-italic"><strong>Grand Total<small>(Purchases)</small></strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?= $grand_total_purchases . ' Rs/-' ?></strong></h3></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="example-box-wrapper">
                                        <h2> Journals</h2><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('journals');">+</span>
                                        <table class="table">



                                            <tbody>
                                                <tr class="journals">
                                                    <th><h3><strong>Date</strong></h3></th>
                                                    <th><h3><strong>Account</strong></h3></th>
                                                    <th><h3><strong>Description</strong></h3></th>
                                                    <th><h3><strong>Debit Amount<br><small>(From Office Account)</small></strong></h3></th>
                                                    <!--<th><h3><strong>Credit Amount<br><small>(In Office Account)</small></strong></h3></th>-->
                                                </tr>
                                                <?php
                                                // office debit account
                                                $grand_total_journals = 0.00;
                                                $total_journals_debit_office = 0.00;
                                                $total_journals_credit_office = 0.00;
                                                if (isset($office_account)) {
                                                    if (!empty($office_account)) {
                                                        ?>
                                                        <tr class="journals">
                                                            <th></th>
                                                            <th >
                                                                <h3><strong>Office Account</strong></h3>
                                                            </th>

                                                            <th></th>
                                                            <th><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('account_journals_office_account_debit')
                                                                                    ;">+</span></th>
                                                        </tr>
                                                        <?php
                                                        foreach ($office_account as $o_a) {
                                                            if ($o_a->debit_amount != NULL) {
                                                                ?>

                                                                <tr class="account_journals_office_account_debit">
                                                                    <td><?= date("j/F/Y", strtotime($o_a->date)) ?></td>
                                                                    <td><?php
                                                                        $account_data = $this->web->GetOne("account_id", "accounts", $o_a->to_account);
                                                                        echo $account_data[0]->account_name;
                                                                        ?>
                                                                    </td>
                                                                    <td><?= html_entity_decode($o_a->ledger_description) ?></td>
                                                                    <td>
                                                                        <?= $o_a->debit_amount . '0 Rs/-' ?>
                                                                    </td>
                <!--                                                                <td>
                                                                    <?php //$o_a->credit_amount . '0 Rs/-'   ?>
                                                                    </td>-->
                                                                </tr>
                                                                <?php
                                                                $total_journals_debit_office += $o_a->debit_amount;
//                                                            $total_journals_credit_office += $o_a->credit_amount;
                                                            }
                                                        }
                                                        ?>
                                                        <tr class="journals"><td colspan="3"><h3 class=" font-italic"><strong>Total Journals</strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?php
                                                                        echo $total_journals_debit_office . 'Rs/-';
//                                                        $grand_total_journals += $total_journals_credit_office - $total_journals_debit_office;
//                                                                        echo $total_journals_credit_office - $total_journals_debit_office . ' Rs/-'
                                                                        ?></strong></h3></td></tr>
                                                        <?php
                                                    }
                                                }
                                                // office debit account
                                                ?>
                                                <tr class="journals">
                                                    <th><h3><strong>Date</strong></h3></th>
                                                    <th><h3><strong>Account</strong></h3></th>
                                                    <th><h3><strong>Description</strong></h3></th>
                                                    <!--<th><h3><strong>Debit Amount<br><small>(From Office Account)</small></strong></h3></th>-->
                                                    <th><h3><strong>Credit Amount<br><small>(In Office Account)</small></strong></h3></th>
                                                </tr>
                                                <?php
                                                // office debit account
                                                $grand_total_journals = 0.00;
                                                $total_journals_debit_office = 0.00;
                                                $total_journals_credit_office = 0.00;
                                                if (isset($office_account)) {
                                                    if (!empty($office_account)) {
                                                        ?>
                                                        <tr class="journals">
                                                            <th></th>
                                                            <th >
                                                                <h3><strong>Office Account</strong></h3>
                                                            </th>

                                                            <th></th>
                                                            <th><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('account_journals_office_account_debit')
                                                                                    ;">+</span></th>
                                                        </tr>
                                                        <?php
                                                        foreach ($office_account as $o_a) {
                                                            if ($o_a->credit_amount != NULL) {
                                                                ?>

                                                                <tr class="account_journals_office_account_debit">
                                                                    <td><?= date("j/F/Y", strtotime($o_a->date)) ?></td>
                                                                    <td><?php
                                                                        $account_data = $this->web->GetOne("account_id", "accounts", $o_a->from_account);
                                                                        echo $account_data[0]->account_name;
                                                                        ?>
                                                                    </td>
                                                                    <td><?= html_entity_decode($o_a->ledger_description) ?></td>
                <!--                                                                <td>
                                                                    <?php // $o_a->debit_amount . '0 Rs/-'   ?>
                                                                    -->                                                                </td>
                                                                    <td>
                                                                        <?= $o_a->credit_amount . '0 Rs/-' ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
//                                                            $total_journals_debit_office += $o_a->debit_amount;
                                                                $total_journals_credit_office += $o_a->credit_amount;
                                                            }
                                                        }
                                                        ?>
                                                        <tr class="journals"><td colspan="3"><h3 class=" font-italic"><strong>Total Journals</strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?php
                                                                        echo $total_journals_credit_office . 'Rs/-';
//                                                        $grand_total_journals += $total_journals_credit_office - $total_journals_debit_office;
//                                                                        echo $total_journals_credit_office - $total_journals_debit_office . ' Rs/-'
                                                                        ?></strong></h3></td></tr>
                                                        <?php
                                                    }
                                                }
                                                // office debit account
                                                ?>
                                                <?php
                                                if (isset($journals)) {
                                                    if (!empty($journals)) {
                                                        foreach ($journals as $a => $j) {
                                                            ?>
                                                            <tr class="journals">
                                                                <th></th>
                                                                <th colspan="3">
                                                                    <h3><strong><?= $a ?></strong></h3>
                                                                </th>

                                                                <th><span class="pluss" style='font-size:25px; font-weight:bold;color:blue; cursor:pointer;' onclick="openbox('account_journals<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>')
                                                                                            ;">+</span></th>
                                                            </tr>
                                                            <?php
                                                            $total_journals_debit = 0.00;
                                                            $total_journals_credit = 0.00;

                                                            foreach ($j as $jj) {
                                                                $jj = explode("%", $jj);

//
                                                                ?>
                                                                <tr class="account_journals<?= preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", "_", $a)) ?>">
                                                                    <td><?= date("j/F/Y", strtotime($jj[1])) ?></td>
                                                                    <td></td>
                                                                    <td><?= html_entity_decode($jj[2]) ?></td>
                                                                    <td>
                                                                        <?= $jj[3] == 'd' ? $jj[0] . ' Rs/-<br>(outgoing from Office Account to "' . $a . '")' : '0 Rs/-' ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $jj[3] == 'c' ? $jj[0] . ' Rs/-<br>(incomings in Office Account from "' . $a . '")' : '0 Rs/-' ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $total_journals_debit += $jj[3] == 'd' ? $jj[0] : 0;
                                                                $total_journals_credit += $jj[3] == 'c' ? $jj[0] : 0;
                                                            }
                                                            ?>
                                                            <tr class="journals"><td colspan="4"><h3 class=" font-italic"><strong>Total Journals</strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?php
                                                                            $grand_total_journals += $total_journals_credit - $total_journals_debit;
                                                                            echo $total_journals_credit - $total_journals_debit . ' Rs/-'
                                                                            ?></strong></h3></td></tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr><td colspan="3"><h3 class=" font-italic"><strong>Grand Total<small>(Journals)</small></strong></h3></td><td colspan="1"><h3 class=" font-italic"><strong><?= $grand_total_journals . ' Rs/-' ?></strong></h3></td></tr>
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
                                                                    function openbox(class_key) {
                                                                        if (class_key == 'sales') {
                                                                            $("." + class_key).toggle("slow");

                                                                            if ($("." + class_key + ":visible")) {
                                                                                $("tr[class^='account_sales']").hide();
                                                                            } else {
                                                                                $("tr[class^='account_sales']").show();
                                                                            }

//                                                                        $("tr[class^='account_sales']").toggle("slow");

                                                                        }
                                                                        if (class_key == 'purchases') {
                                                                            $("." + class_key).toggle("slow");
                                                                            if ($("." + class_key + ":visible")) {
                                                                                $("tr[class^='account_purchases']").hide();
                                                                            } else {
                                                                                $("tr[class^='account_purchases']").show();
                                                                            }

//                                                                        $("tr[class^='account_purchases']").toggle("slow");
                                                                        }
                                                                        if (class_key == 'journals') {
                                                                            $("." + class_key).toggle("slow");
                                                                            if ($("." + class_key + ":visible")) {
                                                                                $("tr[class^='account_journals']").hide();
                                                                            } else {
                                                                                $("tr[class^='account_journals']").show();
                                                                            }

//                                                                        $("tr[class^='account_journals']").toggle("slow");
                                                                        }
                                                                        if (class_key != 'sales' && class_key != 'purchases' && class_key != 'journals')
                                                                        {
                                                                            $("." + class_key).toggle("slow");
                                                                        }



                                                                    }

            </script>
            <script type="text/javascript">
                 $(document).ready(function(){
                    $("#from_date").bsdatepicker({
                         format: 'mm-dd-yyyy',
                    });
                     $("#to_date").bsdatepicker({
                         format: 'mm-dd-yyyy',
                    });
                     $('#from_date').on('changeDate', function(ev){
                         $(this).bsdatepicker('hide');
                    });
                      $('#to_date').on('changeDate', function(ev){
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
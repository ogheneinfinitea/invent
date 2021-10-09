<!DOCTYPE html>
<html  lang="en">

    <!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/forms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:11:32 GMT -->
    <head>

        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
        </style>


        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Forms elements </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Favicons -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?= base_url() ?>assets/images/icons/favicon.png">



        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets-minified/admin-all-demo.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/jquery-ui.css">

        <!-- JS Core -->

        <script type="text/javascript" src="<?= base_url() ?>assets-minified/js-core.js"></script>





        <script type="text/javascript">
            $(window).load(function () {
                setTimeout(function () {
                    $('#loading').fadeOut(400, "linear");
                }, 300);
            });
        </script>



    </head>


    <body>
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
                <?php $this->load->view("components/header") ?>
                <?php $this->load->view("components/sidebar") ?>
                <div id="page-content-wrapper">
                    <div id="page-content">

                        <div class="container">


                            <!-- jQueryUI Spinner -->

                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/spinner/spinner.js"></script>
                            <script type="text/javascript">
            /* jQuery UI Spinner */

            $(function () {
                "use strict";
                $(".spinner-input").spinner();
            });
                            </script>

                            <!-- jQueryUI Autocomplete -->

                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/autocomplete.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/menu.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/autocomplete-demo.js"></script>
                            <script>
            // $(function () {
//                var availableTags = [
//<?//= $products_suggestions ?>
            //  ];
            //$(".product").autocomplete({//
//                    source: availableTags
//                });
            //});
                            </script>
                            <!-- Touchspin -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/touchspin/touchspin.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/touchspin/touchspin.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/touchspin/touchspin-demo.js"></script>

                            <!-- Input switch -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/input-switch/inputswitch.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/input-switch/inputswitch.js"></script>
                            <script type="text/javascript">
            /* Input switch */

            $(function () {
                "use strict";
                $('.input-switch').bootstrapSwitch();
            });
                            </script>

                            <!-- Textarea -->

                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/textarea/textarea.js"></script>
                            <script type="text/javascript">
            /* Textarea autoresize */

            $(function () {
                "use strict";
                $('.textarea-autosize').autosize();
            });
                            </script>

                            <!-- Multi select -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/multi-select/multiselect.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/multi-select/multiselect.js"></script>
                            <script type="text/javascript">
            /* Multiselect inputs */

            $(function () {
                "use strict";
                $(".multi-select").multiSelect();
                $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
            });
                            </script>

                            <!-- Uniform -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/uniform/uniform.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/uniform/uniform.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/uniform/uniform-demo.js"></script>

                            <!-- Chosen -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/chosen/chosen.css">-->
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
                            <div id="page-title">
                                <h2>Add a new Purchase</h2>
                                <p>Add Required information for Purchase</p>

                            </div>

                            <div class="panel">
                                <div class="panel-body">
                                    <div id="error_msg" class="font-red" style="font-size:18px; font-weight: bold;">

                                    </div>
                                    <h3 class="title-hero">
                                        Add
                                    </h3>
                                    <div class="example-box-wrapper">
                                        <form method="post" action="<?= base_url() ?>purchase/add" id="SubmitAdd" class="form-horizontal bordered-row">
                                            <div class="form-group">
                                                <label for="" class="col-sm-2 control-label">Date</label>
                                                <div class="col-sm-4">
                                                    <div class="input-prepend input-group">
                                                        <span class="add-on input-group-addon">
                                                            <i class="glyph-icon icon-calendar"></i>
                                                        </span>
                                                        <input id="date" name="date" type="text" class="bootstrap-datepicker form-control" autoclose="true"  value="<?php echo date("m-d-Y") ?>" data-date-format="mm/dd/yy">
                                                    </div>
                                                </div>
                                                <label class="col-sm-2 control-label">Select Account</label>
                                                <div class="col-sm-4">
                                                    <select name="account" onchange="Validation()" id="account" class="chosen-select">
                                                        <option value="">Select Option</option>
                                                        <?php foreach ($accounts as $account) { ?>
                                                            <option value="<?= $account->account_id ?>"><?= $account->account_name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" id="product_suggestions" value="<?= $products_suggestions ?>" />
                                            <div class="form-group">
                                                <label class="col-sm-8">Products</label>
                                                <div class="col-sm-4">
                                                    <button  type="button" onclick="add_product();" class="btn btn-danger pull-right" style="height: 20px;padding: 0;padding-right: 2px;padding-left: 2px;line-height: 20px;">
                                                        <i class="glyph-icon icon-plus"></i>
                                                        <span>Add New</span>
                                                    </button>
                                                </div>
                                                <div id="add_product" onchange="Validation()">

                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-4" style="font-size: 22px; font-weight: bold; color:#003eff;">Total</div>
                                                    <div id="tot_dis" class="col-sm-2" style="font-size: 20px; font-weight: bold;">₦ <span>0.00</span></div>
                                                    <div id="total" class="col-sm-3" style="font-size: 22px; font-weight: bold; color:#003eff;">₦ <span>0.00</span>
                                                        <input type="hidden" name="invoice_total" id="invoice_total" />
                                                    </div>
                                                </div>

                                            </div>
                                            <script>




//                                                document.getElementsByClassName("discount").addEventListener('keyup', checkTabPress);
                                                function checkTabPress(e) {
                                                    if (e.keyCode == 9) {
                                                        add_product();
                                                    }
                                                }



                                                function setTwoNumberDecimal(id) {

                                                    $("#" + id).val(parseFloat($("#" + id).val()).toFixed(2));
                                                }
                                                function  CalculateSubTotal(id) {
                                                    var purchase_price = $("#purchase_price" + id).val();

                                                    var purchase_price = $("#qty" + id).val() * purchase_price;

                                                    var discount = $("#discount" + id).val();
                                                    var sub_total = purchase_price - discount;
                                                    $("#sub_total" + id).val(parseFloat(sub_total).toFixed(2));
                                                    TotalInvoiceAmount();

                                                }
                                                function TotalInvoiceAmount() {
                                                    var total = 0;
                                                    var total_discount = parseFloat($("#total_discount").val());
                                                    var tax = parseFloat($("#tax").val());
                                                    if (isNaN(total_discount)) {
                                                        total_discount = 0;
                                                    }
                                                    if (isNaN(tax)) {
                                                        tax = 0;
                                                    }
                                                    $(".sub_total").each(function () {
                                                        total += parseFloat($(this).val());
                                                    });
                                                    $("#tot_dis span").html(parseFloat(total_discount).toFixed(2));
                                                    $('#total span').html(parseFloat((total - total_discount) + tax).toFixed(2));
                                                    $("#invoice_total").val(parseFloat((total - total_discount) + tax).toFixed(2));
                                                }
                                                function add_units(u_id, unit_symbol) {
                                                    u_id = u_id.replace("product_name", "");
                                                    $("#div_qty" + u_id + " span").remove();
                                                    $("#div_purchase_price" + u_id + " span").remove();
                                                    $("#div_discount" + u_id + " span").remove();

                                                    $("#div_qty" + u_id).append('<span class="input-group-addon bootstrap-touchspin-postfix">' + unit_symbol + '</span>');
                                                    $("#div_purchase_price" + u_id).append('<span class="input-group-addon bootstrap-touchspin-postfix">₦</span>');
                                                    $("#div_discount" + u_id).append('<span class="input-group-addon bootstrap-touchspin-postfix">₦</span>');

                                                }
                                                function add_product() {
                                                    var id = "0";
                                                    $("#add_product div.prod").each(function () {
                                                        id = "";
                                                        var curr_prod = $(this).attr("id");
                                                        curr_prod = curr_prod.replace("prod", "");
                                                        id = parseInt(curr_prod) + 1;
                                                    }
                                                    );
                                                    var html = '<div class="col-sm-12 prod" id="prod' + id + '"><div class="col-sm-3">';
                                                    html += '<div class="input-group"><select onchange=' + 'add_units(this.id,this.options[this.selectedIndex].getAttribute("unit_symbol")),Validation()' + '  name="product_name[]" id="product_name' + id + '" class="chosen-select">' + $("#product_suggestions").val() + '</select></div>';
                                                    html += '</div><div  class=" col-sm-2"><div id="div_qty' + id + '" class="input-group"><input step=".01" type="number" name="qty[]" id="qty' + id + '" class="form-control" placeholder="Qty"></div></div>';
                                                    html += '<div class="col-sm-2"><div id="div_purchase_price' + id + '" class="input-group"><input type="number" onblur="setTwoNumberDecimal(this.id)" onkeyup="CalculateSubTotal(' + id + ');" step="0.01" name="purchase_price[]" id="purchase_price' + id + '" class="form-control" placeholder="Purchase Price"></div></div>';
                                                    html += '<div class="col-sm-2"><div id="div_discount' + id + '" class="input-group"><input type="number" onblur="setTwoNumberDecimal(this.id)" step="0.01" onkeydown="checkTabPress(event);" onkeyup="CalculateSubTotal(' + id + ');"  name="discount[]" id="discount' + id + '" class="form-control discount" placeholder="Discount"></div></div>';
                                                    html += '<div class="col-sm-2"><div class="input-group"><input type="number" readonly="" onblur="setTwoNumberDecimal(this.id)" step="0.01" name="sub_total[]" id="sub_total' + id + '" value="0.00" class="form-control sub_total" placeholder="Sub Total"></div></div>';
                                                    html += '<div class="col-sm-1"><div class="input-group"><button type="button"  onclick="DelProd(' + id + ')" class="btn btn-danger cross" onkeydown="checkTabPress(event);">X</button></div></div> </div>';
//                                                    alert(html);
                                                    $("#add_product").append(html);
//                                                    alert($("#product_name" + id).next("div").children("a").text());
                                                    $(function () {
                                                        "use strict";
                                                        $(".chosen-select").chosen(), $(".chosen-search").append('<i class="glyph-icon icon-search"></i>'), $(".chosen-single div").html('<i class="glyph-icon icon-caret-down"></i>'), $("#product_name" + id).next("div").children("a").focus()
                                                    });
                                                }

                                            </script>
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Discount</label>
                                                <div class="col-sm-1">
                                                    <input onblur="setTwoNumberDecimal(this.id);" onkeyup="TotalInvoiceAmount();" type="number" name="total_discount" id="total_discount" class="form-control" placeholder="Discount">
                                                </div>
                                                <label class="col-sm-1 control-label">Tax</label>
                                                <div class="col-sm-1">
                                                    <input onblur="setTwoNumberDecimal(this.id);" onkeyup="TotalInvoiceAmount();" type="number" name="tax" id="tax" class="form-control" placeholder="Tax">
                                                </div>
                                                <label class="col-sm-2 control-label">Payment Status</label>
                                                <div class="col-sm-2">
                                                    <select name="payment_status" onchange="Validation()"  id="payment_status" class="chosen-select">
                                                        <option value="">Select Option</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Confirmed">Confirmed</option>

                                                    </select>
                                                </div>
                                                <label class="col-sm-2 control-label">Paying By</label>
                                                <div class="col-sm-2">
                                                    <select name="paying_by" onchange="Validation()"  id="paying_by" class="chosen-select">
                                                        <option value="">Select Option</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Bank">Bank</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Bilty No</label>
                                                <div class="col-sm-2">
                                                    <input  type="text" name="bilty_no" id="bilty_no" class="form-control" placeholder="Enter Bilty No">
                                                </div>

                                                <label class="col-sm-2 control-label">Purchase Voucher #</label>
                                                <div class="col-sm-2">
                                                    <input type="text" name="pv_no" id="pv_no" value=" <?= isset($last_purchase_no) ? strip_tags($last_purchase_no) : '' ?>" class="form-control" readonly=""  >
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-12">Description</label>
                                                <div class="col-sm-12">
                                                    <textarea name="desc" id="desc"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4 col-sm-0"></div>
                                                <button class="btn btn-alt btn-hover btn-blue-alt col-md-4" onclick="return ConfirmAdd();">
                                                    <span>CONFIRM ADD NEW PURCHASE</span>
                                                    <i class="glyph-icon icon-arrow-right"></i>
                                                </button>
                                                <div class="col-md-4 col-sm-0"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- JS Demo -->
            <script type="text/javascript" src="<?= base_url() ?>assets-minified/admin-all-demo.js"></script>
            <script src="<?= base_url() ?>ckeditor/ckeditor.js"></script>
            <script>
                                                    // Replace the <textarea id="editor1"> with a CKEditor
                                                    // instance, using default configuration.
                                                    CKEDITOR.replace('desc');
            </script>
            <script>
                function ConfirmAdd() {
                    var account = $("#account").val();
//                    var discount = $("#total_discount").val();
                    var payment_status = $("#payment_status").val();
                    var paying_by = $("#paying_by").val();
                    var err = false;
                    if (account == "" || account == null) {
                        $("#account_chosen").css("border", "1px solid red");
                        err = true;
                    }
//                    if (discount == "" || discount == null) {
//                        $("#total_discount").css("border", "1px solid red");
//                        err = true;
//                    }
                    if (payment_status == "" || payment_status == null) {
                        $("#payment_status_chosen").css("border", "1px solid red");
                        err = true;
                    }
                    if (paying_by == "" || paying_by == null) {
                        $("#paying_by_chosen").css("border", "1px solid red");
                        err = true;
                    }

                    var product_count = $(".prod").length;
                    if (product_count == 0) {
                        $("#error_msg").html("Please Enter atleast one product<br>");
                        err = true;
                    }
                    $(".prod").each(function (i) {
                        var p_name = $(this).find('[id^=product_name]').val();

                        var qty = $(this).find('[id^=qty]').val();
                        var purchase_price = $(this).find('[id^=purchase_price]').val();
                        if (p_name == null || p_name == 0) {
                            $("#product_name" + i + "_chosen").css("border", "1px solid red");
                            err = true;
                        }
                        if (qty == null || qty == 0) {
                            $("#qty" + i).css("border", "1px solid red");
                            err = true;
                        }
                        if (purchase_price == null || purchase_price == 0) {
                            $("#purchase_price" + i).css("border", "1px solid red");
                            err = true;
                        }
                    });


                    if (err === true) {
//                        alert("here");
                        return false;
                    } else {
//                        alert("no here");
                        $("#SubmitAdd").submit();
                    }
                }
                function Validation() {
                    var account = $("#account").val();
//                    var discount = $("#total_discount").val();
                    var payment_status = $("#payment_status").val();
                    var paying_by = $("#paying_by").val();
                    var err = false;

                    if (account !== "" & account !== null) {
                        $("#account_chosen").css("border", "1px solid #dfe8f1");
                    }
//                    if (discount == "" || discount == null) {
//                        $("#total_discount").css("border", "1px solid red");
//                        err = true;
//                    }
                    if (payment_status !== "" & payment_status !== null) {
                        $("#payment_status_chosen").css("border", "1px solid #dfe8f1");

                    }
                    if (paying_by !== "" & paying_by !== null) {
                        $("#paying_by_chosen").css("border", "1px solid #dfe8f1");

                    }

                    var product_count = $(".prod").length;
                    if (product_count !== 0) {
                        $("#error_msg").html("");

                    }
                    $(".prod").each(function (i) {
                        var p_name = $(this).find('[id^=product_name]').val();
//                        alert(p_name);
                        var qty = $(this).find('[id^=qty]').val();
                        var purchase_price = $(this).find('[id^=purchase_price]').val();
                        if (p_name !== null & p_name !== 0) {
                            $("#product_name" + i + "_chosen").css("border", "1px solid #dfe8f1");

                        }
                        if (qty !== null & qty !== 0) {
                            $("#qty" + i).css("border", "1px solid #dfe8f1");

                        }
                        if (purchase_price !== null & purchase_price !== 0) {
                            $("#purchase_price" + i).css("border", "1px solid #dfe8f1");

                        }
                    });

//                     if (err === true) {
// //                        alert("here");
//                         return false;
//                     } else {
// //                        alert("no here");
//                         $("#SubmitAdd").submit();
//                     }
                }

                function DelProd(myid_prod) {
                    myid_prod = "prod" + myid_prod;
                    $("#" + myid_prod).remove();
                }
            </script>



            <script type="text/javascript">
                $(document).ready(function () {
                    $("#date").bsdatepicker({
                        format: 'mm-dd-yyyy'
                    });

                    $('#date').on('changeDate', function (ev) {
                        $(this).bsdatepicker('hide');
                    });

                });
            </script>

        </div>
    </body>

    <!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/forms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:11:42 GMT -->
</html>